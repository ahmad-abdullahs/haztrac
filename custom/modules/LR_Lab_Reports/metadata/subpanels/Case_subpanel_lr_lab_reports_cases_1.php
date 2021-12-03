<?php
// created: 2021-11-04 19:48:28
$subpanel_layout['list_fields'] = array (
  'document_name' => 
  array (
    'name' => 'document_name',
    'vname' => 'LBL_LIST_DOCUMENT_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'analysis_date_c' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_ANALYSIS_DATE',
    'width' => 10,
    'default' => true,
  ),
  'sample_id_number_c' => 
  array (
    'readonly' => true,
    'type' => 'varchar',
    'vname' => 'LBL_SAMPLE_ID_NUMBER',
    'width' => 10,
    'default' => true,
  ),
  'report_number' => 
  array (
    'type' => 'int',
    'readonly' => true,
    'studio' => 
    array (
      'quickcreate' => false,
    ),
    'vname' => 'LBL_NUMBER',
    'width' => 10,
    'default' => true,
  ),
  'project_name_c' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_PROJECT_NAME',
    'width' => 10,
    'default' => true,
  ),
  'accounts_lr_lab_reports_3_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'default' => true,
    'vname' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_ACCOUNTS_TITLE_CST',
    'id' => 'ACCOUNTS_LR_LAB_REPORTS_3ACCOUNTS_IDA',
    'width' => 10,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'accounts_lr_lab_reports_3accounts_ida',
  ),
);