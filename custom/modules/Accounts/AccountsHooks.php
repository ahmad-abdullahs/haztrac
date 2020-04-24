<?php

class AccountsHooks {

    function beforeSave($bean, $event, $arguments) {
        // if lat long are not calculated or address changed
        if ($bean->shipping_address_plus_code_cb == 1) {
            $bean->lat_c = $bean->shipping_address_lat;
            $bean->lon_c = $bean->shipping_address_lon;
            // Important thing to remember here is that, it will update all the address fields, 
            // regular address fields and extra address fields as well.
            // The reason is that, this might be possible that user has updated regular and extra fields both,
            // So in-order to be on the safe side we have updated all the fields.
            $this->updateSalesAndServiceAddresses($bean, true);
        } else if ($bean->service_site_address_plus_code_cb == 1) {
            $bean->lat_c = $bean->service_site_address_lat;
            $bean->lon_c = $bean->service_site_address_lon;
            $this->updateSalesAndServiceAddresses($bean, true, 'service_site', '_c', '_address_name');
        } else if ($bean->different_service_site_c == 1) {
            if ($bean->fetched_row['service_site_address_plus_code_cb'] != $bean->service_site_address_plus_code_cb) {
                $bean->lat_c = '';
            }
            if ((empty($bean->lat_c) ||
                    $bean->fetched_row['service_site_address_name'] != $bean->service_site_address_name ||
                    $bean->fetched_row['service_site_address_street_c'] != $bean->service_site_address_street_c ||
                    $bean->fetched_row['service_site_address_city_c'] != $bean->service_site_address_city_c ||
                    $bean->fetched_row['service_site_address_state_c'] != $bean->service_site_address_state_c ||
                    $bean->fetched_row['service_site_address_postalcode_c'] != $bean->service_site_address_postalcode_c ||
                    $bean->fetched_row['service_site_address_country_c'] != $bean->service_site_address_country_c)
            ) {
                $this->getLatLon($bean, $this->getAddress($bean, 'service_site', '_c'));
                $this->updateSalesAndServiceAddresses($bean, false, 'service_site', '_c', '_address_name');
            }
        } else {
            if ($bean->fetched_row['different_service_site_c'] != $bean->different_service_site_c ||
                    // Let say if checkbox was checked but user has unchecked it, so we have to 
                    // go back to the original address co-ordinates.
                    $bean->fetched_row['shipping_address_plus_code_cb'] != $bean->shipping_address_plus_code_cb) {
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

    private function updateSalesAndServiceAddresses($bean, $extraFieldToCopy = false, $type = 'shipping', $suffix = '', $addressNameField = '_address_third_party_name') {
        // Load related Sales and services...
        $bean->load_relationship('accounts_sales_and_services_1');
        $relatedSAS = $bean->accounts_sales_and_services_1->getBeans();
        foreach ($relatedSAS as $salesAndService) {
            $salesAndService = $this->updateSalesAndServiceAddress($bean, $extraFieldToCopy, $salesAndService, $type, $suffix, $addressNameField);
            $salesAndService->save();
        }
    }

    private function updateSalesAndServiceAddress($bean, $extraFieldToCopy, $salesAndService, $type, $suffix, $addressNameField) {
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

        if ($extraFieldToCopy) {
            $extraFieldsList = array(
                $type . '_address_plus_code_cb',
                $type . '_address_plus_code_val',
                $type . '_address_lat',
                $type . '_address_lon',
            );
            foreach ($extraFieldsList as $key) {
                $salesAndService->$key = $bean->$key;
            }
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

//    private function getLatLon($bean, $address) {
//        if (!empty($address)) {
//            $url = "https://api.opencagedata.com/geocode/v1/json?q={$address}&key=bb98ad0c915e4f479e3b11678e355461";
//            $curl = curl_init($url);
//
//            curl_setopt_array($curl, array(
//                CURLOPT_HEADER => false,
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_TIMEOUT => 10,
//                CURLOPT_SSL_VERIFYPEER => 0,
//                CURLOPT_SSL_VERIFYHOST => 0,
//            ));
//
//            $response = curl_exec($curl);
//            curl_close($curl);
//
//            if ($response !== false) {
//                $res = json_decode($response, true);
//
//                if (!empty($res['results'][0]['geometry'])) {
//                    $latlon = $res['results'][0]['geometry'];
//                    $bean->lat_c = $latlon['lat'];
//                    $bean->lon_c = $latlon['lng'];
//                }
//            }
//        }
//    }

    private function getLatLon($bean, $address) {
        if (!empty($address)) {
            $url = "https://maps.google.com/maps/api/geocode/json?sensor=false&key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o&address=" . $address;
            $curl = curl_init($url);

            curl_setopt_array($curl, array(
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
            ));

            $response = curl_exec($curl);
            $response = json_decode($response);
            curl_close($curl);

            if ($response->status == 'OK') {
                $latitude = $response->results[0]->geometry->location->lat;
                $longitude = $response->results[0]->geometry->location->lng;
                $bean->lat_c = $latitude;
                $bean->lon_c = $longitude;
            }
        }
    }

}
