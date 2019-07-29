<?php
// created: 2019-07-28 15:11:27
$dictionary["LR_Lab_Reports"]["fields"]["wpm_waste_profile_module_lr_lab_reports"] = array (
  'name' => 'wpm_waste_profile_module_lr_lab_reports',
  'type' => 'link',
  'relationship' => 'wpm_waste_profile_module_lr_lab_reports',
  'source' => 'non-db',
  'module' => 'WPM_Waste_Profile_Module',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_LR_LAB_REPORTS_FROM_LR_LAB_REPORTS_TITLE',
  'id_name' => 'wpm_waste_470d_module_ida',
  'link-type' => 'one',
);
$dictionary["LR_Lab_Reports"]["fields"]["wpm_waste_profile_module_lr_lab_reports_name"] = array (
  'name' => 'wpm_waste_profile_module_lr_lab_reports_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_LR_LAB_REPORTS_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
  'save' => true,
  'id_name' => 'wpm_waste_470d_module_ida',
  'link' => 'wpm_waste_profile_module_lr_lab_reports',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'name',
);
$dictionary["LR_Lab_Reports"]["fields"]["wpm_waste_470d_module_ida"] = array (
  'name' => 'wpm_waste_470d_module_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_MODULE_LR_LAB_REPORTS_FROM_LR_LAB_REPORTS_TITLE_ID',
  'id_name' => 'wpm_waste_470d_module_ida',
  'link' => 'wpm_waste_profile_module_lr_lab_reports',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
