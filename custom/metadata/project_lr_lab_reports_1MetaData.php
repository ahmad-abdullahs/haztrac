<?php
// created: 2019-07-08 12:48:22
$dictionary["project_lr_lab_reports_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'project_lr_lab_reports_1' => 
    array (
      'lhs_module' => 'Project',
      'lhs_table' => 'project',
      'lhs_key' => 'id',
      'rhs_module' => 'LR_Lab_Reports',
      'rhs_table' => 'lr_lab_reports',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'project_lr_lab_reports_1_c',
      'join_key_lhs' => 'project_lr_lab_reports_1project_ida',
      'join_key_rhs' => 'project_lr_lab_reports_1lr_lab_reports_idb',
    ),
  ),
  'table' => 'project_lr_lab_reports_1_c',
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
    'project_lr_lab_reports_1project_ida' => 
    array (
      'name' => 'project_lr_lab_reports_1project_ida',
      'type' => 'id',
    ),
    'project_lr_lab_reports_1lr_lab_reports_idb' => 
    array (
      'name' => 'project_lr_lab_reports_1lr_lab_reports_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_project_lr_lab_reports_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_project_lr_lab_reports_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'project_lr_lab_reports_1project_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_project_lr_lab_reports_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'project_lr_lab_reports_1lr_lab_reports_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'project_lr_lab_reports_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'project_lr_lab_reports_1lr_lab_reports_idb',
      ),
    ),
  ),
);