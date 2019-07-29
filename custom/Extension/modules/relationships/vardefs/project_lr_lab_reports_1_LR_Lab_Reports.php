<?php
// created: 2019-07-08 12:48:22
$dictionary["LR_Lab_Reports"]["fields"]["project_lr_lab_reports_1"] = array (
  'name' => 'project_lr_lab_reports_1',
  'type' => 'link',
  'relationship' => 'project_lr_lab_reports_1',
  'source' => 'non-db',
  'module' => 'Project',
  'bean_name' => 'Project',
  'side' => 'right',
  'vname' => 'LBL_PROJECT_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE',
  'id_name' => 'project_lr_lab_reports_1project_ida',
  'link-type' => 'one',
);
$dictionary["LR_Lab_Reports"]["fields"]["project_lr_lab_reports_1_name"] = array (
  'name' => 'project_lr_lab_reports_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECT_LR_LAB_REPORTS_1_FROM_PROJECT_TITLE',
  'save' => true,
  'id_name' => 'project_lr_lab_reports_1project_ida',
  'link' => 'project_lr_lab_reports_1',
  'table' => 'project',
  'module' => 'Project',
  'rname' => 'name',
);
$dictionary["LR_Lab_Reports"]["fields"]["project_lr_lab_reports_1project_ida"] = array (
  'name' => 'project_lr_lab_reports_1project_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PROJECT_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE_ID',
  'id_name' => 'project_lr_lab_reports_1project_ida',
  'link' => 'project_lr_lab_reports_1',
  'table' => 'project',
  'module' => 'Project',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
