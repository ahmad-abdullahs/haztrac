<?php
// created: 2019-07-02 05:26:30
$dictionary["accounts_lr_lab_reports_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'accounts_lr_lab_reports_1' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'LR_Lab_Reports',
      'rhs_table' => 'lr_lab_reports',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'accounts_lr_lab_reports_1_c',
      'join_key_lhs' => 'accounts_lr_lab_reports_1accounts_ida',
      'join_key_rhs' => 'accounts_lr_lab_reports_1lr_lab_reports_idb',
    ),
  ),
  'table' => 'accounts_lr_lab_reports_1_c',
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
    'accounts_lr_lab_reports_1accounts_ida' => 
    array (
      'name' => 'accounts_lr_lab_reports_1accounts_ida',
      'type' => 'id',
    ),
    'accounts_lr_lab_reports_1lr_lab_reports_idb' => 
    array (
      'name' => 'accounts_lr_lab_reports_1lr_lab_reports_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_accounts_lr_lab_reports_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_accounts_lr_lab_reports_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_lr_lab_reports_1accounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_accounts_lr_lab_reports_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_lr_lab_reports_1lr_lab_reports_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'accounts_lr_lab_reports_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'accounts_lr_lab_reports_1lr_lab_reports_idb',
      ),
    ),
  ),
);