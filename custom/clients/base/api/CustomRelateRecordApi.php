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
        }

        return $this->formatNearAndFarRecords($api, $args, $primaryBean, $relatedArray);
    }

}
