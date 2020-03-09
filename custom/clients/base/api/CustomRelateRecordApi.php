<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/RelateRecordApi.php");

class CustomRelateRecordApi extends RelateRecordApi {

    public function registerApiRest() {
        return parent::registerApiRest();
    }

    public function createRelatedLinks(ServiceBase $api, array $args, $securityTypeLocal = 'view', $securityTypeRemote = 'view') {
        $this->requireArgs($args, array('ids'));
        $ids = $this->normalizeLinkIds($args['ids']);

        $result = array(
            'related_records' => array(),
        );

        $primaryBean = $this->loadBean($api, $args);

        list($linkName) = $this->checkRelatedSecurity(
                $api, $args, $primaryBean, $securityTypeLocal, $securityTypeRemote
        );
        $relatedModuleName = $primaryBean->$linkName->getRelatedModuleName();

        foreach ($ids as $id => $additionalValues) {
            $relatedBean = BeanFactory::retrieveBean($relatedModuleName, $id);

            if (!$relatedBean || $relatedBean->deleted) {
                throw new SugarApiExceptionNotFound('Could not find the related bean');
            }

            $relatedData = $this->getRelatedFields($api, $args, $primaryBean, $linkName, $relatedBean);

            $primaryBean->$linkName->add(array($relatedBean), array_merge($relatedData, $additionalValues));

            // ++
            // Code is added to create the RevenueLineItems relationship with account when the RevenueLineItems is 
            // selected from the selection list, the account will be the parent record account on which the selection
            // drawer is pulled up.
            if ($relatedBean->module_dir == 'RevenueLineItems') {
                if ($args['module'] == 'sales_and_services' || $args['module'] == 'RevenueLineItems') {
                    $relatedBean = BeanFactory::retrieveBean($relatedBean->module_dir, $relatedBean->id);
                    $relatedBean->load_relationship('account_link');
                    $relatedBean->account_link->add($additionalValues['account_id']);
                }
            }
            $result['related_records'][] = $this->formatBean($api, $args, $relatedBean);
        }
        //Clean up any hanging related records.
        SugarRelationship::resaveRelatedBeans();

        $result['record'] = $this->formatBean($api, $args, $primaryBean);

        return $result;
    }

    public function createRelatedRecord(ServiceBase $api, array $args) {
        $primaryBean = $this->loadBean($api, $args);
        list($linkName) = $this->checkRelatedSecurity($api, $args, $primaryBean, 'view', 'create');

        /** @var Link2 $link */
        $link = $primaryBean->$linkName;
        $module = $link->getRelatedModuleName();
        $moduleApi = $this->getModuleApi($api, $module);
        $moduleApiArgs = $this->getModuleApiArgs($args, $module);
        $relatedBean = $moduleApi->createBean($api, $moduleApiArgs, array(
            'not_use_rel_in_req' => true,
            'new_rel_id' => $primaryBean->id,
            'new_rel_relname' => $link->getLinkForOtherSide(),
        ));

        $args['remote_id'] = $relatedBean->id;
        $relatedArray = $this->getRelatedRecord($api, $args);

        // ++
        // This function is overriden to set the child attribute for the related rli's of a bundle, 
        // when a bundle is created from Revenuelineitems subpanel under Accounts, Sales and Service, Opp and 
        if (isset($args['executeBundleLogic']) && $args['executeBundleLogic'] == 1 &&
                $relatedBean->module_dir == "RevenueLineItems") {
            global $db;
            $ids = array();

            $selectAccounts = "SELECT 
                            revenuelineitems_revenuelineitems_1_c.id,
                            revenuelineitems_revenuelineitems_1_c.revenuelineitems_revenuelineitems_1revenuelineitems_idb
                        FROM
                            revenuelineitems_revenuelineitems_1_c
                        WHERE
                            revenuelineitems_revenuelineitems_1revenuelineitems_ida = '{$relatedBean->id}'
                                AND deleted = 0;";
            $result = $db->query($selectAccounts);
            while ($row = $db->fetchByAssoc($result)) {
                array_push($ids, $row['revenuelineitems_revenuelineitems_1revenuelineitems_idb']);
            }

            $updateIsBundleProduct = "UPDATE revenue_line_items_cstm SET  is_bundle_product_c = 'child' WHERE id_c in ('" . implode("' , '", $ids) . "')";
            $db->query($updateIsBundleProduct);
        } else if (isset($args['executeGroupLogic']) && $args['executeGroupLogic'] == 1 &&
                $relatedBean->module_dir == "RevenueLineItems") {
            global $db, $timedate;
            $bundleToItemsMapping = array();
            $childIds = array();
            $parentIds = array();
            $allItemIds = array();

            // Maintain the bundle id and the childs so that we can manage the relationships later.
            list($allItemIds, $bundleToItemsMapping) = $this->getBundleToItemsMapping($args);

            // Set the relationships
            foreach ($bundleToItemsMapping as $key => $value) {
                if (!empty($value)) {
                    $queryValues = array();
                    $insert = '';
                    $insert .= "INSERT INTO revenuelineitems_revenuelineitems_1_c "
                            . "(`id`, `date_modified`, `deleted`, `revenuelineitems_revenuelineitems_1revenuelineitems_ida`, `revenuelineitems_revenuelineitems_1revenuelineitems_idb`) "
                            . "VALUES ";
                    foreach ($value as $_key => $_value) {
                        array_push($queryValues, "('" . create_guid() . "', '{$timedate->nowDb()}', '0', '{$key}', '{$_value}')");
                    }

                    if (!empty($queryValues)) {
                        $insert .= implode(" , ", $queryValues) . ';';
                        $db->query($insert, true);
                    }
                    array_push($childIds, $value);
                    array_push($parentIds, $key);
                    // Just retrieving and saving the bean so that the Sugar dependencies should be triggered 
                    // which has to be triggered after inserting the relationship through insert query.
                    $rliBean = BeanFactory::retrieveBean('RevenueLineItems', $key);
                    $rliBean->save();
                }
            }

            $childIds = $this->flattenArr($childIds);

            // Setting the RLIs is_bundle_product_c.
            // First make all of the is_bundle_product_c empty, then set the parent and child.
            $update = '';
            if (!empty($allItemIds)) {
                $update = "UPDATE revenue_line_items_cstm SET is_bundle_product_c='' WHERE id_c IN ('" . implode("' , '", $allItemIds) . "');";
                $db->query($update, true);
            }
            if (!empty($parentIds)) {
                $update = "UPDATE revenue_line_items_cstm SET is_bundle_product_c='parent' WHERE id_c IN ('" . implode("' , '", $parentIds) . "');";
                $db->query($update, true);
            }
            if (!empty($childIds)) {
                $update = "UPDATE revenue_line_items_cstm SET is_bundle_product_c='child' WHERE id_c IN ('" . implode("' , '", $childIds) . "');";
                $db->query($update, true);
            }

            // Removing the Group relationships.
            $update = "UPDATE revenuelineitems_revenuelineitems_1_c SET deleted='1' WHERE revenuelineitems_revenuelineitems_1revenuelineitems_ida = '{$relatedBean->id}';";
            $db->query($update, true);

            // Deleting the Group record.
            $update = "UPDATE revenue_line_items SET deleted='1' WHERE id = '{$relatedBean->id}';";
            $db->query($update, true);
        }

        return $this->formatNearAndFarRecords($api, $args, $primaryBean, $relatedArray);
    }

    public function flattenArr($childIds) {
        $retArr = array();
        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($childIds));
        foreach ($it as $v) {
            array_push($retArr, $v);
        }
        return $retArr;
    }

    public function getBundleToItemsMapping(array $args) {
        $bundleToItemsMapping = array();
        $allItemIds = array();

        foreach ($args['revenuelineitems_revenuelineitems_1']['create'] as $key => $value) {
            array_push($allItemIds, $value['id']);
            if ($value['is_bundle_product_c'] == 'parent' && !array_key_exists($value['id'], $bundleToItemsMapping)) {
                $bundleToItemsMapping[$value['id']] = array();
            } elseif ($value['is_bundle_product_c'] == 'child' && isset($value['revenuelineitems_revenuelineitems_1revenuelineitems_ida'])) {
                $bundleId = $value['revenuelineitems_revenuelineitems_1revenuelineitems_ida'];
                if (!empty($bundleId)) {
                    if (array_key_exists($bundleId, $bundleToItemsMapping)) {
                        $bundleToItemsMapping[$bundleId][] = $value['id'];
                    } else {
                        $bundleToItemsMapping[$bundleId] = array();
                        $bundleToItemsMapping[$bundleId][] = $value['id'];
                    }
                }
            }
        }

        return array($allItemIds, $bundleToItemsMapping);
    }

}
