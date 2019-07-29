<?php

class AccountsHooks
{
    function beforeSave($bean, $event, $arguments) {
        // if lat long are not calculated or address changed
        if (
            empty($bean->lat_c) ||
            $bean->fetched_row['shipping_address_street'] != $bean->shipping_address_street || 
            $bean->fetched_row['shipping_address_city'] != $bean->shipping_address_city || 
            $bean->fetched_row['shipping_address_state'] != $bean->shipping_address_state || 
            $bean->fetched_row['shipping_address_postalcode'] != $bean->shipping_address_postalcode || 
            $bean->fetched_row['shipping_address_country'] != $bean->shipping_address_country
        ) {
            $this->getLatLon($bean);
        }
    }

    private function getLatLon($bean) {
        $address = urlencode($bean->shipping_address_street . ', ' .
            $bean->shipping_address_city . ', ' .
            $bean->shipping_address_state . ', ' .
            $bean->shipping_address_postalcode . ', ' .
            $bean->shipping_address_country);

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

                    if (!empty($latlon['lat']) && !empty($latlon['lng'])) {
                        $bean->lat_c = $latlon['lat'];
                        $bean->lon_c = $latlon['lng'];
                    }
                }
            }
        }
    }
}
