<?php
// created: 2020-05-08 00:36:51
$viewdefs['HT_Manifest']['base']['view']['subpanel-for-lr_lab_reports-ht_manifest_lr_lab_reports_1'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'manifest_no_actual_c',
          'label' => 'LBL_MANIFEST_NO_ACTUAL',
          'enabled' => true,
          'default' => true,
        ),
        1 => 
        array (
          'name' => 'manifest_number',
          'label' => 'LBL_MANIFEST_NUMBER',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        2 => 
        array (
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        3 => 
        array (
          'name' => 'accounts_ht_manifest_1_name',
          'label' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_ACCOUNTS_TITLE',
          'enabled' => true,
          'id' => 'ACCOUNTS_HT_MANIFEST_1ACCOUNTS_IDA',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'status_c',
          'label' => 'LBL_STATUS',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'start_date_c',
          'label' => 'LBL_START_DATE',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'complete_date_c',
          'label' => 'LBL_COMPLETE_DATE',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
  'type' => 'subpanel-list',
);