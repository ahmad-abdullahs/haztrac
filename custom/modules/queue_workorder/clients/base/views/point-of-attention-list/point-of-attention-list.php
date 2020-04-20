<?php

$viewdefs['queue_workorder']['base']['view']['point-of-attention-list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'sales_and_services_queue_workorder_1_name',
                    'label' => 'LBL_SALES_AND_SERVICES_QUEUE_WORKORDER_1_FROM_SALES_AND_SERVICES_TITLE',
                    'enabled' => true,
                    'id' => 'SALES_AND_SERVICES_QUEUE_WORKORDER_1SALES_AND_SERVICES_IDA',
                    'link' => true,
                    'sortable' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'account_c',
                    'label' => 'LBL_ACCOUNT',
                    'enabled' => true,
                    'id' => 'ACCOUNT_ID_C',
                    'link' => true,
                    'sortable' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'quantity',
                    'label' => 'LBL_QUANTITY',
                    'enabled' => true,
                    'default' => true,
                    'width' => 'xsmall',
                ),
                array(
                    'name' => 'print_status',
                    'label' => 'LBL_PRINT_STATUS',
                    'enabled' => true,
                    'default' => true,
                    'width' => 'xsmall',
                ),
                array(
                    'name' => 'print_date',
                    'label' => 'LBL_PRINT_DATE',
                    'enabled' => true,
                    'default' => true,
                    'width' => 'small',
                ),
            )
        ),
    ),
);
