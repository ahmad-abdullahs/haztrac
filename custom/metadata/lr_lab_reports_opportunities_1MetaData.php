<?php
// created: 2019-06-19 13:06:41
$dictionary["lr_lab_reports_opportunities_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'lr_lab_reports_opportunities_1' => 
    array (
      'lhs_module' => 'LR_Lab_Reports',
      'lhs_table' => 'lr_lab_reports',
      'lhs_key' => 'id',
      'rhs_module' => 'Opportunities',
      'rhs_table' => 'opportunities',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'lr_lab_reports_opportunities_1_c',
      'join_key_lhs' => 'lr_lab_reports_opportunities_1lr_lab_reports_ida',
      'join_key_rhs' => 'lr_lab_reports_opportunities_1opportunities_idb',
    ),
  ),
  'table' => 'lr_lab_reports_opportunities_1_c',
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
    'lr_lab_reports_opportunities_1lr_lab_reports_ida' => 
    array (
      'name' => 'lr_lab_reports_opportunities_1lr_lab_reports_ida',
      'type' => 'id',
    ),
    'lr_lab_reports_opportunities_1opportunities_idb' => 
    array (
      'name' => 'lr_lab_reports_opportunities_1opportunities_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_lr_lab_reports_opportunities_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_lr_lab_reports_opportunities_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'lr_lab_reports_opportunities_1lr_lab_reports_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_lr_lab_reports_opportunities_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'lr_lab_reports_opportunities_1opportunities_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'lr_lab_reports_opportunities_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'lr_lab_reports_opportunities_1lr_lab_reports_ida',
        1 => 'lr_lab_reports_opportunities_1opportunities_idb',
      ),
    ),
  ),
);