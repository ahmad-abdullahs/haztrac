<?php

// created: 2019-08-31 02:38:01
// Subpanel of RevenueLineItems shown on Accounts record view
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-accounts-revenuelineitems'] = array(
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
                        0 => 'currency_id',
                        1 => 'base_rate',
                        2 => 'is_bundle_product_c',
                    ),
                ),
                1 =>
                array(
                    'name' => 'account_name',
                    'link' => true,
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
                    'enabled' => true,
                    'default' => true,
                ),
                6 =>
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
                7 =>
                array(
                    'name' => 'unit_of_measure_c',
                    'label' => 'LBL_UNIT_OF_MEASURE',
                    'enabled' => true,
                    'default' => true,
                ),
                8 =>
                array(
                    'name' => 'related_rli_total_c',
                    'label' => 'LBL_RELATED_RLI_TOTAL',
                    'enabled' => true,
                    'default' => true,
                ),
                9 =>
                array(
                    'name' => 'total_amount',
                    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
                    'enabled' => true,
                    'related_fields' =>
                    array(
                        0 => 'currency_id',
                        1 => 'base_rate',
                        2 => 'is_bundle_product_c',
                        3 => 'rli_as_template_c',
                    ),
                    'currency_format' => true,
                    'default' => true,
                ),
                10 =>
                array(
                    'name' => 'close_amount_c',
                    'label' => 'LBL_CLOSE_AMOUNT',
                    'enabled' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
    'selection' =>
    array(
    ),
    'rowactions' =>
    array(
        'css_class' => 'pull-right',
        'actions' =>
        array(
            0 =>
            array(
                'type' => 'rowaction',
                'css_class' => 'btn',
                'tooltip' => 'LBL_PREVIEW',
                'event' => 'list:preview:fire',
                'icon' => 'fa-eye',
                'acl_action' => 'view',
            ),
            1 =>
            array(
                'type' => 'rowaction',
                'name' => 'edit_button',
                'icon' => 'fa-pencil',
                'label' => 'LBL_EDIT_BUTTON',
                'event' => 'list:editrow:fire',
                'acl_action' => 'edit',
            ),
        ),
    ),
);
