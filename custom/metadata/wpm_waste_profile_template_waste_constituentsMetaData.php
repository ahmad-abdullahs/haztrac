<?php
// created: 2019-12-12 19:42:36
$dictionary["wpm_waste_profile_template_waste_constituents"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'wpm_waste_profile_template_waste_constituents' => 
    array (
      'lhs_module' => 'WPM_Waste_Profile_Template',
      'lhs_table' => 'wpm_waste_profile_template',
      'lhs_key' => 'id',
      'rhs_module' => 'waste_constituents',
      'rhs_table' => 'waste_constituents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'wpm_waste_profile_template_waste_constituents_c',
      'join_key_lhs' => 'wpm_waste_73d2emplate_ida',
      'join_key_rhs' => 'wpm_waste_177fituents_idb',
    ),
  ),
  'table' => 'wpm_waste_profile_template_waste_constituents_c',
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
    'wpm_waste_73d2emplate_ida' => 
    array (
      'name' => 'wpm_waste_73d2emplate_ida',
      'type' => 'id',
    ),
    'wpm_waste_177fituents_idb' => 
    array (
      'name' => 'wpm_waste_177fituents_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_wpm_waste_profile_template_waste_constituents_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_wpm_waste_profile_template_waste_constituents_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'wpm_waste_73d2emplate_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_wpm_waste_profile_template_waste_constituents_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'wpm_waste_177fituents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'wpm_waste_profile_template_waste_constituents_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'wpm_waste_177fituents_idb',
      ),
    ),
  ),
);