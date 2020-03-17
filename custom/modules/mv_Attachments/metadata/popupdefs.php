<?php
$popupMeta = array (
    'moduleMain' => 'mv_Attachments',
    'varName' => 'mv_Attachments',
    'orderBy' => 'mv_attachments.name',
    'whereClauses' => array (
  'document_name' => 'mv_attachments.document_name',
  'analysis_date' => 'mv_attachments.analysis_date',
  'lab_ref_number' => 'mv_attachments.lab_ref_number',
  'category_id' => 'mv_attachments.category_id',
  'subcategory_id' => 'mv_attachments.subcategory_id',
  'active_date' => 'mv_attachments.active_date',
  'exp_date' => 'mv_attachments.exp_date',
  'favorites_only' => 'mv_attachments.favorites_only',
),
    'searchInputs' => array (
  4 => 'document_name',
  5 => 'analysis_date',
  6 => 'lab_ref_number',
  7 => 'category_id',
  8 => 'subcategory_id',
  9 => 'active_date',
  10 => 'exp_date',
  11 => 'favorites_only',
),
    'searchdefs' => array (
  'document_name' => 
  array (
    'name' => 'document_name',
    'width' => 10,
  ),
  'analysis_date' => 
  array (
    'type' => 'date',
    'label' => 'LBL_ANALYSIS_DATE',
    'width' => 10,
    'name' => 'analysis_date',
  ),
  'lab_ref_number' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LAB_REF_NUMBER',
    'width' => 10,
    'name' => 'lab_ref_number',
  ),
  'category_id' => 
  array (
    'name' => 'category_id',
    'width' => 10,
  ),
  'subcategory_id' => 
  array (
    'name' => 'subcategory_id',
    'width' => 10,
  ),
  'active_date' => 
  array (
    'name' => 'active_date',
    'width' => 10,
  ),
  'exp_date' => 
  array (
    'name' => 'exp_date',
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
  'DOCUMENT_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'name' => 'document_name',
  ),
  'LAB_REF_NUMBER' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_LAB_REF_NUMBER',
    'width' => 10,
    'default' => true,
  ),
  'ANALYSIS_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_ANALYSIS_DATE',
    'width' => 10,
    'default' => true,
  ),
  'CATEGORY_ID' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_CATEGORY',
    'default' => true,
    'name' => 'category_id',
  ),
),
);
