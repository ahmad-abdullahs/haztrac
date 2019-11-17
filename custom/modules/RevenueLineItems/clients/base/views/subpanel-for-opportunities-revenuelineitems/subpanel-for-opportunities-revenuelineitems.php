<?php

// created: 2019-09-09 06:08:43
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-opportunities-revenuelineitems'] = array(
    'type' => 'subpanel-list',
    'favorite' => true,
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
                    'name' => 'name',
                    'link' => true,
                    'label' => 'LBL_LIST_NAME',
                    'enabled' => true,
                    'default' => true,
                    'related_fields' =>
                    array(
                        0 => 'mft_part_num',
                    ),
                ),
                1 =>
                array(
                    'name' => 'account_name',
                    'readonly' => true,
                    'enabled' => true,
                    'default' => true,
                ),
                2 =>
                array(
                    'name' => 'sales_and_services_revenuelineitems_1_name',
                    'label' => 'LBL_SALES_AND_SERVICES_REVENUELINEITEMS_1_FROM_SALES_AND_SERVICES_TITLE',
                    'enabled' => true,
                    'id' => 'SALES_AND_SERVICES_REVENUELINEITEMS_1SALES_AND_SERVICES_IDA',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                3 =>
                array(
                    'name' => 'ht_manifest_revenuelineitems_1_name',
                    'label' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
                    'enabled' => true,
                    'id' => 'HT_MANIFEST_REVENUELINEITEMS_1HT_MANIFEST_IDA',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                4 =>
                array(
                    'name' => 'estimated_quantity_c',
                    'label' => 'LBL_ESTIMATED_QUANTITY',
                    'enabled' => true,
                    'default' => true,
                ),
                5 =>
                array(
                    'name' => 'quantity',
                    'label' => 'LBL_QUANTITY',
                    'enabled' => true,
                    'default' => true,
                ),
                6 =>
                array(
                    'name' => 'date_closed',
                    'label' => 'LBL_DATE_CLOSED',
                    'enabled' => true,
                    'related_fields' =>
                    array(
                        0 => 'date_closed_timestamp',
                    ),
                    'default' => true,
                ),
                7 =>
                array(
                    'name' => 'discount_price',
                    'label' => 'LBL_DISCOUNT_PRICE',
                    'enabled' => true,
                    'related_fields' =>
                    array(
                        0 => 'currency_id',
                        1 => 'base_rate',
                    ),
                    'currency_format' => true,
                    'default' => true,
                ),
                8 =>
                array(
                    'name' => 'product_uom_c',
                    'label' => 'LBL_UNIT_OF_MEASURE',
                    'enabled' => true,
                    'default' => true,
                ),
                9 =>
                array(
                    'name' => 'related_rli_total_c',
                    'label' => 'LBL_RELATED_RLI_TOTAL',
                    'enabled' => true,
                    'default' => true,
                ),
                10 =>
                array(
                    'name' => 'estimated_total_amount',
                    'label' => 'LBL_ESTIMATED_TOTAL_AMOUNT',
                    'enabled' => true,
                    'currency_format' => true,
                    'default' => true,
                ),
                11 =>
                array(
                    'name' => 'total_amount',
                    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
                    'enabled' => true,
                    'related_fields' =>
                    array(
                        0 => 'currency_id',
                        1 => 'base_rate',
                    ),
                    'currency_format' => true,
                    'default' => true,
                ),
                12 =>
                array(
                    'name' => 'close_amount_c',
                    'label' => 'LBL_CLOSE_AMOUNT',
                    'enabled' => true,
                    'default' => true,
                ),
                13 =>
                array(
                    'name' => 'quote_name',
                    'label' => 'LBL_ASSOCIATED_QUOTE',
                    'related_fields' =>
                    array(
                        0 => 'quote_id',
                    ),
                    'readonly' => true,
                    'bwcLink' => true,
                    'enabled' => true,
                    'default' => true,
                ),
                14 =>
                array(
                    'name' => 'category_name',
                    'enabled' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
    'selection' =>
    array(
        'type' => 'multi',
        'actions' =>
        array(
            0 =>
            array(
                'name' => 'quote_button',
                'type' => 'button',
                'label' => 'LBL_GENERATE_QUOTE',
                'primary' => true,
                'events' =>
                array(
                    'click' => 'list:massquote:fire',
                ),
                'acl_module' => 'Quotes',
                'acl_action' => 'create',
                'related_fields' =>
                array(
                    0 => 'account_id',
                    1 => 'account_name',
                    2 => 'assigned_user_id',
                    3 => 'assigned_user_name',
                    4 => 'base_rate',
                    5 => 'best_case',
                    6 => 'book_value',
                    7 => 'category_id',
                    8 => 'category_name',
                    9 => 'commit_stage',
                    10 => 'cost_price',
                    11 => 'currency_id',
                    12 => 'date_closed',
                    13 => 'deal_calc',
                    14 => 'likely_case',
                    15 => 'list_price',
                    16 => 'mft_part_num',
                    17 => 'my_favorite',
                    18 => 'name',
                    19 => 'probability',
                    20 => 'product_template_id',
                    21 => 'product_template_name',
                    22 => 'quote_id',
                    23 => 'quote_name',
                    24 => 'worst_case',
                ),
            ),
            1 =>
            array(
                'name' => 'massdelete_button',
                'type' => 'button',
                'label' => 'LBL_DELETE',
                'acl_action' => 'delete',
                'primary' => true,
                'events' =>
                array(
                    'click' => 'list:massdelete:fire',
                ),
                'related_fields' =>
                array(
                    0 => 'sales_stage',
                ),
            ),
        ),
    ),
//    'rowactions' =>
//    array(
//        'css_class' => 'pull-right',
//        'actions' =>
//        array(
//            0 =>
//            array(
//                'type' => 'rowaction',
//                'css_class' => 'btn',
//                'tooltip' => 'LBL_PREVIEW',
//                'event' => 'list:preview:fire',
//                'icon' => 'fa-eye',
//                'acl_action' => 'view',
//            ),
//            1 =>
//            array(
//                'type' => 'rowaction',
//                'name' => 'edit_button',
//                'icon' => 'fa-pencil',
//                'label' => 'LBL_EDIT_BUTTON',
//                'event' => 'list:editrow:fire',
//                'acl_action' => 'edit',
//            ),
//        ),
//    ),
);
