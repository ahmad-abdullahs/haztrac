<?php
// created: 2019-07-28 15:11:27
$dictionary["WPM_Waste_Profile_Module"]["fields"]["wpm_waste_profile_module_accounts_1"] = array (
  'name' => 'wpm_waste_profile_module_accounts_1',
  'type' => 'link',
  'relationship' => 'wpm_waste_profile_module_accounts_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'wpm_waste_profile_module_accounts_1accounts_idb',
);
$dictionary["WPM_Waste_Profile_Module"]["fields"]["wpm_waste_profile_module_accounts_1_name"] = array (
  'name' => 'wpm_waste_profile_module_accounts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'wpm_waste_profile_module_accounts_1accounts_idb',
  'link' => 'wpm_waste_profile_module_accounts_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["WPM_Waste_Profile_Module"]["fields"]["wpm_waste_profile_module_accounts_1accounts_idb"] = array (
  'name' => 'wpm_waste_profile_module_accounts_1accounts_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1_FROM_ACCOUNTS_TITLE_ID',
  'id_name' => 'wpm_waste_profile_module_accounts_1accounts_idb',
  'link' => 'wpm_waste_profile_module_accounts_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
