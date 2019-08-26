<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/ModuleApi.php");

class CustomSASModuleApi extends ModuleApi {

    public function registerApiRest() {
        return parent::registerApiRest();
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
                    'account_id' => $bean->accounts_sales_and_services_1accounts_ida)
                ));
            }
        }
    }

}
