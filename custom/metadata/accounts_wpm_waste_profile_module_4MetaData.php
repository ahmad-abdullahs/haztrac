<?php
// created: 2020-01-25 09:21:34
$dictionary["accounts_wpm_waste_profile_module_4"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'accounts_wpm_waste_profile_module_4' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'WPM_Waste_Profile_Module',
      'rhs_table' => 'wpm_waste_profile_module',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'accounts_wpm_waste_profile_module_4_c',
      'join_key_lhs' => 'accounts_wpm_waste_profile_module_4accounts_ida',
      'join_key_rhs' => 'accounts_wpm_waste_profile_module_4wpm_waste_profile_module_idb',
    ),
  ),
  'table' => 'accounts_wpm_waste_profile_module_4_c',
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
    'accounts_wpm_waste_profile_module_4accounts_ida' => 
    array (
      'name' => 'accounts_wpm_waste_profile_module_4accounts_ida',
      'type' => 'id',
    ),
    'accounts_wpm_waste_profile_module_4wpm_waste_profile_module_idb' => 
    array (
      'name' => 'accounts_wpm_waste_profile_module_4wpm_waste_profile_module_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_accounts_wpm_waste_profile_module_4_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_accounts_wpm_waste_profile_module_4_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_wpm_waste_profile_module_4accounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_accounts_wpm_waste_profile_module_4_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_wpm_waste_profile_module_4wpm_waste_profile_module_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'accounts_wpm_waste_profile_module_4_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'accounts_wpm_waste_profile_module_4wpm_waste_profile_module_idb',
      ),
    ),
  ),
);