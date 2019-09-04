<?php
// created: 2019-09-02 19:05:15
$dictionary["hrm_employee_training_users"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'hrm_employee_training_users' => 
    array (
      'lhs_module' => 'HRM_Employee_Training',
      'lhs_table' => 'hrm_employee_training',
      'lhs_key' => 'id',
      'rhs_module' => 'Users',
      'rhs_table' => 'users',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'hrm_employee_training_users_c',
      'join_key_lhs' => 'hrm_employee_training_usershrm_employee_training_ida',
      'join_key_rhs' => 'hrm_employee_training_usersusers_idb',
    ),
  ),
  'table' => 'hrm_employee_training_users_c',
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
    'hrm_employee_training_usershrm_employee_training_ida' => 
    array (
      'name' => 'hrm_employee_training_usershrm_employee_training_ida',
      'type' => 'id',
    ),
    'hrm_employee_training_usersusers_idb' => 
    array (
      'name' => 'hrm_employee_training_usersusers_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_hrm_employee_training_users_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_hrm_employee_training_users_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'hrm_employee_training_usershrm_employee_training_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_hrm_employee_training_users_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'hrm_employee_training_usersusers_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'hrm_employee_training_users_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'hrm_employee_training_usersusers_idb',
      ),
    ),
  ),
);