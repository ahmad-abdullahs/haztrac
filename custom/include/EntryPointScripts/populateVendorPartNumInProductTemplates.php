<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=populateVendorPartNumInProductTemplates

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('include/entryPoint.php');

class populateVendorPartNumInProductTemplates {

    public function __construct() {
        $this->updateVendorPartNum();
    }

    private function updateVendorPartNum() {
        global $db;
        $ids = array();

        $selectProductTemplates = "SELECT 
                        id, name, vendor_part_num
                    FROM
                        product_templates
                    WHERE
                        deleted = 0;";
        $result = $db->query($selectProductTemplates);
        while ($row = $db->fetchByAssoc($result)) {
            $vendor_part_num = $this->getVendorPartNum();
            
            $updateQuery = "UPDATE product_templates 
                    SET 
                        vendor_part_num = '{$vendor_part_num}'
                    WHERE
                        id = '{$row['id']}';";
            $db->query($updateQuery);
            echo $updateQuery . "</br>";
        }
    }

    private function getVendorPartNum() {
        return $this->jumpVendorPartNumBy3();
    }

    private function jumpVendorPartNumBy3() {
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

$obj = new populateVendorPartNumInProductTemplates();
echo('Script excuted successfully');
