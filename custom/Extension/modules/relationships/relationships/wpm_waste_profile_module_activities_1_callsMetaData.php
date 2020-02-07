<?php
// created: 2020-02-08 00:41:28
$dictionary["wpm_waste_profile_module_activities_1_calls"] = array (
  'relationships' => 
  array (
    'wpm_waste_profile_module_activities_1_calls' => 
    array (
      'lhs_module' => 'WPM_Waste_Profile_Module',
      'lhs_table' => 'wpm_waste_profile_module',
      'lhs_key' => 'id',
      'rhs_module' => 'Calls',
      'rhs_table' => 'calls',
      'relationship_role_column_value' => 'WPM_Waste_Profile_Module',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);