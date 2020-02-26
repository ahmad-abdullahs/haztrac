<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    function before_save_method($bean, $event, $arguments) {
        // New record,
        // This code is added if the record is created from some script via bean so the auto increment
        // number should be added to the record.
        if (!isset($bean->fetched_row['id'])) {
            $bean->contract_number_c = $this->jumpContarctNumBy15();
        }
        $this->handleContractSpecificationField($bean, $event, $arguments);
    }

    function jumpContarctNumBy15() {
        // Check if its new record
        $contract_number = 'BT20-0032';

        $sql = <<<SQL
                    SELECT 
                        MAX(contract_number_c) AS contract_number_c
                    FROM
                        contracts_cstm;
SQL;
        global $db;

        $res = $db->query($sql);
        if ($res->num_rows > 0) {
            $row = $db->fetchByAssoc($res);
            if (!empty($row['contract_number_c']) && !is_null($row['contract_number_c'])) {
                // Get the number out of the string.
                preg_match_all('!\d+!', $row['contract_number_c'], $matches);
                if (!empty($matches) && is_array($matches[0])) {
                    if ((int) $matches[0][0] == substr(date("Y"), -2)) {
                        // Get last 2 digit of the year.
                        // Fill the number by leadinf zeros.
                        $contract_number = 'BT' . substr(date("Y"), -2) . '-' . sprintf("%04d", ((int) $matches[0][1] + 15));
                    } else {
                        $contract_number = 'BT' . substr(date("Y"), -2) . '-0001';
                    }
                }
            }
        }

        return $contract_number;
    }

    function handleContractSpecificationField($bean, $event, $arguments) {
        if ($bean->contract_specification != $bean->fetched_row['contract_specification']) {
            // Fetch all the contract specification linked to this contract and delete those.
            // We are going to add the new ones
            // Delete the relationship link between contract specification and contract
            if ($bean->load_relationship('contracts_contract_specification_1')) {
                // Hard delete the records.
                $contractSpecificationBeans = $bean->contracts_contract_specification_1->getBeans();
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
                    $contractSpecificationBean->contracts_contract_specification_1contracts_ida = $bean->id;
                    $contractSpecificationBean->assigned_user_id = $GLOBALS['current_user']->id;
                    $contractSpecificationBean->save();
                }
            }
        }
    }

}
