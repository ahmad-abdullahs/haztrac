<?php
$popupMeta = array (
    'moduleMain' => 'HRM_Employee_Info',
    'varName' => 'HRM_Employee_Info',
    'orderBy' => 'hrm_employee_info.first_name, hrm_employee_info.last_name',
    'whereClauses' => array (
  'first_name' => 'hrm_employee_info.first_name',
  'last_name' => 'hrm_employee_info.last_name',
  'employee_id_num' => 'hrm_employee_info.employee_id_num',
  'address_city' => 'hrm_employee_info.address_city',
  'created_by_name' => 'hrm_employee_info.created_by_name',
  'do_not_call' => 'hrm_employee_info.do_not_call',
  'email' => 'hrm_employee_info.email',
  'favorites_only' => 'hrm_employee_info.favorites_only',
),
    'searchInputs' => array (
  0 => 'first_name',
  1 => 'last_name',
  2 => 'employee_id_num',
  3 => 'address_city',
  4 => 'created_by_name',
  5 => 'do_not_call',
  6 => 'email',
  7 => 'favorites_only',
),
    'searchdefs' => array (
  'first_name' => 
  array (
    'name' => 'first_name',
    'width' => 10,
  ),
  'last_name' => 
  array (
    'name' => 'last_name',
    'width' => 10,
  ),
  'employee_id_num' => 
  array (
    'type' => 'varchar',
    'readonly' => true,
    'label' => 'LBL_EMPLOYEE_ID_NUM',
    'width' => 10,
    'name' => 'employee_id_num',
  ),
  'address_city' => 
  array (
    'name' => 'address_city',
    'width' => 10,
  ),
  'created_by_name' => 
  array (
    'name' => 'created_by_name',
    'width' => 10,
  ),
  'do_not_call' => 
  array (
    'name' => 'do_not_call',
    'width' => 10,
  ),
  'email' => 
  array (
    'name' => 'email',
    'width' => 10,
  ),
  'favorites_only' => 
  array (
    'name' => 'favorites_only',
    'label' => 'LBL_FAVORITES_FILTER',
    'type' => 'bool',
    'width' => 10,
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'link' => true,
    'orderBy' => 'last_name',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'first_name',
      1 => 'last_name',
      2 => 'salutation',
    ),
    'name' => 'name',
  ),
  'EMPLOYEE_ID_NUM' => 
  array (
    'type' => 'varchar',
    'readonly' => true,
    'label' => 'LBL_EMPLOYEE_ID_NUM',
    'width' => 10,
    'default' => true,
  ),
  'TEAM_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_TEAM',
    'default' => true,
    'name' => 'team_name',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'default' => true,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
),
);
