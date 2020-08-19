<?php
// created: 2020-08-18 14:07:27
$dictionary["producttemplates_documents_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'producttemplates_documents_1' => 
    array (
      'lhs_module' => 'ProductTemplates',
      'lhs_table' => 'product_templates',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'producttemplates_documents_1_c',
      'join_key_lhs' => 'producttemplates_documents_1producttemplates_ida',
      'join_key_rhs' => 'producttemplates_documents_1documents_idb',
    ),
  ),
  'table' => 'producttemplates_documents_1_c',
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
    'producttemplates_documents_1producttemplates_ida' => 
    array (
      'name' => 'producttemplates_documents_1producttemplates_ida',
      'type' => 'id',
    ),
    'producttemplates_documents_1documents_idb' => 
    array (
      'name' => 'producttemplates_documents_1documents_idb',
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
      'name' => 'idx_producttemplates_documents_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_producttemplates_documents_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'producttemplates_documents_1producttemplates_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_producttemplates_documents_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'producttemplates_documents_1documents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'producttemplates_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'producttemplates_documents_1documents_idb',
      ),
    ),
  ),
);