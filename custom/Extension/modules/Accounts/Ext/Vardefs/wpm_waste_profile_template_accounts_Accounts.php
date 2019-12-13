<?php
// created: 2019-12-12 19:42:37
$dictionary["Account"]["fields"]["wpm_waste_profile_template_accounts"] = array (
  'name' => 'wpm_waste_profile_template_accounts',
  'type' => 'link',
  'relationship' => 'wpm_waste_profile_template_accounts',
  'source' => 'non-db',
  'module' => 'WPM_Waste_Profile_Template',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'id_name' => 'wpm_waste_48d4emplate_ida',
  'link-type' => 'one',
);
$dictionary["Account"]["fields"]["wpm_waste_profile_template_accounts_name"] = array (
  'name' => 'wpm_waste_profile_template_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_ACCOUNTS_FROM_WPM_WASTE_PROFILE_TEMPLATE_TITLE',
  'save' => true,
  'id_name' => 'wpm_waste_48d4emplate_ida',
  'link' => 'wpm_waste_profile_template_accounts',
  'table' => 'wpm_waste_profile_template',
  'module' => 'WPM_Waste_Profile_Template',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["wpm_waste_48d4emplate_ida"] = array (
  'name' => 'wpm_waste_48d4emplate_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_ACCOUNTS_FROM_ACCOUNTS_TITLE_ID',
  'id_name' => 'wpm_waste_48d4emplate_ida',
  'link' => 'wpm_waste_profile_template_accounts',
  'table' => 'wpm_waste_profile_template',
  'module' => 'WPM_Waste_Profile_Template',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
