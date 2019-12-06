<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class getWasteProfileNum extends SugarApi {

    public function registerApiRest() {
        return array(
            //GET
            'getWasteProfileNum' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('getWasteProfileNum'),
                //endpoint variables
                // 'pathVars' => array(''),
                //method to call
                'method' => 'getWasteProfileNum',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Jump Max Waste Profile number by 3',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function getWasteProfileNum() {
        return $this->jumpWasteProfileNumBy3();
    }

    function jumpWasteProfileNumBy3() {
        $waste_profile_num_c = '';
        // Check if its new record
        $sql = <<<SQL
                    SELECT 
                        MAX(waste_profile_num_c) AS waste_profile_num_c
                    FROM
                        wpm_waste_profile_module_cstm;
SQL;
        global $db;

        $res = $db->query($sql);
        if ($res->num_rows > 0) {
            $row = $db->fetchByAssoc($res);
            // Get the number out of the string.
            preg_match_all('!\d+!', $row['waste_profile_num_c'], $matches);
            if (!empty($matches) && is_array($matches[0])) {
                $waste_profile_num_c = 'P-' . ((int) $matches[0][0] + 3);
            }
        }
        return $waste_profile_num_c;
    }

}
