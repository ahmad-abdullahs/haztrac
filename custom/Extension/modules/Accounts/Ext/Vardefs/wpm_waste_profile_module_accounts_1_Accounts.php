<?php
// created: 2019-07-28 15:11:27
$dictionary["Account"]["fields"]["wpm_waste_profile_module_accounts_1"] = array (
  'name' => 'wpm_waste_profile_module_accounts_1',
  'type' => 'link',
  'relationship' => 'wpm_waste_profile_module_accounts_1',
  'source' => 'non-db',
  'module' => 'WPM_Waste_Profile_Module',
  'bean_name' => false,
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
  'id_name' => 'wpm_waste_profile_module_accounts_1wpm_waste_profile_module_ida',
);
$dictionary["Account"]["fields"]["wpm_waste_profile_module_accounts_1_name"] = array (
  'name' => 'wpm_waste_profile_module_accounts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
  'save' => true,
  'id_name' => 'wpm_waste_profile_module_accounts_1wpm_waste_profile_module_ida',
  'link' => 'wpm_waste_profile_module_accounts_1',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["wpm_waste_profile_module_accounts_1wpm_waste_profile_module_ida"] = array (
  'name' => 'wpm_waste_profile_module_accounts_1wpm_waste_profile_module_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1_FROM_WPM_WASTE_PROFILE_MODULE_TITLE_ID',
  'id_name' => 'wpm_waste_profile_module_accounts_1wpm_waste_profile_module_ida',
  'link' => 'wpm_waste_profile_module_accounts_1',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
