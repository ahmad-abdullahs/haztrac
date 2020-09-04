<?php
// created: 2020-08-29 19:05:44
$dictionary["KBContent"]["fields"]["hrm_employee_training_kbcontents_1"] = array (
  'name' => 'hrm_employee_training_kbcontents_1',
  'type' => 'link',
  'relationship' => 'hrm_employee_training_kbcontents_1',
  'source' => 'non-db',
  'module' => 'HRM_Employee_Training',
  'bean_name' => 'HRM_Employee_Training',
  'side' => 'right',
  'vname' => 'LBL_HRM_EMPLOYEE_TRAINING_KBCONTENTS_1_FROM_KBCONTENTS_TITLE',
  'id_name' => 'hrm_employee_training_kbcontents_1hrm_employee_training_ida',
  'link-type' => 'one',
);
$dictionary["KBContent"]["fields"]["hrm_employee_training_kbcontents_1_name"] = array (
  'name' => 'hrm_employee_training_kbcontents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_HRM_EMPLOYEE_TRAINING_KBCONTENTS_1_FROM_HRM_EMPLOYEE_TRAINING_TITLE',
  'save' => true,
  'id_name' => 'hrm_employee_training_kbcontents_1hrm_employee_training_ida',
  'link' => 'hrm_employee_training_kbcontents_1',
  'table' => 'hrm_employee_training',
  'module' => 'HRM_Employee_Training',
  'rname' => 'name',
);
$dictionary["KBContent"]["fields"]["hrm_employee_training_kbcontents_1hrm_employee_training_ida"] = array (
  'name' => 'hrm_employee_training_kbcontents_1hrm_employee_training_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_HRM_EMPLOYEE_TRAINING_KBCONTENTS_1_FROM_KBCONTENTS_TITLE_ID',
  'id_name' => 'hrm_employee_training_kbcontents_1hrm_employee_training_ida',
  'link' => 'hrm_employee_training_kbcontents_1',
  'table' => 'hrm_employee_training',
  'module' => 'HRM_Employee_Training',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
