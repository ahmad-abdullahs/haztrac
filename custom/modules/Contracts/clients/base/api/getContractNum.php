<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class getContractNum extends SugarApi {

    public function registerApiRest() {
        return array(
            //GET
            'getContractNum' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('getContractNum'),
                //endpoint variables
                // 'pathVars' => array(''),
                //method to call
                'method' => 'getContractNum',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Jump Contract Number by 15',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function getContractNum() {
        return $this->jumpContarctNumBy15();
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
                $GLOBALS['log']->fatal('$matches : ' . print_r($matches, 1));
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

}
