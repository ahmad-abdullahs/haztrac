<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=populateBillingAndShippingNames

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('include/entryPoint.php');

class populateBillingAndShippingNames {

    public function __construct() {
        $this->updateBillingAndShippingNames();
    }

    private function updateBillingAndShippingNames() {
        global $db;
        $ids = array();

        $selectAccounts = "SELECT 
                            accounts.id AS id
                        FROM
                            accounts
                        WHERE
                            ((billing_address_third_party_name = ''
                                OR billing_address_third_party_name IS NULL)
                                OR (shipping_address_third_party_name = ''
                                OR shipping_address_third_party_name IS NULL))
                                AND deleted = 0;";
        $result = $db->query($selectAccounts);
        while ($row = $db->fetchByAssoc($result)) {
            array_push($ids, $row['id']);
        }
        $updateQuery = "UPDATE accounts 
                    SET 
                        billing_address_third_party_name = name,
                        shipping_address_third_party_name = name
                    WHERE
                        id IN ('" . implode("' , '", $ids) . "');";
        $db->query($updateQuery);
        echo $updateQuery . "</br>";
    }

}

$obj = new populateBillingAndShippingNames();
echo('Script excuted successfully');
