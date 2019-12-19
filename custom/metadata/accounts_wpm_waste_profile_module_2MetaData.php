<?php
// created: 2019-12-18 04:16:03
$dictionary["accounts_wpm_waste_profile_module_2"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'accounts_wpm_waste_profile_module_2' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'WPM_Waste_Profile_Module',
      'rhs_table' => 'wpm_waste_profile_module',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'accounts_wpm_waste_profile_module_2_c',
      'join_key_lhs' => 'accounts_wpm_waste_profile_module_2accounts_ida',
      'join_key_rhs' => 'accounts_wpm_waste_profile_module_2wpm_waste_profile_module_idb',
    ),
  ),
  'table' => 'accounts_wpm_waste_profile_module_2_c',
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
    'accounts_wpm_waste_profile_module_2accounts_ida' => 
    array (
      'name' => 'accounts_wpm_waste_profile_module_2accounts_ida',
      'type' => 'id',
    ),
    'accounts_wpm_waste_profile_module_2wpm_waste_profile_module_idb' => 
    array (
      'name' => 'accounts_wpm_waste_profile_module_2wpm_waste_profile_module_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_accounts_wpm_waste_profile_module_2_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_accounts_wpm_waste_profile_module_2_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_wpm_waste_profile_module_2accounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_accounts_wpm_waste_profile_module_2_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_wpm_waste_profile_module_2wpm_waste_profile_module_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'accounts_wpm_waste_profile_module_2_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'accounts_wpm_waste_profile_module_2wpm_waste_profile_module_idb',
      ),
    ),
  ),
);