<?php
// created: 2020-05-07 22:34:33
$dictionary["ht_manifest_activities_1_meetings"] = array (
  'relationships' => 
  array (
    'ht_manifest_activities_1_meetings' => 
    array (
      'lhs_module' => 'HT_Manifest',
      'lhs_table' => 'ht_manifest',
      'lhs_key' => 'id',
      'rhs_module' => 'Meetings',
      'rhs_table' => 'meetings',
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