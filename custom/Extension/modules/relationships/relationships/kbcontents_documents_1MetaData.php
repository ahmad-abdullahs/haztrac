<?php
// created: 2020-08-18 14:08:08
$dictionary["kbcontents_documents_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'kbcontents_documents_1' => 
    array (
      'lhs_module' => 'KBContents',
      'lhs_table' => 'kbcontents',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'kbcontents_documents_1_c',
      'join_key_lhs' => 'kbcontents_documents_1kbcontents_ida',
      'join_key_rhs' => 'kbcontents_documents_1documents_idb',
    ),
  ),
  'table' => 'kbcontents_documents_1_c',
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
    'kbcontents_documents_1kbcontents_ida' => 
    array (
      'name' => 'kbcontents_documents_1kbcontents_ida',
      'type' => 'id',
    ),
    'kbcontents_documents_1documents_idb' => 
    array (
      'name' => 'kbcontents_documents_1documents_idb',
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
      'name' => 'idx_kbcontents_documents_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_kbcontents_documents_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'kbcontents_documents_1kbcontents_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_kbcontents_documents_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'kbcontents_documents_1documents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'kbcontents_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'kbcontents_documents_1documents_idb',
      ),
    ),
  ),
);