<?php

// created: 2019-12-18 04:15:38
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_1"] = array(
    'name' => 'accounts_wpm_waste_profile_module_1',
    'type' => 'link',
    'relationship' => 'accounts_wpm_waste_profile_module_1',
    'source' => 'non-db',
    'module' => 'Accounts',
    'bean_name' => 'Account',
    'side' => 'right',
    'vname' => 'LBL_ACCOUNTS_WPM_WASTE_PROFILE_MODULE_1_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
    'id_name' => 'accounts_wpm_waste_profile_module_1accounts_ida',
    'link-type' => 'one',
);
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_1_name"] = array(
    'name' => 'accounts_wpm_waste_profile_module_1_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS_WPM_WASTE_PROFILE_MODULE_1_FROM_ACCOUNTS_TITLE',
    'save' => true,
    'id_name' => 'accounts_wpm_waste_profile_module_1accounts_ida',
    'link' => 'accounts_wpm_waste_profile_module_1',
    'table' => 'accounts',
    'module' => 'Accounts',
    'rname' => 'name',
);
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_1accounts_ida"] = array(
    'name' => 'accounts_wpm_waste_profile_module_1accounts_ida',
    'type' => 'id',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS_WPM_WASTE_PROFILE_MODULE_1_FROM_WPM_WASTE_PROFILE_MODULE_TITLE_ID',
    'id_name' => 'accounts_wpm_waste_profile_module_1accounts_ida',
    'link' => 'accounts_wpm_waste_profile_module_1',
    'table' => 'accounts',
    'module' => 'Accounts',
    'rname' => 'id',
    'reportable' => false,
    'side' => 'right',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
);
