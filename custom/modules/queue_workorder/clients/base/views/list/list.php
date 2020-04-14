<?php
$module_name = 'queue_workorder';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'sales_and_services_queue_workorder_1_name',
                'label' => 'LBL_SALES_AND_SERVICES_QUEUE_WORKORDER_1_FROM_SALES_AND_SERVICES_TITLE',
                'enabled' => true,
                'id' => 'SALES_AND_SERVICES_QUEUE_WORKORDER_1SALES_AND_SERVICES_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'account_c',
                'label' => 'LBL_ACCOUNT',
                'enabled' => true,
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'selected_printer',
                'label' => 'LBL_SELECTED_PRINTER',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'quantity',
                'label' => 'LBL_QUANTITY',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              6 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'pdf_template_name',
                'label' => 'LBL_PDF_TEMPLATE_NAME',
                'enabled' => true,
                'id' => 'PDF_TEMPLATE_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
