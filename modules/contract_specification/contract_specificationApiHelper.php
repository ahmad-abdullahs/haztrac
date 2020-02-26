<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

class contract_specificationApiHelper extends SugarBeanApiHelper {

    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);
        $data = $this->formatForContractSpecifications($bean, $fieldList, $data);
        return $data;
    }

    public function formatForContractSpecifications($bean, $fieldList, $data) {
        if (empty($fieldList) || in_array('contract_specification', $fieldList)) {
            // Pushing Contract Specification data in Contract Model
            $data['contract_specification'] = array();

            $sql = <<<SQL
                    SELECT 
                    contract_specification.name AS 'contract_specification_name',
                    contract_specification.text_details AS 'contract_specification_text_details'
                FROM
                    contracts_contract_specification_1_c contracts_contract_specification_1_c
                        INNER JOIN
                    contract_specification contract_specification ON 
                        contracts_contract_specification_1_c.contracts_contract_specification_1contract_specification_idb = contract_specification.id
                        AND contracts_contract_specification_1_c.deleted = '0'
                        AND contract_specification.deleted = '0'
                WHERE
                    contracts_contract_specification_1_c.contracts_contract_specification_1contracts_ida = '{$bean->id}' 
                ORDER BY contract_specification.name
SQL;
            global $db;

            $res = $db->query($sql);
            while ($row = $db->fetchByAssoc($res)) {
                $data['contract_specification'][] = $row;
            }

            $data['contract_specification'] = json_encode($data['contract_specification']);
        }

        return $data;
    }

}
