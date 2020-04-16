<?php
// created: 2020-04-15 01:29:55
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'account_c' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_ACCOUNT',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'account_id_c',
  ),
  'quantity' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_QUANTITY',
    'width' => 10,
    'default' => true,
  ),
  'print_date' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_PRINT_DATE',
    'width' => 10,
    'default' => true,
  ),
  'pdf_template_type' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_PDF_TEMPLATE_TYPE',
    'width' => 10,
    'default' => true,
  ),
  'selected_printer' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_SELECTED_PRINTER',
    'width' => 10,
    'default' => true,
  ),
);