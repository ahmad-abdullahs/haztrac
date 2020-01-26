<?php
// created: 2020-01-25 09:21:34
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_4"] = array (
  'name' => 'accounts_wpm_waste_profile_module_4',
  'type' => 'link',
  'relationship' => 'accounts_wpm_waste_profile_module_4',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_WPM_WASTE_PROFILE_MODULE_4_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
  'id_name' => 'accounts_wpm_waste_profile_module_4accounts_ida',
  'link-type' => 'one',
);
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_4_name"] = array (
  'name' => 'accounts_wpm_waste_profile_module_4_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_WPM_WASTE_PROFILE_MODULE_4_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_wpm_waste_profile_module_4accounts_ida',
  'link' => 'accounts_wpm_waste_profile_module_4',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["WPM_Waste_Profile_Module"]["fields"]["accounts_wpm_waste_profile_module_4accounts_ida"] = array (
  'name' => 'accounts_wpm_waste_profile_module_4accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_WPM_WASTE_PROFILE_MODULE_4_FROM_WPM_WASTE_PROFILE_MODULE_TITLE_ID',
  'id_name' => 'accounts_wpm_waste_profile_module_4accounts_ida',
  'link' => 'accounts_wpm_waste_profile_module_4',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
