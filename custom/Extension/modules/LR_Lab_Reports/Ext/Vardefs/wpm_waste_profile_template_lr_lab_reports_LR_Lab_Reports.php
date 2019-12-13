<?php
// created: 2019-12-12 19:42:37
$dictionary["LR_Lab_Reports"]["fields"]["wpm_waste_profile_template_lr_lab_reports"] = array (
  'name' => 'wpm_waste_profile_template_lr_lab_reports',
  'type' => 'link',
  'relationship' => 'wpm_waste_profile_template_lr_lab_reports',
  'source' => 'non-db',
  'module' => 'WPM_Waste_Profile_Template',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_LR_LAB_REPORTS_FROM_LR_LAB_REPORTS_TITLE',
  'id_name' => 'wpm_waste_9874emplate_ida',
  'link-type' => 'one',
);
$dictionary["LR_Lab_Reports"]["fields"]["wpm_waste_profile_template_lr_lab_reports_name"] = array (
  'name' => 'wpm_waste_profile_template_lr_lab_reports_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_LR_LAB_REPORTS_FROM_WPM_WASTE_PROFILE_TEMPLATE_TITLE',
  'save' => true,
  'id_name' => 'wpm_waste_9874emplate_ida',
  'link' => 'wpm_waste_profile_template_lr_lab_reports',
  'table' => 'wpm_waste_profile_template',
  'module' => 'WPM_Waste_Profile_Template',
  'rname' => 'name',
);
$dictionary["LR_Lab_Reports"]["fields"]["wpm_waste_9874emplate_ida"] = array (
  'name' => 'wpm_waste_9874emplate_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_LR_LAB_REPORTS_FROM_LR_LAB_REPORTS_TITLE_ID',
  'id_name' => 'wpm_waste_9874emplate_ida',
  'link' => 'wpm_waste_profile_template_lr_lab_reports',
  'table' => 'wpm_waste_profile_template',
  'module' => 'WPM_Waste_Profile_Template',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
