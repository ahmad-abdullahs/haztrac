<?php
// created: 2020-03-28 16:31:47
$viewdefs['queue_workorder']['base']['view']['subpanel-for-sales_and_services-sales_and_services_queue_workorder_1'] = array (
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
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'pdf_template_type',
          'label' => 'LBL_PDF_TEMPLATE_TYPE',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'selected_printer',
          'label' => 'LBL_SELECTED_PRINTER',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'label' => 'LBL_DATE_MODIFIED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_modified',
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