<?php
// created: 2019-09-01 14:02:17
$dictionary["User"]["fields"]["hrm_employee_training_users"] = array (
  'name' => 'hrm_employee_training_users',
  'type' => 'link',
  'relationship' => 'hrm_employee_training_users',
  'source' => 'non-db',
  'module' => 'HRM_Employee_Training',
  'bean_name' => 'HRM_Employee_Training',
  'side' => 'right',
  'vname' => 'LBL_HRM_EMPLOYEE_TRAINING_USERS_FROM_USERS_TITLE',
  'id_name' => 'hrm_employee_training_usershrm_employee_training_ida',
  'link-type' => 'one',
);
$dictionary["User"]["fields"]["hrm_employee_training_users_name"] = array (
  'name' => 'hrm_employee_training_users_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_HRM_EMPLOYEE_TRAINING_USERS_FROM_HRM_EMPLOYEE_TRAINING_TITLE',
  'save' => true,
  'id_name' => 'hrm_employee_training_usershrm_employee_training_ida',
  'link' => 'hrm_employee_training_users',
  'table' => 'hrm_employee_training',
  'module' => 'HRM_Employee_Training',
  'rname' => 'name',
);
$dictionary["User"]["fields"]["hrm_employee_training_usershrm_employee_training_ida"] = array (
  'name' => 'hrm_employee_training_usershrm_employee_training_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_HRM_EMPLOYEE_TRAINING_USERS_FROM_USERS_TITLE_ID',
  'id_name' => 'hrm_employee_training_usershrm_employee_training_ida',
  'link' => 'hrm_employee_training_users',
  'table' => 'hrm_employee_training',
  'module' => 'HRM_Employee_Training',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
