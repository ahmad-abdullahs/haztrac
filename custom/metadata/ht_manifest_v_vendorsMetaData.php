<?php
// created: 2019-04-29 19:19:52
$dictionary["ht_manifest_v_vendors"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'ht_manifest_v_vendors' => 
    array (
      'lhs_module' => 'V_Vendors',
      'lhs_table' => 'v_vendors',
      'lhs_key' => 'id',
      'rhs_module' => 'HT_Manifest',
      'rhs_table' => 'ht_manifest',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ht_manifest_v_vendors_c',
      'join_key_lhs' => 'ht_manifest_v_vendorsht_manifest_ida',
      'join_key_rhs' => 'ht_manifest_v_vendorsv_vendors_idb',
    ),
  ),
  'table' => 'ht_manifest_v_vendors_c',
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
    'ht_manifest_v_vendorsht_manifest_ida' => 
    array (
      'name' => 'ht_manifest_v_vendorsht_manifest_ida',
      'type' => 'id',
    ),
    'ht_manifest_v_vendorsv_vendors_idb' => 
    array (
      'name' => 'ht_manifest_v_vendorsv_vendors_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_ht_manifest_v_vendors_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_ht_manifest_v_vendors_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_manifest_v_vendorsht_manifest_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_ht_manifest_v_vendors_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_manifest_v_vendorsv_vendors_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'ht_manifest_v_vendors_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ht_manifest_v_vendorsht_manifest_ida',
        1 => 'ht_manifest_v_vendorsv_vendors_idb',
      ),
    ),
  ),
);