<?php
$module_name = 'HRM_Employee_Training';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'employee_training_c',
                'label' => 'LBL_EMPLOYEE_TRAINING',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              2 => 
              array (
                'name' => 'completion_date_c',
                'label' => 'LBL_COMPLETION_DATE',
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
                'name' => 'renew_by_date_c',
                'label' => 'LBL_RENEW_BY_DATE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => true,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'employee_name_c',
                'label' => 'LBL_EMPLOYEE_NAME',
                'enabled' => true,
                'id' => 'HRM_EMPLOYEE_INFO_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              7 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              10 => 
              array (
                'name' => 'duration_c',
                'label' => 'LBL_DURATION',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'renewal_days_c',
                'label' => 'LBL_RENEWAL_DAYS',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'compatibility_level_c',
                'label' => 'LBL_COMPATIBILITY_LEVEL',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'frequency_c',
                'label' => 'LBL_FREQUENCY',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
