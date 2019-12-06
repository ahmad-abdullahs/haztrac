<?php
// created: 2019-12-06 19:08:42
$dictionary["waste_constituents_wpm_waste_profile_module"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'waste_constituents_wpm_waste_profile_module' => 
    array (
      'lhs_module' => 'WPM_Waste_Profile_Module',
      'lhs_table' => 'wpm_waste_profile_module',
      'lhs_key' => 'id',
      'rhs_module' => 'waste_constituents',
      'rhs_table' => 'waste_constituents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'waste_constituents_wpm_waste_profile_module_c',
      'join_key_lhs' => 'waste_cons93c5_module_ida',
      'join_key_rhs' => 'waste_cons8758ituents_idb',
    ),
  ),
  'table' => 'waste_constituents_wpm_waste_profile_module_c',
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
    'waste_cons93c5_module_ida' => 
    array (
      'name' => 'waste_cons93c5_module_ida',
      'type' => 'id',
    ),
    'waste_cons8758ituents_idb' => 
    array (
      'name' => 'waste_cons8758ituents_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_waste_constituents_wpm_waste_profile_module_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_waste_constituents_wpm_waste_profile_module_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'waste_cons93c5_module_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_waste_constituents_wpm_waste_profile_module_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'waste_cons8758ituents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'waste_constituents_wpm_waste_profile_module_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'waste_cons8758ituents_idb',
      ),
    ),
  ),
);