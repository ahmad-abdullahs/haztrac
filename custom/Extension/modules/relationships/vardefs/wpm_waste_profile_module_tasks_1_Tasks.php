<?php
// created: 2020-02-07 04:03:33
$dictionary["Task"]["fields"]["wpm_waste_profile_module_tasks_1"] = array (
  'name' => 'wpm_waste_profile_module_tasks_1',
  'type' => 'link',
  'relationship' => 'wpm_waste_profile_module_tasks_1',
  'source' => 'non-db',
  'module' => 'WPM_Waste_Profile_Module',
  'bean_name' => 'WPM_Waste_Profile_Module',
  'side' => 'right',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_TASKS_1_FROM_TASKS_TITLE',
  'id_name' => 'wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida',
  'link-type' => 'one',
);
$dictionary["Task"]["fields"]["wpm_waste_profile_module_tasks_1_name"] = array (
  'name' => 'wpm_waste_profile_module_tasks_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_TASKS_1_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
  'save' => true,
  'id_name' => 'wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida',
  'link' => 'wpm_waste_profile_module_tasks_1',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'name',
);
$dictionary["Task"]["fields"]["wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida"] = array (
  'name' => 'wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_TASKS_1_FROM_TASKS_TITLE_ID',
  'id_name' => 'wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida',
  'link' => 'wpm_waste_profile_module_tasks_1',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
