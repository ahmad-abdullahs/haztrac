<?php
 // created: 2020-08-24 15:36:31
$layout_defs["HRM_Employee_Info"]["subpanel_setup"]['hrm_employee_info_hrm_employee_training_1'] = array (
  'order' => 100,
  'module' => 'HRM_Employee_Training',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_HRM_EMPLOYEE_INFO_HRM_EMPLOYEE_TRAINING_1_FROM_HRM_EMPLOYEE_TRAINING_TITLE',
  'get_subpanel_data' => 'hrm_employee_info_hrm_employee_training_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
