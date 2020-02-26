<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=populateAccountAddressToSalesAndServices

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class populateAccountAddressToSalesAndServices {

    function execute() {
        global $db;

        $res = $db->query("select id from accounts where deleted = '0';");
        while ($row = $db->fetchByAssoc($res)) {
            $accountBean = BeanFactory::retrieveBean('Accounts', $row['id'], array('disable_row_level_security' => true));
            if (!empty($accountBean->id)) {
                print('Before $accountBean->id : ' . print_r($accountBean->id, 1) . '<br>');
                print('Before $accountBean->name : ' . print_r($accountBean->name, 1) . '<br>');
                print('Before $accountBean->lon_c : ' . print_r($accountBean->lon_c, 1) . '<br>');
                print('Before $accountBean->lat_c : ' . print_r($accountBean->lat_c, 1) . '<br>');
                $beforeLon = $accountBean->lon_c;
                $beforeLat = $accountBean->lat_c;
                $this->updateRelatedSalesAndServices($accountBean);
                print('After $accountBean->lon_c : ' . print_r($accountBean->lon_c, 1) . '<br>');
                print('After $accountBean->lat_c : ' . print_r($accountBean->lat_c, 1) . '<br>');

                if ($beforeLon != $accountBean->lon_c || $beforeLat != $accountBean->lat_c) {
                    $updateQuery = "UPDATE accounts_cstm 
                    SET 
                        lon_c = '{$accountBean->lon_c}',
                        lat_c = '{$accountBean->lat_c}'
                    WHERE
                        id_c = '{$accountBean->id}'";
                    $db->query($updateQuery);
                    echo $updateQuery . "</br>";
                }
            }
            print '<br>' . '-----------------------------------' . '<br>';
        }
    }

    function updateRelatedSalesAndServices($bean) {
        // if lat long are not calculated or address changed
        if ($bean->different_service_site_c == 1) {
            $this->getLatLon($bean, $this->getAddress($bean, 'service_site', '_c'));
            $this->updateSalesAndServiceAddresses($bean, 'service_site', '_c', '_address_name');
        } else {
            $this->getLatLon($bean, $this->getAddress($bean));
            $this->updateSalesAndServiceAddresses($bean);
        }
    }

    function updateSalesAndServiceAddresses($bean, $type = 'shipping', $suffix = '', $addressNameField = '_address_third_party_name') {
        // Load related Sales and services...
        if ($bean->load_relationship('accounts_sales_and_services_1')) {
            $relatedSAS = $bean->accounts_sales_and_services_1->getBeans(array(), array('disable_row_level_security' => true));
            foreach ($relatedSAS as $salesAndService) {
                print('S&S name :: ' . $salesAndService->name . '<br>');
                $salesAndService = $this->updateSalesAndServiceAddress($bean, $salesAndService, $type, $suffix, $addressNameField);
                $salesAndService->save();
            }
        } else {
            echo 'Relationship is not loaded.' . '<br>';
        }
    }

    function updateSalesAndServiceAddress($bean, $salesAndService, $type, $suffix, $addressNameField) {
        $addressFieldsList = array(
            $type . '_address_street' . $suffix,
            $type . '_address_city' . $suffix,
            $type . '_address_state' . $suffix,
            $type . '_address_postalcode' . $suffix,
            $type . '_address_country' . $suffix,
        );

        foreach ($addressFieldsList as $key) {
            $_key = $key;
            if ($type == 'shipping') {
                $_key = $key . '_c';
            }

            $salesAndService->$_key = $bean->$key;
            print($_key . ' ' . $salesAndService->$_key . '<br>');
        }

        print('Before $salesAndService->lon_c : ' . print_r($salesAndService->lon_c, 1) . '<br>');
        print('Before $salesAndService->lat_c : ' . print_r($salesAndService->lat_c, 1) . '<br>');

        $salesAndService->lat_c = $bean->lat_c;
        $salesAndService->lon_c = $bean->lon_c;

        print('After $salesAndService->lon_c : ' . print_r($salesAndService->lon_c, 1) . '<br>');
        print('After $salesAndService->lat_c : ' . print_r($salesAndService->lat_c, 1) . '<br>');

        $salesAndService->{$type . $addressNameField} = $bean->{$type . $addressNameField};
        return $salesAndService;
    }

    function getAddress($bean, $prefix = 'shipping', $suffix = '') {
        return urlencode(
                $bean->{$prefix . '_address_street' . $suffix} . ', ' .
                $bean->{$prefix . '_address_city' . $suffix } . ', ' .
                $bean->{$prefix . '_address_state' . $suffix } . ', ' .
                $bean->{$prefix . '_address_postalcode' . $suffix} . ', ' .
                $bean->{$prefix . '_address_country' . $suffix});
    }

    function getLatLon($bean, $address) {
        if (!empty($address)) {
            $url = "https://api.opencagedata.com/geocode/v1/json?q={$address}&key=bb98ad0c915e4f479e3b11678e355461";
            $curl = curl_init($url);

            curl_setopt_array($curl, array(
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            if ($response !== false) {
                $res = json_decode($response, true);

                if (!empty($res['results'][0]['geometry'])) {
                    $latlon = $res['results'][0]['geometry'];
                    $bean->lat_c = $latlon['lat'];
                    $bean->lon_c = $latlon['lng'];
                }
            }
        }
    }

}

$init = new populateAccountAddressToSalesAndServices();
$init->execute();
echo '<br>';
echo 'Script Executed';
echo '<br>';
