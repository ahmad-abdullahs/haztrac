<?php
// created: 2020-08-24 15:38:01
$viewdefs['HRM_Employee_Training']['base']['view']['subpanel-for-hrm_employee_info-hrm_employee_info_hrm_employee_training_1'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'employee_name_c',
          'label' => 'LBL_EMPLOYEE_NAME',
          'enabled' => true,
          'id' => 'HRM_EMPLOYEE_INFO_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'employee_training_c',
          'label' => 'LBL_EMPLOYEE_TRAINING',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'provider_school_c',
          'label' => 'LBL_PROVIDER_SCHOOL',
          'enabled' => true,
          'id' => 'ACCOUNT_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'duration_c',
          'label' => 'LBL_DURATION',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'compatibility_level_c',
          'label' => 'LBL_COMPATIBILITY_LEVEL',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
  'type' => 'subpanel-list',
);