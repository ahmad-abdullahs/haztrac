<?php
// created: 2020-08-24 15:38:01
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'employee_name_c' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_EMPLOYEE_NAME',
    'id' => 'HRM_EMPLOYEE_INFO_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'HRM_Employee_Info',
    'target_record_key' => 'hrm_employee_info_id_c',
  ),
  'employee_training_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_EMPLOYEE_TRAINING',
    'width' => 10,
  ),
  'provider_school_c' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_PROVIDER_SCHOOL',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'account_id_c',
  ),
  'duration_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_DURATION',
    'width' => 10,
  ),
  'compatibility_level_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_COMPATIBILITY_LEVEL',
    'width' => 10,
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'vname' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'default' => true,
  ),
);