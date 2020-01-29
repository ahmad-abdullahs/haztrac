<?php

// created: 2019-12-18 04:16:03
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_2"] = array(
    'name' => 'accounts_wpm_waste_profile_module_2',
    'type' => 'link',
    'relationship' => 'accounts_wpm_waste_profile_module_2',
    'source' => 'non-db',
    'module' => 'Accounts',
    'bean_name' => 'Account',
    'side' => 'right',
    'vname' => 'LBL_ACCOUNTS_WPM_WASTE_PROFILE_MODULE_2_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
    'id_name' => 'accounts_wpm_waste_profile_module_2accounts_ida',
    'link-type' => 'one',
);
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_2_name"] = array(
    'name' => 'accounts_wpm_waste_profile_module_2_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_GENERATOR',
    'save' => true,
    'id_name' => 'accounts_wpm_waste_profile_module_2accounts_ida',
    'link' => 'accounts_wpm_waste_profile_module_2',
    'table' => 'accounts',
    'module' => 'Accounts',
    'rname' => 'name',
    'auto_populate' => true,
    'populate_list' => array(
        'ac_usepa_id_c' => 'wp_usepa_id_c',
    ),
);
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_2accounts_ida"] = array(
    'name' => 'accounts_wpm_waste_profile_module_2accounts_ida',
    'type' => 'id',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS_WPM_WASTE_PROFILE_MODULE_2_FROM_WPM_WASTE_PROFILE_MODULE_TITLE_ID',
    'id_name' => 'accounts_wpm_waste_profile_module_2accounts_ida',
    'link' => 'accounts_wpm_waste_profile_module_2',
    'table' => 'accounts',
    'module' => 'Accounts',
    'rname' => 'id',
    'reportable' => false,
    'side' => 'right',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
);
