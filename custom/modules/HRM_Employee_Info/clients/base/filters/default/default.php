<?php
// created: 2021-10-27 01:32:48
$viewdefs['HRM_Employee_Info']['base']['filter']['default'] = array (
  'default_filter' => 'all_records',
  'fields' => 
  array (
    'first_name' => 
    array (
    ),
    'last_name' => 
    array (
    ),
    'employee_id_num' => 
    array (
    ),
    'address_city' => 
    array (
      'dbFields' => 
      array (
        0 => 'primary_address_city',
        1 => 'alt_address_city',
      ),
      'vname' => 'LBL_CITY',
      'type' => 'text',
    ),
    'created_by_name' => 
    array (
    ),
    'do_not_call' => 
    array (
    ),
    'email' => 
    array (
    ),
    'tag' => 
    array (
    ),
    '$owner' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_CURRENT_USER_FILTER',
    ),
    '$favorite' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_FAVORITES_FILTER',
    ),
  ),
);