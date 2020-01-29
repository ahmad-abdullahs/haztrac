<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class getVendorPartNum extends SugarApi {

    public function registerApiRest() {
        return array(
            //GET
            'getVendorPartNum' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('getVendorPartNum'),
                //endpoint variables
                // 'pathVars' => array(''),
                //method to call
                'method' => 'getVendorPartNum',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Jump Max Vendor Part Number by 3',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function getVendorPartNum() {
        return $this->jumpVendorPartNumBy3();
    }

    function jumpVendorPartNumBy3() {
        // Check if its new record
        $vendor_part_num = 'V-4456210';

        $sql = <<<SQL
                    SELECT 
                        MAX(vendor_part_num) AS vendor_part_num
                    FROM
                        product_templates;
SQL;
        global $db;

        $res = $db->query($sql);
        if ($res->num_rows > 0) {
            $row = $db->fetchByAssoc($res);
            if (!empty($row['vendor_part_num']) && !is_null($row['vendor_part_num'])) {
                // Get the number out of the string.
                preg_match_all('!\d+!', $row['vendor_part_num'], $matches);
                if (!empty($matches) && is_array($matches[0])) {
                    $vendor_part_num = 'V-' . ((int) $matches[0][0] + 3);
                }
            }
        }

        return $vendor_part_num;
    }

}
