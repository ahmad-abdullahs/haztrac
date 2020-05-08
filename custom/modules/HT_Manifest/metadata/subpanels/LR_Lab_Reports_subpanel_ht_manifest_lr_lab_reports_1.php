<?php
// created: 2020-05-08 00:36:51
$subpanel_layout['list_fields'] = array (
  'manifest_no_actual_c' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_MANIFEST_NO_ACTUAL',
    'width' => 10,
    'default' => true,
  ),
  'manifest_number' => 
  array (
    'type' => 'varchar',
    'readonly' => true,
    'vname' => 'LBL_MANIFEST_NUMBER',
    'width' => 10,
    'default' => true,
  ),
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'accounts_ht_manifest_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_ACCOUNTS_TITLE',
    'id' => 'ACCOUNTS_HT_MANIFEST_1ACCOUNTS_IDA',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'accounts_ht_manifest_1accounts_ida',
  ),
  'status_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_STATUS',
    'width' => 10,
  ),
  'start_date_c' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_START_DATE',
    'width' => 10,
    'default' => true,
  ),
  'complete_date_c' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_COMPLETE_DATE',
    'width' => 10,
    'default' => true,
  ),
);