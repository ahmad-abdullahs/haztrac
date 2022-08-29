<?php
$popupMeta = array (
    'moduleMain' => 'Test_Method',
    'varName' => 'Test_Method',
    'orderBy' => 'test_method.name',
    'whereClauses' => array (
  'name' => 'test_method.name',
  'method' => 'test_method.method',
  'status' => 'test_method.status',
  'uom' => 'test_method.uom',
  'assigned_user_id' => 'test_method.assigned_user_id',
  'favorites_only' => 'test_method.favorites_only',
  'test_name' => 'test_method.test_name',
  'alternate_name' => 'test_method.alternate_name',
),
    'searchInputs' => array (
  1 => 'name',
  3 => 'status',
  4 => 'method',
  5 => 'uom',
  6 => 'assigned_user_id',
  7 => 'favorites_only',
  8 => 'test_name',
  9 => 'alternate_name',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10',
  ),
  'method' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_METHOD',
    'width' => '10',
    'name' => 'method',
  ),
  'status' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_STATUS',
    'width' => '10',
    'name' => 'status',
  ),
  'uom' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_UOM',
    'width' => '10',
    'name' => 'uom',
  ),
  'test_name' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TEST_NAME',
    'width' => 10,
    'name' => 'test_name',
  ),
  'alternate_name' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ALTERNATE_NAME',
    'width' => 10,
    'name' => 'alternate_name',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10',
  ),
  'favorites_only' => 
  array (
    'name' => 'favorites_only',
    'label' => 'LBL_FAVORITES_FILTER',
    'type' => 'bool',
    'width' => '10',
  ),
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
  'METHOD' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_METHOD',
    'width' => 10,
    'default' => true,
    'name' => 'method',
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_STATUS',
    'width' => 10,
    'name' => 'status',
  ),
  'UOM' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_UOM',
    'width' => 10,
    'default' => true,
    'name' => 'uom',
  ),
  'TEST_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TEST_NAME',
    'width' => 10,
    'default' => true,
  ),
  'ALTERNATE_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ALTERNATE_NAME',
    'width' => 10,
    'default' => true,
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
    'name' => 'date_modified',
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'default' => true,
  ),
),
);
