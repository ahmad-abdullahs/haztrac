<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/FilterApi.php");

class CustomFilterApi extends FilterApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'filterModuleGet' => array(
                'reqType' => 'GET',
                'path' => array('ProductTemplates', 'filter'),
                'pathVars' => array('module', ''),
                'method' => 'filterList',
                'jsonParams' => array('filter'),
                'shortHelp' => 'Lists filtered records.',
                'longHelp' => 'include/api/help/module_filter_get_help.html',
                'exceptions' => array(
                    // Thrown in getPredefinedFilterById
                    'SugarApiExceptionNotFound',
                    'SugarApiExceptionError',
                    // Thrown in filterList and filterListSetup
                    'SugarApiExceptionInvalidParameter',
                    // Thrown in filterListSetup, getPredefinedFilterById, and parseArguments
                    'SugarApiExceptionNotAuthorized',
                ),
            ),
            'filterModuleAll' => array(
                'reqType' => 'GET',
                'path' => array('ProductTemplates'),
                'pathVars' => array('module'),
                'method' => 'filterList',
                'jsonParams' => array('filter'),
                'shortHelp' => 'List of all records in this module',
                'longHelp' => 'include/api/help/module_filter_get_help.html',
                'exceptions' => array(
                    // Thrown in getPredefinedFilterById
                    'SugarApiExceptionNotFound',
                    'SugarApiExceptionError',
                    // Thrown in filterList and filterListSetup
                    'SugarApiExceptionInvalidParameter',
                    // Thrown in filterListSetup, getPredefinedFilterById, and parseArguments
                    'SugarApiExceptionNotAuthorized',
                ),
            ),
            'filterModulePost' => array(
                'reqType' => 'POST',
                'path' => array('ProductTemplates', 'filter'),
                'pathVars' => array('module', ''),
                'method' => 'filterList',
                'shortHelp' => 'Lists filtered records.',
                'longHelp' => 'include/api/help/module_filter_post_help.html',
                'exceptions' => array(
                    // Thrown in getPredefinedFilterById
                    'SugarApiExceptionNotFound',
                    'SugarApiExceptionError',
                    // Thrown in filterList and filterListSetup
                    'SugarApiExceptionInvalidParameter',
                    // Thrown in filterListSetup, getPredefinedFilterById, and parseArguments
                    'SugarApiExceptionNotAuthorized',
                ),
            ),
            'filterModuleAllCount' => array(
                'reqType' => 'GET',
                'path' => array('ProductTemplates', 'count'),
                'pathVars' => array('module', ''),
                'jsonParams' => array('filter'),
                'method' => 'getFilterListCount',
                'shortHelp' => 'List of all records in this module',
                'longHelp' => 'include/api/help/module_filter_get_help.html',
                'exceptions' => array(
                    // Thrown in getPredefinedFilterById
                    'SugarApiExceptionNotFound',
                    'SugarApiExceptionError',
                    // Thrown in filterListSetup and getPredefinedFilterById
                    'SugarApiExceptionNotAuthorized',
                    // Thrown in filterListSetup
                    'SugarApiExceptionInvalidParameter',
                ),
            ),
            'filterModulePostCount' => array(
                'reqType' => 'POST',
                'path' => array('ProductTemplates', 'filter', 'count'),
                'pathVars' => array('module', '', ''),
                'method' => 'filterListCount',
                'shortHelp' => 'Lists filtered records.',
                'longHelp' => 'include/api/help/module_filter_post_help.html',
                'exceptions' => array(
                    // Thrown in getPredefinedFilterById
                    'SugarApiExceptionNotFound',
                    'SugarApiExceptionError',
                    // Thrown in filterListSetup and getPredefinedFilterById
                    'SugarApiExceptionNotAuthorized',
                    // Thrown in filterListSetup
                    'SugarApiExceptionInvalidParameter'
                ),
            ),
            'filterModuleCount' => array(
                'reqType' => 'GET',
                'path' => array('ProductTemplates', 'filter', 'count'),
                'pathVars' => array('module', '', ''),
                'method' => 'getFilterListCount',
                'shortHelp' => 'Lists filtered records.',
                'longHelp' => 'include/api/help/module_filter_post_help.html',
                'exceptions' => array(
                    // Thrown in getPredefinedFilterById
                    'SugarApiExceptionNotFound',
                    'SugarApiExceptionError',
                    // Thrown in filterListSetup
                    'SugarApiExceptionNotAuthorized',
                    'SugarApiExceptionInvalidParameter'
                ),
            ))
        );
    }

    public function addStandaloneProductsFilter($args) {
        if (!isset($args['filter'])) {
            $args = array_merge($args, array('filter' => array()));
        }

        // we need all Product Templates on default list view except for the child ones.
        array_push($args['filter'], array(
            'is_bundle_product_c' => array(
                '$not_in' => array(
                    'child',
                ),
            ),
            'vendor_only_c' => array(
                '$not_in' => array(
                    '1',
                ),
            ),
        ));
        return $args;
    }

    public function filterListCount(ServiceBase $api, array $args) {
        $args = $this->addStandaloneProductsFilter($args);
        return parent::filterListCount($api, $args);
    }

    public function getFilterListCount(ServiceBase $api, array $args) {
        $args = $this->addStandaloneProductsFilter($args);
        return parent::getFilterListCount($api, $args);
    }

    public function filterList(ServiceBase $api, array $args, $acl = 'list') {
        $args = $this->addStandaloneProductsFilter($args);
        return parent::filterList($api, $args, $acl);
    }

}
