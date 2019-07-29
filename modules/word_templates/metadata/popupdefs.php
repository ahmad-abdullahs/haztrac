<?php
$popupMeta = array (
    'moduleMain' => 'word_templates',
    'varName' => 'word_templates',
    'orderBy' => 'word_templates.name',
    'whereClauses' => array (
  'document_name' => 'word_templates.document_name',
),
    'searchInputs' => array (
  4 => 'document_name',
),
    'searchdefs' => array (
  'document_name' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => 10,
    'name' => 'document_name',
  ),
),
    'listviewdefs' => array (
  'DOCUMENT_NAME' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => 10,
    'default' => true,
    'name' => 'document_name',
  ),
  'UPLOADFILE' => 
  array (
    'type' => 'file',
    'label' => 'LBL_FILE_UPLOAD',
    'width' => 10,
    'default' => true,
  ),
  'MODULE_NAME' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_WORD_TEMP_MODULE',
    'width' => 10,
    'default' => true,
    'name' => 'module_name',
  ),
),
);
