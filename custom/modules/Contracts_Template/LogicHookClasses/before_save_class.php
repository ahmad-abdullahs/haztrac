<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    function before_save_method($bean, $event, $arguments) {
        $this->handleContractSpecificationField($bean, $event, $arguments);
    }

    function handleContractSpecificationField($bean, $event, $arguments) {
        if ($bean->contract_specification != $bean->fetched_row['contract_specification']) {
            // Fetch all the contract specification linked to this contract and delete those.
            // We are going to add the new ones
            // Delete the relationship link between contract specification and contract
            if ($bean->load_relationship('contracts_template_contract_specification')) {
                // Hard delete the records.
                $contractSpecificationBeans = $bean->contracts_template_contract_specification->getBeans();
                foreach ($contractSpecificationBeans as $contractSpecificationBean) {
                    $contractSpecificationBean->mark_deleted($contractSpecificationBean->id);
                    $contractSpecificationBean->save();
                }
            }

            // Add the relationship
            $contract_specification_decoded = json_decode($bean->contract_specification);
            foreach ($contract_specification_decoded as $key => $contract_specification_obj) {
                if (!empty($contract_specification_obj->contract_specification_name)) {
                    $contractSpecificationBean = BeanFactory::newBean('contract_specification');
                    $contractSpecificationBean->new_with_id = true;
                    $contractSpecificationBean->name = $contract_specification_obj->contract_specification_name;
//                    $contractSpecificationBean->text_name = $contract_specification_obj->contract_specification_text_name;
                    $contractSpecificationBean->text_details = $contract_specification_obj->contract_specification_text_details;
                    $contractSpecificationBean->contracts_template_contract_specificationcontracts_template_ida = $bean->id;
                    $contractSpecificationBean->assigned_user_id = $GLOBALS['current_user']->id;
                    $contractSpecificationBean->save();
                }
            }
        }
    }

}
