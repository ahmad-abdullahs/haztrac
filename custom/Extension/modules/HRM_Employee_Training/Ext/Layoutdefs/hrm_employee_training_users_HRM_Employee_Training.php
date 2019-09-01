<?php
 // created: 2019-09-01 05:58:15
$layout_defs["HRM_Employee_Training"]["subpanel_setup"]['hrm_employee_training_users'] = array (
  'order' => 100,
  'module' => 'Users',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_HRM_EMPLOYEE_TRAINING_USERS_FROM_USERS_TITLE',
  'get_subpanel_data' => 'hrm_employee_training_users',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
