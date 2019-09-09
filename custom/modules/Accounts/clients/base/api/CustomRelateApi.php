<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/RelateApi.php");

class CustomRelateApi extends RelateApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'listRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('Accounts', '?', 'link', 'revenuelineitems'),
                'pathVars' => array('module', 'record', '', 'link_name'),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => 'Lists related records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
            'listRelatedRecordsCount' => array(
                'reqType' => 'GET',
                'path' => array('Accounts', '?', 'link', 'revenuelineitems', 'count'),
                'pathVars' => array('module', 'record', '', 'link_name', ''),
                'jsonParams' => array('filter'),
                'method' => 'filterRelatedCount',
                'shortHelp' => 'Counts all filtered related records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
            'listRelatedRecordsLeanCount' => array(
                'reqType' => 'GET',
                'minVersion' => '11.4',
                'path' => array('Accounts', '?', 'link', 'revenuelineitems', 'leancount'),
                'pathVars' => array('module', 'record', '', 'link_name', ''),
                'jsonParams' => array('filter'),
                'method' => 'filterRelatedLeanCount',
                'shortHelp' => 'Gets the "lean" count of related items.' .
                'The count should always be in the range: 0..max_num. ' .
                'The response has a boolean flag "has_more" that defines if there are more rows, ' .
                'than max_num parameter value.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
        ));
    }

    public function filterRelated(ServiceBase $api, array $args) {
        $args = $this->excludeChildRecords($args);
        return parent::filterRelated($api, $args);
    }

    public function filterRelatedCount(ServiceBase $api, array $args) {
        $args = $this->excludeChildRecords($args);
        return parent::filterRelatedCount($api, $args);
    }

    public function filterRelatedLeanCount(ServiceBase $api, array $args) {
        $args = $this->excludeChildRecords($args);
        return parent::filterRelatedLeanCount($api, $args);
    }

    /*
     * Add filter in the argument to exclude the child linked records 
     */

    public function excludeChildRecords($args) {
        if ($args['link_name'] == 'revenuelineitems') {
            if (!isset($args['filter'])) {
                $args = array_merge($args, array('filter' => array()));
            }
            array_push($args['filter'], array(
                'is_bundle_product_c' => array(
                    '$not_in' => array('child'),
                ),
                'rli_as_template_c' => array(
                    '$equals' => true,
                ),
            ));
        }
        return $args;
    }

}
