<?php
// created: 2019-05-16 00:59:17
$dictionary["ht_manifest_revenuelineitems_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'ht_manifest_revenuelineitems_1' => 
    array (
      'lhs_module' => 'HT_Manifest',
      'lhs_table' => 'ht_manifest',
      'lhs_key' => 'id',
      'rhs_module' => 'RevenueLineItems',
      'rhs_table' => 'revenue_line_items',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ht_manifest_revenuelineitems_1_c',
      'join_key_lhs' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
      'join_key_rhs' => 'ht_manifest_revenuelineitems_1revenuelineitems_idb',
    ),
  ),
  'table' => 'ht_manifest_revenuelineitems_1_c',
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
    'ht_manifest_revenuelineitems_1ht_manifest_ida' => 
    array (
      'name' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
      'type' => 'id',
    ),
    'ht_manifest_revenuelineitems_1revenuelineitems_idb' => 
    array (
      'name' => 'ht_manifest_revenuelineitems_1revenuelineitems_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_ht_manifest_revenuelineitems_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_ht_manifest_revenuelineitems_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_ht_manifest_revenuelineitems_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_manifest_revenuelineitems_1revenuelineitems_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'ht_manifest_revenuelineitems_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ht_manifest_revenuelineitems_1revenuelineitems_idb',
      ),
    ),
  ),
);