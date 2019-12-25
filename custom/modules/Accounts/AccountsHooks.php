<?php

class AccountsHooks {

    function beforeSave($bean, $event, $arguments) {
        $accountTypesList = unencodeMultienum($bean->account_type_cst_c);

        // if lat long are not calculated or address changed
        if ((empty($bean->lat_c) ||
                $bean->fetched_row['service_site_address_street_c'] != $bean->service_site_address_street_c ||
                $bean->fetched_row['service_site_address_city_c'] != $bean->service_site_address_city_c ||
                $bean->fetched_row['service_site_address_state_c'] != $bean->service_site_address_state_c ||
                $bean->fetched_row['service_site_address_postalcode_c'] != $bean->service_site_address_postalcode_c ||
                $bean->fetched_row['service_site_address_country_c'] != $bean->service_site_address_country_c) &&
                (in_array('Separate Svc Site', $accountTypesList) && $bean->different_service_site_c == 1)) {
            $GLOBALS['log']->fatal('I am in 111 ...');
            $this->getLatLon($bean, $this->getAddress($bean, 'service_site', '_c'));
        } else if (empty($bean->lat_c) ||
                $bean->fetched_row['shipping_address_street'] != $bean->shipping_address_street ||
                $bean->fetched_row['shipping_address_city'] != $bean->shipping_address_city ||
                $bean->fetched_row['shipping_address_state'] != $bean->shipping_address_state ||
                $bean->fetched_row['shipping_address_postalcode'] != $bean->shipping_address_postalcode ||
                $bean->fetched_row['shipping_address_country'] != $bean->shipping_address_country) {
            $GLOBALS['log']->fatal('I am in 222 ...');
            $this->getLatLon($bean, $this->getAddress($bean));
        }
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
        $GLOBALS['log']->fatal('$address : ' . print_r($address, 1));
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

                $GLOBALS['log']->fatal('$res : ' . print_r($res, 1));

                if (!empty($res['results'][0]['geometry'])) {
                    $latlon = $res['results'][0]['geometry'];

                    $GLOBALS['log']->fatal('$latlon : ' . print_r($latlon, 1));

                    if (!empty($latlon['lat']) && !empty($latlon['lng'])) {
                        $bean->lat_c = $latlon['lat'];
                        $bean->lon_c = $latlon['lng'];
                    }
                }
            }
        }
    }

}
