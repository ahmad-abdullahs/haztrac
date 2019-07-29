<?php
// created: 2019-04-29 19:19:52
$dictionary["ht_manifest_ht_assets_and_objects"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'ht_manifest_ht_assets_and_objects' => 
    array (
      'lhs_module' => 'HT_Manifest',
      'lhs_table' => 'ht_manifest',
      'lhs_key' => 'id',
      'rhs_module' => 'HT_Assets_and_Objects',
      'rhs_table' => 'ht_assets_and_objects',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ht_manifest_ht_assets_and_objects_c',
      'join_key_lhs' => 'ht_manifest_ht_assets_and_objectsht_manifest_ida',
      'join_key_rhs' => 'ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb',
    ),
  ),
  'table' => 'ht_manifest_ht_assets_and_objects_c',
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
    'transfer_date' => 
    array (
      'name' => 'transfer_date',
      'type' => 'date',
    ),
    'ht_manifest_ht_assets_and_objectsht_manifest_ida' => 
    array (
      'name' => 'ht_manifest_ht_assets_and_objectsht_manifest_ida',
      'type' => 'id',
    ),
    'ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb' => 
    array (
      'name' => 'ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_ht_manifest_ht_assets_and_objects_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_ht_manifest_ht_assets_and_objects_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_manifest_ht_assets_and_objectsht_manifest_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_ht_manifest_ht_assets_and_objects_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'ht_manifest_ht_assets_and_objects_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ht_manifest_ht_assets_and_objectsht_manifest_ida',
        1 => 'ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb',
      ),
    ),
  ),
);