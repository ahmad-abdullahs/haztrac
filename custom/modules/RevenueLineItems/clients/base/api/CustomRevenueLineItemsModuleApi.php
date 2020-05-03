<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/ModuleApi.php");

class CustomRevenueLineItemsModuleApi extends ModuleApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('RevenueLineItems'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
                'shortHelp' => 'This method creates a new record of the specified type',
                'longHelp' => 'include/api/help/module_post_help.html',
            ),
        ));
    }

    public function createRecord(ServiceBase $api, array $args) {
        $bean = $this->createBean($api, $args);
        $data = $this->formatBeanAfterSave($api, $args, $bean);

        global $db;
        $ids = array();

        $selectRLIs = "SELECT 
                            revenuelineitems_revenuelineitems_1_c.id,
                            revenuelineitems_revenuelineitems_1_c.revenuelineitems_revenuelineitems_1revenuelineitems_idb
                        FROM
                            revenuelineitems_revenuelineitems_1_c
                        WHERE
                            revenuelineitems_revenuelineitems_1revenuelineitems_ida = '{$bean->id}'
                                AND deleted = 0;";
        $result = $db->query($selectRLIs);
        while ($row = $db->fetchByAssoc($result)) {
            array_push($ids, $row['revenuelineitems_revenuelineitems_1revenuelineitems_idb']);
        }

        if (!empty($ids)) {
            $updateIsBundleProduct = "UPDATE revenue_line_items_cstm SET  is_bundle_product_c = 'child' WHERE id_c in ('" . implode("' , '", $ids) . "')";
            $db->query($updateIsBundleProduct);
        }

        return $data;
    }

}
