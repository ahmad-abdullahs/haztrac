<?php

require_once('data/SugarBeanApiHelper.php');

class RevenueLineItemsApiHelper extends SugarBeanApiHelper {

    // Mimic the SugarBeanApiHelper->formatForApi() class
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);

        // This feature is added to show the thrid party number on the waste profile 
        // relate field on the RevenueLineItems subpanel under Sales and Services module.
        // pull over fields are also added to pull the data on the basis of id in file 
        // custom/Extension/modules/RevenueLineItems/Ext/Vardefs/sugarfield_waste_profile_relate_c.php
        $data['waste_profile_relate_c'] = $data['third_party_waste_profile_c'] ? $data['third_party_waste_profile_no_c'] : $data['waste_profile_relate_c'];

        return $data;
    }

}
