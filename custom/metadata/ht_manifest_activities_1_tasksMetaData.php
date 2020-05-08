<?php
// created: 2020-05-07 22:34:34
$dictionary["ht_manifest_activities_1_tasks"] = array (
  'relationships' => 
  array (
    'ht_manifest_activities_1_tasks' => 
    array (
      'lhs_module' => 'HT_Manifest',
      'lhs_table' => 'ht_manifest',
      'lhs_key' => 'id',
      'rhs_module' => 'Tasks',
      'rhs_table' => 'tasks',
      'relationship_role_column_value' => 'HT_Manifest',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);