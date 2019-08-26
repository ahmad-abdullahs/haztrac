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

        $id = $this->updateBean($bean, $api, $args);
    }

}
