<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/RelateApi.php");

class CustomProductTemplatesRelateApi extends RelateApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'listRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('ProductTemplates', '?', 'link', 'product_templates_product_templates_1'),
                'pathVars' => array('module', 'record', '', 'link_name'),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => 'Lists related records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
        ));
    }

    public function filterRelated(ServiceBase $api, array $args) {
        if ($args['link_name'] == 'product_templates_product_templates_1') {
            // If order by is already set to line_number:desc || line_number:asc, it's fine. Otherwise set the order to line_number:asc
            if (isset($args['order_by'])) {
                $orderBy = explode(':', $args['order_by']);
                if (count($orderBy)) {
                    if ($orderBy[0] != 'line_number') {
                        $args['order_by'] = 'line_number:asc';
                    }
                } else {
                    $args['order_by'] = 'line_number:asc';
                }
            }
        }

        $data = parent::filterRelated($api, $args);

        foreach ($data['records'] as $key => $value) {
            if (!empty($value['v_vendors_id_c'])) {
                global $db;
                $sql = "SELECT 
                    accounts.id,
                    accounts.name
                FROM
                    accounts
                WHERE
                    accounts.id ='" . $value['v_vendors_id_c'] . "'
                        AND accounts.deleted = '0'";

                $result = $db->query($sql);

                while ($row = $db->fetchByAssoc($result)) {
                    $data['records'][$key]['product_vendor_c'] = ($row['name']);
                }
            }
        }

        return $data;
    }

}
