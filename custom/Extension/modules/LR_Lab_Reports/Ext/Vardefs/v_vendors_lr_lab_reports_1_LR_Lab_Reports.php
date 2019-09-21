<?php
// created: 2019-06-21 11:00:06
$dictionary["LR_Lab_Reports"]["fields"]["v_vendors_lr_lab_reports_1"] = array (
  'name' => 'v_vendors_lr_lab_reports_1',
  'type' => 'link',
  'relationship' => 'v_vendors_lr_lab_reports_1',
  'source' => 'non-db',
  'module' => 'V_Vendors',
  'bean_name' => 'V_Vendors',
  'side' => 'right',
  'vname' => 'LBL_V_VENDORS_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE',
  'id_name' => 'v_vendors_lr_lab_reports_1v_vendors_ida',
  'link-type' => 'one',
);
$dictionary["LR_Lab_Reports"]["fields"]["v_vendors_lr_lab_reports_1_name"] = array (
  'name' => 'v_vendors_lr_lab_reports_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_V_VENDORS_LR_LAB_REPORTS_1_FROM_V_VENDORS_TITLE',
  'save' => true,
  'id_name' => 'v_vendors_lr_lab_reports_1v_vendors_ida',
  'link' => 'v_vendors_lr_lab_reports_1',
  'table' => 'v_vendors',
  'module' => 'V_Vendors',
  'rname' => 'name',
  'massupdate' => false,
);
$dictionary["LR_Lab_Reports"]["fields"]["v_vendors_lr_lab_reports_1v_vendors_ida"] = array (
  'name' => 'v_vendors_lr_lab_reports_1v_vendors_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_V_VENDORS_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE_ID',
  'id_name' => 'v_vendors_lr_lab_reports_1v_vendors_ida',
  'link' => 'v_vendors_lr_lab_reports_1',
  'table' => 'v_vendors',
  'module' => 'V_Vendors',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
