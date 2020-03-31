<?php

// created: 2019-08-26 15:41:42
// Subpanel of RevenueLineItems shown on RevenueLineItems record view.
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-revenuelineitems-revenuelineitems_revenuelineitems_1'] = array(
    'favorite' => true,
    'panels' =>
    array(
        0 =>
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'name' => 'name',
                    'link' => true,
                    'label' => 'LBL_LIST_NAME',
                    'enabled' => true,
                    'default' => true,
                    'type' => 'open-in-drawer',
                    'related_fields' =>
                    array(
                        0 => 'commentlog',
                    ),
                ),
                array(
                    'name' => 'account_name',
                    'link' => true,
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'ht_manifest_revenuelineitems_1_name',
                    'label' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
                    'enabled' => true,
                    'id' => 'HT_MANIFEST_REVENUELINEITEMS_1HT_MANIFEST_IDA',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                array(
                    'name' => 'estimated_quantity_c',
                    'label' => 'LBL_ESTIMATED_QUANTITY',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'quantity',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'product_uom_c',
                    'label' => 'LBL_UNIT_OF_MEASURE',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'discount_price',
                    'label' => 'LBL_DISCOUNT_PRICE',
                    'enabled' => true,
                    'related_fields' =>
                    array(
                        0 => 'currency_id',
                        1 => 'base_rate',
                        2 => 'is_bundle_product_c',
                        3 => 'rli_as_template_c',
                        4 => 'line_number',
                    ),
                    'currency_format' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'estimated_total_amount',
                    'label' => 'LBL_ESTIMATED_TOTAL_AMOUNT',
                    'enabled' => true,
                    'currency_format' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'total_amount',
                    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
                    'enabled' => true,
                    'related_fields' =>
                    array(
                        0 => 'currency_id',
                        1 => 'base_rate',
                        2 => 'discount_amount',
                    ),
                    'currency_format' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'sortable' => false,
                    'enabled' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
