<?php
// created: 2020-07-11 22:42:18
$dictionary["pnl_permits_licenses_pnl_permits_licenses_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'pnl_permits_licenses_pnl_permits_licenses_1' => 
    array (
      'lhs_module' => 'PNL_Permits_Licenses',
      'lhs_table' => 'pnl_permits_licenses',
      'lhs_key' => 'id',
      'rhs_module' => 'PNL_Permits_Licenses',
      'rhs_table' => 'pnl_permits_licenses',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'pnl_permits_licenses_pnl_permits_licenses_1_c',
      'join_key_lhs' => 'pnl_permitfbdeicenses_ida',
      'join_key_rhs' => 'pnl_permit6196icenses_idb',
    ),
  ),
  'table' => 'pnl_permits_licenses_pnl_permits_licenses_1_c',
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
    'pnl_permitfbdeicenses_ida' => 
    array (
      'name' => 'pnl_permitfbdeicenses_ida',
      'type' => 'id',
    ),
    'pnl_permit6196icenses_idb' => 
    array (
      'name' => 'pnl_permit6196icenses_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_pnl_permits_licenses_pnl_permits_licenses_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_pnl_permits_licenses_pnl_permits_licenses_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'pnl_permitfbdeicenses_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_pnl_permits_licenses_pnl_permits_licenses_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'pnl_permit6196icenses_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'pnl_permits_licenses_pnl_permits_licenses_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'pnl_permit6196icenses_idb',
      ),
    ),
  ),
);