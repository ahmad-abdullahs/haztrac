<?php

// created: 2019-06-17 16:45:52
$viewdefs['RevenueLineItems']['base']['view']['subpanel-ht_manifest_subpanel_ht_manifest_revenuelineitems_1'] = array(
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
                    'default' => true,
                    'label' => 'LBL_LIST_NAME',
                    'enabled' => true,
                    'name' => 'name',
                    'link' => true,
                    'type' => 'name',
                    'related_fields' =>
                    array(
                        0 => 'commentlog',
                    ),
                ),
                1 =>
                array(
                    'type' => 'relate',
                    'link' => true,
                    'default' => true,
                    'target_module' => 'HT_Manifest',
                    'target_record_key' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
                    'label' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
                    'enabled' => true,
                    'name' => 'ht_manifest_revenuelineitems_1_name',
                ),
                2 =>
                array(
                    'type' => 'decimal',
                    'default' => true,
                    'label' => 'LBL_ESTIMATED_QUANTITY',
                    'enabled' => true,
                    'name' => 'estimated_quantity_c',
                ),
                3 =>
                array(
                    'default' => true,
                    'label' => 'LBL_QUANTITY',
                    'enabled' => true,
                    'name' => 'quantity',
                    'type' => 'decimal',
                ),
                4 =>
                array(
                    'type' => 'enum',
                    'default' => true,
                    'label' => 'LBL_UNIT_OF_MEASURE',
                    'enabled' => true,
                    'name' => 'product_uom_c',
                ),
                5 =>
                array(
                    'type' => 'currency',
                    'default' => true,
                    'label' => 'LBL_CHARGE',
                    'enabled' => true,
                    'name' => 'charge_c',
                ),
                6 =>
                array(
                    'name' => 'estimated_total_amount',
                    'label' => 'LBL_ESTIMATED_TOTAL_AMOUNT',
                    'enabled' => true,
                    'currency_format' => true,
                    'default' => true,
                ),
                7 =>
                array(
                    'type' => 'currency',
                    'default' => true,
                    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
                    'enabled' => true,
                    'name' => 'total_amount',
                ),
                8 =>
                array(
                    'type' => 'decimal',
                    'default' => true,
                    'label' => 'LBL_CLOSE_AMOUNT',
                    'enabled' => true,
                    'name' => 'close_amount_c',
                ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
