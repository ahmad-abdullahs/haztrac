<?php
// created: 2020-02-08 00:41:29
$dictionary["wpm_waste_profile_module_activities_1_tasks"] = array (
  'relationships' => 
  array (
    'wpm_waste_profile_module_activities_1_tasks' => 
    array (
      'lhs_module' => 'WPM_Waste_Profile_Module',
      'lhs_table' => 'wpm_waste_profile_module',
      'lhs_key' => 'id',
      'rhs_module' => 'Tasks',
      'rhs_table' => 'tasks',
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