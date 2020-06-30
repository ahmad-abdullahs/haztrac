<?php

require_once('data/SugarBeanApiHelper.php');

class AccountsApiHelper extends SugarBeanApiHelper {

    // Mimic the SugarBeanApiHelper->formatForApi() class
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);
        global $sugar_config;

        if (!empty($data['ac_usepa_id_external_info_c'])) {
            $data['ac_usepa_id_external_info_c'] = $sugar_config['site_url'] . '/' . "epaInfoDir/{$data['ac_usepa_id_c']}.html";
        }

        if (!file_exists("epaInfoDir/{$data['ac_usepa_id_c']}.html")) {
            global $sugar_config;
            $data['ac_usepa_id_external_info_c'] = "{$sugar_config['site_url']}/epaInfoDir/no-data-found.html";
        }

        return $data;
    }

}
