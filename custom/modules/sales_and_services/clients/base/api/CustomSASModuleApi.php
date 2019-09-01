<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/ModuleApi.php");

class CustomSASModuleApi extends ModuleApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('sales_and_services'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
                'shortHelp' => 'This method creates a new record of the specified type',
                'longHelp' => 'include/api/help/module_post_help.html',
            ),
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('sales_and_services', '?'),
                'pathVars' => array('module', 'record'),
                'method' => 'updateRecord',
                'shortHelp' => 'This method updates a record of the specified type',
                'longHelp' => 'include/api/help/module_record_put_help.html',
            ),
        ));
    }

    /**
     * Creates related records for the given bean
     *
     * @param ServiceBase $service
     * @param SugarBean $bean Primary bean
     * @param array $data New record data
     */
    protected function createRelatedRecords(ServiceBase $service, SugarBean $bean, array $data) {
        $api = $this->getRelateRecordApi();
        foreach ($data as $linkName => $records) {
            foreach ($records as $record) {
                $api->createRelatedRecord(
                        $service, array_merge($record, array(
                    'module' => $bean->module_name,
                    'record' => $bean->id,
                    'link_name' => $linkName), array(
                    'account_id' => $bean->accounts_sales_and_services_1accounts_ida
                                )
                ));
            }
        }
    }

}
