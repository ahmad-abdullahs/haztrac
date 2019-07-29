<?php
// created: 2019-06-21 11:00:06
$dictionary["v_vendors_lr_lab_reports_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'v_vendors_lr_lab_reports_1' => 
    array (
      'lhs_module' => 'V_Vendors',
      'lhs_table' => 'v_vendors',
      'lhs_key' => 'id',
      'rhs_module' => 'LR_Lab_Reports',
      'rhs_table' => 'lr_lab_reports',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'v_vendors_lr_lab_reports_1_c',
      'join_key_lhs' => 'v_vendors_lr_lab_reports_1v_vendors_ida',
      'join_key_rhs' => 'v_vendors_lr_lab_reports_1lr_lab_reports_idb',
    ),
  ),
  'table' => 'v_vendors_lr_lab_reports_1_c',
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
    'v_vendors_lr_lab_reports_1v_vendors_ida' => 
    array (
      'name' => 'v_vendors_lr_lab_reports_1v_vendors_ida',
      'type' => 'id',
    ),
    'v_vendors_lr_lab_reports_1lr_lab_reports_idb' => 
    array (
      'name' => 'v_vendors_lr_lab_reports_1lr_lab_reports_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_v_vendors_lr_lab_reports_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_v_vendors_lr_lab_reports_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'v_vendors_lr_lab_reports_1v_vendors_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_v_vendors_lr_lab_reports_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'v_vendors_lr_lab_reports_1lr_lab_reports_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'v_vendors_lr_lab_reports_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'v_vendors_lr_lab_reports_1lr_lab_reports_idb',
      ),
    ),
  ),
);