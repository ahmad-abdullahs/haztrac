<?php
// created: 2019-05-21 01:33:37
$dictionary["ht_assets_and_objects_documents_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'ht_assets_and_objects_documents_1' => 
    array (
      'lhs_module' => 'HT_Assets_and_Objects',
      'lhs_table' => 'ht_assets_and_objects',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ht_assets_and_objects_documents_1_c',
      'join_key_lhs' => 'ht_assets_and_objects_documents_1ht_assets_and_objects_ida',
      'join_key_rhs' => 'ht_assets_and_objects_documents_1documents_idb',
    ),
  ),
  'table' => 'ht_assets_and_objects_documents_1_c',
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
    'ht_assets_and_objects_documents_1ht_assets_and_objects_ida' => 
    array (
      'name' => 'ht_assets_and_objects_documents_1ht_assets_and_objects_ida',
      'type' => 'id',
    ),
    'ht_assets_and_objects_documents_1documents_idb' => 
    array (
      'name' => 'ht_assets_and_objects_documents_1documents_idb',
      'type' => 'id',
    ),
    'document_revision_id' => 
    array (
      'name' => 'document_revision_id',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_ht_assets_and_objects_documents_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_ht_assets_and_objects_documents_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_assets_and_objects_documents_1ht_assets_and_objects_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_ht_assets_and_objects_documents_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_assets_and_objects_documents_1documents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'ht_assets_and_objects_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ht_assets_and_objects_documents_1ht_assets_and_objects_ida',
        1 => 'ht_assets_and_objects_documents_1documents_idb',
      ),
    ),
  ),
);