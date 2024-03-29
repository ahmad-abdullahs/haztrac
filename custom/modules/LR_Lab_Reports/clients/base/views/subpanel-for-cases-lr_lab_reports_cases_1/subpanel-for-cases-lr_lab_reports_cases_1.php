<?php
// created: 2021-11-04 19:48:28
$viewdefs['LR_Lab_Reports']['base']['view']['subpanel-for-cases-lr_lab_reports_cases_1'] = array (
  'rowactions' => 
  array (
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'rowaction',
        'css_class' => 'btn',
        'tooltip' => 'LBL_PREVIEW',
        'event' => 'list:preview:fire',
        'icon' => 'fa-eye',
        'acl_action' => 'view',
      ),
      1 => 
      array (
        'type' => 'rowaction',
        'name' => 'edit_button',
        'icon' => 'fa-pencil',
        'label' => 'LBL_EDIT_BUTTON',
        'event' => 'list:editrow:fire',
        'acl_action' => 'edit',
      ),
      2 => 
      array (
        'type' => 'unlink-action',
        'icon' => 'fa-chain-broken',
        'label' => 'LBL_UNLINK_BUTTON',
      ),
      3 => 
      array (
        'type' => 'report-preview',
        'label' => 'LBL_REPORT_PREVIEW',
        'acl_action' => 'view',
      ),
    ),
  ),
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
          'name' => 'document_name',
          'label' => 'LBL_LIST_DOCUMENT_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'analysis_date_c',
          'label' => 'LBL_ANALYSIS_DATE',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'sample_id_number_c',
          'label' => 'LBL_SAMPLE_ID_NUMBER',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'report_number',
          'label' => 'LBL_NUMBER',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'project_name_c',
          'label' => 'LBL_PROJECT_NAME',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'accounts_lr_lab_reports_3_name',
          'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_ACCOUNTS_TITLE_CST',
          'enabled' => true,
          'id' => 'ACCOUNTS_LR_LAB_REPORTS_3ACCOUNTS_IDA',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);