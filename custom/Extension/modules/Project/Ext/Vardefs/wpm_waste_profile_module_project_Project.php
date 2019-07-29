<?php
// created: 2019-07-28 15:11:27
$dictionary["Project"]["fields"]["wpm_waste_profile_module_project"] = array (
  'name' => 'wpm_waste_profile_module_project',
  'type' => 'link',
  'relationship' => 'wpm_waste_profile_module_project',
  'source' => 'non-db',
  'module' => 'WPM_Waste_Profile_Module',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_PROJECT_FROM_PROJECT_TITLE',
  'id_name' => 'wpm_waste_profile_module_projectwpm_waste_profile_module_ida',
  'link-type' => 'one',
);
$dictionary["Project"]["fields"]["wpm_waste_profile_module_project_name"] = array (
  'name' => 'wpm_waste_profile_module_project_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_PROJECT_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
  'save' => true,
  'id_name' => 'wpm_waste_profile_module_projectwpm_waste_profile_module_ida',
  'link' => 'wpm_waste_profile_module_project',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'name',
);
$dictionary["Project"]["fields"]["wpm_waste_profile_module_projectwpm_waste_profile_module_ida"] = array (
  'name' => 'wpm_waste_profile_module_projectwpm_waste_profile_module_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_PROJECT_FROM_PROJECT_TITLE_ID',
  'id_name' => 'wpm_waste_profile_module_projectwpm_waste_profile_module_ida',
  'link' => 'wpm_waste_profile_module_project',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
