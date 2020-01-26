<?php
$popupMeta = array (
    'moduleMain' => 'WPM_Waste_Profile_Module',
    'varName' => 'WPM_Waste_Profile_Module',
    'orderBy' => 'wpm_waste_profile_module.name',
    'whereClauses' => array (
  'name' => 'wpm_waste_profile_module.name',
),
    'searchInputs' => array (
  0 => 'wpm_waste_profile_module_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
    'id' => 'WPM_WASTE_PROFILE_MODULE_ACCOUNTS_1ACCOUNTS_IDB',
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
    'width' => 10,
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
    'name' => 'assigned_user_name',
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
