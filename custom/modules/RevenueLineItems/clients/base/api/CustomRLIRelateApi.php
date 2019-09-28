<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/RelateApi.php");

class CustomRLIRelateApi extends RelateApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'listRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('RevenueLineItems', '?', 'link', 'revenuelineitems_revenuelineitems_1'),
                'pathVars' => array('module', 'record', '', 'link_name'),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => 'Lists related records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
        ));
    }

    public function filterRelated(ServiceBase $api, array $args) {
        if ($args['link_name'] == 'revenuelineitems_revenuelineitems_1') {
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
        return parent::filterRelated($api, $args);
    }

}
