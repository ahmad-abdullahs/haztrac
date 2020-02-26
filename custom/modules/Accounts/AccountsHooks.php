<?php

class AccountsHooks {

    function beforeSave($bean, $event, $arguments) {
        // if lat long are not calculated or address changed
        if ($bean->different_service_site_c == 1) {
            if ((empty($bean->lat_c) ||
                    $bean->fetched_row['service_site_address_name'] != $bean->service_site_address_name ||
                    $bean->fetched_row['service_site_address_street_c'] != $bean->service_site_address_street_c ||
                    $bean->fetched_row['service_site_address_city_c'] != $bean->service_site_address_city_c ||
                    $bean->fetched_row['service_site_address_state_c'] != $bean->service_site_address_state_c ||
                    $bean->fetched_row['service_site_address_postalcode_c'] != $bean->service_site_address_postalcode_c ||
                    $bean->fetched_row['service_site_address_country_c'] != $bean->service_site_address_country_c)
            ) {
                $this->getLatLon($bean, $this->getAddress($bean, 'service_site', '_c'));
                $this->updateSalesAndServiceAddresses($bean, 'service_site', '_c', '_address_name');
            }
        } else {
            if ($bean->fetched_row['different_service_site_c'] != $bean->different_service_site_c) {
                $bean->lat_c = '';
            }
            if (empty($bean->lat_c) ||
                    $bean->fetched_row['shipping_address_third_party_name'] != $bean->shipping_address_third_party_name ||
                    $bean->fetched_row['shipping_address_street'] != $bean->shipping_address_street ||
                    $bean->fetched_row['shipping_address_city'] != $bean->shipping_address_city ||
                    $bean->fetched_row['shipping_address_state'] != $bean->shipping_address_state ||
                    $bean->fetched_row['shipping_address_postalcode'] != $bean->shipping_address_postalcode ||
                    $bean->fetched_row['shipping_address_country'] != $bean->shipping_address_country) {
                $this->getLatLon($bean, $this->getAddress($bean));
                $this->updateSalesAndServiceAddresses($bean);
            }
        }
    }

    private function updateSalesAndServiceAddresses($bean, $type = 'shipping', $suffix = '', $addressNameField = '_address_third_party_name') {
        // Load related Sales and services...
        $bean->load_relationship('accounts_sales_and_services_1');
        $relatedSAS = $bean->accounts_sales_and_services_1->getBeans();
        foreach ($relatedSAS as $salesAndService) {
            $salesAndService = $this->updateSalesAndServiceAddress($bean, $salesAndService, $type, $suffix, $addressNameField);
            $salesAndService->save();
        }
    }

    private function updateSalesAndServiceAddress($bean, $salesAndService, $type, $suffix, $addressNameField) {
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
        }

        $salesAndService->lat_c = $bean->lat_c;
        $salesAndService->lon_c = $bean->lon_c;

        $salesAndService->{$type . $addressNameField} = $bean->{$type . $addressNameField};
        return $salesAndService;
    }

    private function getAddress($bean, $prefix = 'shipping', $suffix = '') {
        return urlencode(
                $bean->{$prefix . '_address_street' . $suffix} . ', ' .
                $bean->{$prefix . '_address_city' . $suffix } . ', ' .
                $bean->{$prefix . '_address_state' . $suffix } . ', ' .
                $bean->{$prefix . '_address_postalcode' . $suffix} . ', ' .
                $bean->{$prefix . '_address_country' . $suffix});
    }

    private function getLatLon($bean, $address) {
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
