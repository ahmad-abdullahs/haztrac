<?php
$popupMeta = array (
    'moduleMain' => 'HT_Manifest',
    'varName' => 'HT_Manifest',
    'orderBy' => 'ht_manifest.name',
    'whereClauses' => array (
  'name' => 'ht_manifest.name',
  'assigned_user_id' => 'ht_manifest.assigned_user_id',
  'favorites_only' => 'ht_manifest.favorites_only',
  'manifest_number' => 'ht_manifest.manifest_number',
  'start_date_c' => 'ht_manifest_cstm.start_date_c',
  'status_c' => 'ht_manifest_cstm.status_c',
  'manifest_no_actual_c' => 'ht_manifest_cstm.manifest_no_actual_c',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'assigned_user_id',
  5 => 'favorites_only',
  6 => 'manifest_number',
  7 => 'start_date_c',
  8 => 'status_c',
  9 => 'manifest_no_actual_c',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => 10,
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
    'width' => 10,
  ),
  'favorites_only' => 
  array (
    'name' => 'favorites_only',
    'label' => 'LBL_FAVORITES_FILTER',
    'type' => 'bool',
    'width' => 10,
  ),
  'manifest_number' => 
  array (
    'type' => 'varchar',
    'readonly' => true,
    'label' => 'LBL_MANIFEST_NUMBER',
    'width' => 10,
    'name' => 'manifest_number',
  ),
  'start_date_c' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => 10,
    'name' => 'start_date_c',
  ),
  'status_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_STATUS',
    'width' => 10,
    'name' => 'status_c',
  ),
  'manifest_no_actual_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_MANIFEST_NO_ACTUAL',
    'width' => 10,
    'name' => 'manifest_no_actual_c',
  ),
),
    'listviewdefs' => array (
  'START_DATE_C' => 
  array (
    'type' => 'date',
    'label' => 'LBL_START_DATE',
    'width' => 10,
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'CONSOLIDATE_C' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_CONSOLIDATE',
    'width' => 10,
  ),
  'ACCOUNTS_HT_MANIFEST_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_ACCOUNTS_TITLE',
    'id' => 'ACCOUNTS_HT_MANIFEST_1ACCOUNTS_IDA',
    'width' => 10,
    'default' => true,
  ),
  'HT_MANIFEST_V_VENDORS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_HT_MANIFEST_V_VENDORS_FROM_V_VENDORS_TITLE',
    'id' => 'HT_MANIFEST_V_VENDORSHT_MANIFEST_IDA',
    'width' => 10,
    'default' => true,
  ),
  'STATUS_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_STATUS',
    'width' => 10,
  ),
  'TEAM_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_TEAM',
    'default' => true,
    'name' => 'team_name',
  ),
  'MANIFEST_NUMBER' => 
  array (
    'type' => 'varchar',
    'readonly' => true,
    'label' => 'LBL_MANIFEST_NUMBER',
    'width' => 10,
    'default' => true,
  ),
  'TRANSPORTER' => 
  array (
    'type' => 'text',
    'label' => 'LBL_TRANSPORTER',
    'sortable' => false,
    'width' => 10,
    'default' => true,
  ),
),
);
