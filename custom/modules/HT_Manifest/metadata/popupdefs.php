<?php
$popupMeta = array (
    'moduleMain' => 'HT_Manifest',
    'varName' => 'HT_Manifest',
    'orderBy' => 'ht_manifest.name',
    'whereClauses' => array (
  'name' => 'ht_manifest.name',
),
    'searchInputs' => array (
  0 => 'ht_manifest_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
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
