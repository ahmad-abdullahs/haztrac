<?php
// created: 2020-02-07 04:03:33
$dictionary["wpm_waste_profile_module_tasks_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'wpm_waste_profile_module_tasks_1' => 
    array (
      'lhs_module' => 'WPM_Waste_Profile_Module',
      'lhs_table' => 'wpm_waste_profile_module',
      'lhs_key' => 'id',
      'rhs_module' => 'Tasks',
      'rhs_table' => 'tasks',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'wpm_waste_profile_module_tasks_1_c',
      'join_key_lhs' => 'wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida',
      'join_key_rhs' => 'wpm_waste_profile_module_tasks_1tasks_idb',
    ),
  ),
  'table' => 'wpm_waste_profile_module_tasks_1_c',
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
    'wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida' => 
    array (
      'name' => 'wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida',
      'type' => 'id',
    ),
    'wpm_waste_profile_module_tasks_1tasks_idb' => 
    array (
      'name' => 'wpm_waste_profile_module_tasks_1tasks_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_wpm_waste_profile_module_tasks_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_wpm_waste_profile_module_tasks_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'wpm_waste_profile_module_tasks_1wpm_waste_profile_module_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_wpm_waste_profile_module_tasks_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'wpm_waste_profile_module_tasks_1tasks_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'wpm_waste_profile_module_tasks_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'wpm_waste_profile_module_tasks_1tasks_idb',
      ),
    ),
  ),
);