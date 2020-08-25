<?php
// created: 2020-08-24 15:36:31
$dictionary["hrm_employee_info_hrm_employee_training_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'hrm_employee_info_hrm_employee_training_1' => 
    array (
      'lhs_module' => 'HRM_Employee_Info',
      'lhs_table' => 'hrm_employee_info',
      'lhs_key' => 'id',
      'rhs_module' => 'HRM_Employee_Training',
      'rhs_table' => 'hrm_employee_training',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'hrm_employee_info_hrm_employee_training_1_c',
      'join_key_lhs' => 'hrm_employee_info_hrm_employee_training_1hrm_employee_info_ida',
      'join_key_rhs' => 'hrm_employcf6eraining_idb',
    ),
  ),
  'table' => 'hrm_employee_info_hrm_employee_training_1_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'hrm_employee_info_hrm_employee_training_1hrm_employee_info_ida' => 
    array (
      'name' => 'hrm_employee_info_hrm_employee_training_1hrm_employee_info_ida',
      'type' => 'id',
    ),
    'hrm_employcf6eraining_idb' => 
    array (
      'name' => 'hrm_employcf6eraining_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_hrm_employee_info_hrm_employee_training_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_hrm_employee_info_hrm_employee_training_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'hrm_employee_info_hrm_employee_training_1hrm_employee_info_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_hrm_employee_info_hrm_employee_training_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'hrm_employcf6eraining_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'hrm_employee_info_hrm_employee_training_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'hrm_employee_info_hrm_employee_training_1hrm_employee_info_ida',
        1 => 'hrm_employcf6eraining_idb',
      ),
    ),
  ),
);