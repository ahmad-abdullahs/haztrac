<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/ModuleApi.php");

class CustomModuleApi extends ModuleApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('ProductTemplates', '?'),
                'pathVars' => array('module', 'record'),
                'method' => 'updateRecord',
                'shortHelp' => 'This method updates a record of the specified type',
                'longHelp' => 'include/api/help/module_record_put_help.html',
            ),
        ));
    }

    public function updateRelatedRecords(ServiceBase $api, SugarBean $bean, array $args) {
        global $db, $timedate;
        $bundleToItemsMapping = array();

        if ($bean->is_group_item_c == true || $bean->is_group_item_c == 1) {
            // Maintain the bundle id and the childs so that we can manage the relationships later.
            list($args, $bundleToItemsMapping) = $this->getBundleToItemsMapping($bean, $args);
        }

        parent::updateRelatedRecords($api, $bean, $args);

        // In order to provide the delete and update functionality on the record view API is
        // customized for that...
        $relateArgs = $this->getRelatedRecordArguments($bean, $args, 'delete');
        // After the records are unlinked, delete those records permanently.
        foreach ($relateArgs as $linkName => $items) {
            if ($linkName == 'product_templates_product_templates_1')
                foreach ($items as $id) {
                    //Retrieve bean and delete it
                    $_bean = BeanFactory::retrieveBean('ProductTemplates', $id, array(
                                'disable_row_level_security' => true
                    ));
                    $_bean->mark_deleted($id);
                    $_bean->save();
                    unset($_bean);
                }
        }

        // Update the records.
        $relateArgs = $this->getRelatedRecordArguments($bean, $args, 'update');
        foreach ($relateArgs['product_templates_product_templates_1'] as $key => $value) {
            $this->updateRelatedProductTemplateRecords($api, $value);
        }

        // Set the relationships
        if (!empty($bundleToItemsMapping) && ($bean->is_group_item_c == true || $bean->is_group_item_c == 1)) {
            foreach ($bundleToItemsMapping as $key => $value) {
                if (!empty($value)) {
                    foreach ($value as $_key => $_value) {
                        $insert = "INSERT INTO product_templates_product_templates_1_c "
                                . "(`id`, `date_modified`, `deleted`, `product_templates_product_templates_1product_templates_ida`, `product_templates_product_templates_1product_templates_idb`) "
                                . "VALUES "
                                . "('" . create_guid() . "', '{$timedate->nowDb()}', '0', '{$key}', '{$_value}')";
                        $db->query($insert, true);
                    }
                    // Just retrieving and saving the bean so that the Sugar dependencies should be triggered 
                    // which has to be triggered after inserting the relationship through insert query.
                    $bundleBean = BeanFactory::retrieveBean('ProductTemplates', $key);
                    $bundleBean->save();
                }
            }
        }
    }

    public function getBundleToItemsMapping(SugarBean $bean, array $args) {
        $bundleToItemsMapping = array();
        $relateArgs = $this->getRelatedRecordArguments($bean, $args, 'create');

        foreach ($relateArgs['product_templates_product_templates_1'] as $key => $value) {
            if ($value['is_bundle_product_c'] == 'parent' && !array_key_exists($value['id'], $bundleToItemsMapping)) {
                $bundleToItemsMapping[$value['id']] = array();
            } elseif (substr($value['is_bundle_product_c'], 0, 9) == 'sub-child') {
                $explodedArr = explode(':', $value['is_bundle_product_c']);
                if (!empty($explodedArr[1])) {
                    if (array_key_exists($explodedArr[1], $bundleToItemsMapping)) {
                        $bundleToItemsMapping[$explodedArr[1]][] = $value['id'];
                    } else {
                        $bundleToItemsMapping[$explodedArr[1]] = array();
                        $bundleToItemsMapping[$explodedArr[1]][] = $value['id'];
                    }
                    $args['product_templates_product_templates_1']['create'][$key]['is_bundle_product_c'] = 'child';
                }
            }
        }

        return array($args, $bundleToItemsMapping);
    }

    public function updateRelatedProductTemplateRecords(ServiceBase $api, array $args) {
        foreach ($this->disabledUpdateFields as $field) {
            if (isset($args[$field])) {
                unset($args[$field]);
            }
        }

        $args['module'] = $args['_module'];
        $args['record'] = $args['id'];

        $api->action = 'view';
        $this->requireArgs($args, array('module', 'record'));

        $bean = BeanFactory::retrieveBean($args['module'], $args['record']);
        $api->action = 'save';

        // This if check is added to avoid the 500 internal server error, because when the bundle is deleted 
        // within the Group it sends the null as bean. (This record has already been deleted in the delete sequence of this call)
        if ($bean) {
            $id = $this->updateBean($bean, $api, $args);
        }
    }

}
