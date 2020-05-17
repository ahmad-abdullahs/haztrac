<?php
$popupMeta = array (
    'moduleMain' => 'LR_Lab_Reports',
    'varName' => 'LR_Lab_Reports',
    'orderBy' => 'lr_lab_reports.name',
    'whereClauses' => array (
  'name' => 'lr_lab_reports.name',
),
    'searchInputs' => array (
  0 => 'lr_lab_reports_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
),
    'listviewdefs' => array (
  'DOCUMENT_NAME' => 
  array (
    'width' => '40',
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'name' => 'document_name',
  ),
  'SAMPLE_ID_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SAMPLE_ID_NUMBER',
    'width' => 10,
    'default' => true,
    'name' => 'sample_id_number_c',
  ),
  'OTHER_REF_NUMBER_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_OTHER_REF_NUMBER',
    'width' => 10,
    'default' => true,
    'name' => 'other_ref_number_c',
  ),
  'STATUS_ID' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_DOC_STATUS',
    'width' => 10,
    'name' => 'status_id',
  ),
  'MANIFEST_GALON_TOTAL' => 
  array (
    'type' => 'decimal',
    'label' => 'LBL_MANIFEST_GALON_TOTAL',
    'width' => 10,
    'default' => true,
  ),
  'ACCOUNTS_LR_LAB_REPORTS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'default' => true,
    'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_1_FROM_ACCOUNTS_TITLE_CST',
    'id' => 'ACCOUNTS_LR_LAB_REPORTS_1ACCOUNTS_IDA',
    'width' => 10,
    'name' => 'accounts_lr_lab_reports_1_name',
  ),
  'ACCOUNTS_LR_LAB_REPORTS_2_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'default' => true,
    'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_2_FROM_ACCOUNTS_TITLE_CST',
    'id' => 'ACCOUNTS_LR_LAB_REPORTS_2ACCOUNTS_IDA',
    'width' => 10,
    'name' => 'accounts_lr_lab_reports_2_name',
  ),
  'ACCOUNTS_LR_LAB_REPORTS_3_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'default' => true,
    'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_ACCOUNTS_TITLE_CST',
    'id' => 'ACCOUNTS_LR_LAB_REPORTS_3ACCOUNTS_IDA',
    'width' => 10,
    'name' => 'accounts_lr_lab_reports_3_name',
  ),
  'GENERATOR_C' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_GENERATOR',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'name' => 'generator_c',
  ),
  'COMMODITY_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_COMMODITY',
    'width' => 10,
    'default' => true,
    'name' => 'commodity_c',
  ),
),
);
