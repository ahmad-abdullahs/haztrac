<?php

// created: 2020-04-15 01:29:55
$viewdefs['queue_workorder']['base']['view']['subpanel-for-sales_and_services-sales_and_services_queue_workorder_1'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                0 =>
                array(
                    'label' => 'LBL_NAME',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'name',
                    'link' => true,
                    'related_fields' =>
                    array(
                        0 => 'print_status',
                    ),
                ),
                1 =>
                array(
                    'name' => 'account_c',
                    'label' => 'LBL_ACCOUNT',
                    'enabled' => true,
                    'id' => 'ACCOUNT_ID_C',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                2 =>
                array(
                    'name' => 'quantity',
                    'label' => 'LBL_QUANTITY',
                    'enabled' => true,
                    'default' => true,
                ),
                3 =>
                array(
                    'name' => 'print_date',
                    'label' => 'LBL_PRINT_DATE',
                    'enabled' => true,
                    'default' => true,
                ),
                4 =>
                array(
                    'name' => 'pdf_template_type_name',
                    'label' => 'LBL_PDF_TEMPLATE_TYPE',
                    'enabled' => true,
                    'default' => true,
                ),
                5 =>
                array(
                    'name' => 'selected_printer',
                    'label' => 'LBL_SELECTED_PRINTER',
                    'enabled' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
    'orderBy' =>
    array(
        'field' => 'date_modified',
        'direction' => 'desc',
    ),
    'type' => 'subpanel-list',
);
