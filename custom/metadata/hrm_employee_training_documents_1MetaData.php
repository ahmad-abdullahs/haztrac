<?php
// created: 2020-08-29 18:50:09
$dictionary["hrm_employee_training_documents_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'hrm_employee_training_documents_1' => 
    array (
      'lhs_module' => 'HRM_Employee_Training',
      'lhs_table' => 'hrm_employee_training',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'hrm_employee_training_documents_1_c',
      'join_key_lhs' => 'hrm_employee_training_documents_1hrm_employee_training_ida',
      'join_key_rhs' => 'hrm_employee_training_documents_1documents_idb',
    ),
  ),
  'table' => 'hrm_employee_training_documents_1_c',
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
    'hrm_employee_training_documents_1hrm_employee_training_ida' => 
    array (
      'name' => 'hrm_employee_training_documents_1hrm_employee_training_ida',
      'type' => 'id',
    ),
    'hrm_employee_training_documents_1documents_idb' => 
    array (
      'name' => 'hrm_employee_training_documents_1documents_idb',
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
      'name' => 'idx_hrm_employee_training_documents_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_hrm_employee_training_documents_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'hrm_employee_training_documents_1hrm_employee_training_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_hrm_employee_training_documents_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'hrm_employee_training_documents_1documents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'hrm_employee_training_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'hrm_employee_training_documents_1documents_idb',
      ),
    ),
  ),
);