<?php
// created: 2021-02-19 15:37:56
$dictionary["pnl_permits_licenses_documents_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'pnl_permits_licenses_documents_1' => 
    array (
      'lhs_module' => 'PNL_Permits_Licenses',
      'lhs_table' => 'pnl_permits_licenses',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'pnl_permits_licenses_documents_1_c',
      'join_key_lhs' => 'pnl_permits_licenses_documents_1pnl_permits_licenses_ida',
      'join_key_rhs' => 'pnl_permits_licenses_documents_1documents_idb',
    ),
  ),
  'table' => 'pnl_permits_licenses_documents_1_c',
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
    'pnl_permits_licenses_documents_1pnl_permits_licenses_ida' => 
    array (
      'name' => 'pnl_permits_licenses_documents_1pnl_permits_licenses_ida',
      'type' => 'id',
    ),
    'pnl_permits_licenses_documents_1documents_idb' => 
    array (
      'name' => 'pnl_permits_licenses_documents_1documents_idb',
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
      'name' => 'idx_pnl_permits_licenses_documents_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_pnl_permits_licenses_documents_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'pnl_permits_licenses_documents_1pnl_permits_licenses_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_pnl_permits_licenses_documents_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'pnl_permits_licenses_documents_1documents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'pnl_permits_licenses_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'pnl_permits_licenses_documents_1documents_idb',
      ),
    ),
  ),
);