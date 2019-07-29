<?PHP
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/sales_and_services/sales_and_services_sugar.php');
class sales_and_services extends sales_and_services_sugar {
    public function save($check_notify = false) {
        // if lat long are not calculated or address changed
        if (
            empty($this->lat_c) ||
            $this->fetched_row['shipping_address_street_c'] != $this->shipping_address_street_c || 
            $this->fetched_row['shipping_address_city_c'] != $this->shipping_address_city_c || 
            $this->fetched_row['shipping_address_state_c'] != $this->shipping_address_state_c || 
            $this->fetched_row['shipping_address_postalcode_c'] != $this->shipping_address_postalcode_c || 
            $this->fetched_row['shipping_address_country_c'] != $this->shipping_address_country_c
        ) {
            $this->getLatLon();
        }

        if (empty($this->ss_number)) {
            $this->ss_number = 'S-' . $this->getUniqueNumber();
        }

        return parent::save($check_notify);
    }

    private function getUniqueNumber() {
        $uniqueNumber = rand(1000000, 9999999);

        if (!$this->isUniqueNumber($uniqueNumber)) {
            $uniqueNumber = $this->getUniqueNumber();
        }

        return $uniqueNumber;
    }

    private function isUniqueNumber($number) {
        global $db;

        $res = $db->query("SELECT id FROM {$this->table_name} WHERE deleted='0' AND ss_number like '%{$number}%'");
        if ($row = $db->fetchByAssoc($res)) {
            return false;
        }

        return true;
    }

    private function getLatLon() {
        $address = urlencode($this->shipping_address_street_c . ', ' .
            $this->shipping_address_city_c . ', ' .
            $this->shipping_address_state_c . ', ' .
            $this->shipping_address_postalcode_c . ', ' .
            $this->shipping_address_country_c);

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
                        $this->lat_c = $latlon['lat'];
                        $this->lon_c = $latlon['lng'];
                    }
                }
            }
        }
    }
}