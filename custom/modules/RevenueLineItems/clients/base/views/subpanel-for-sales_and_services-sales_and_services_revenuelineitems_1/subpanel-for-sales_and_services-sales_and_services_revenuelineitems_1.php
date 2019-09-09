<?php

// created: 2019-08-26 15:47:54
// subpanel of RevenueLineItems shown in Sales and service record view
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-sales_and_services-sales_and_services_revenuelineitems_1'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'default' => true,
                    'label' => 'LBL_LIST_NAME',
                    'enabled' => true,
                    'name' => 'name',
                    'link' => true,
                    'type' => 'name',
                    'related_fields' =>
                    array(
                        0 => 'currency_id',
                        1 => 'base_rate',
                        2 => 'is_bundle_product_c',
                    ),
                ),
                array(
                    'name' => 'account_name',
                    'link' => true,
                    'enabled' => true,
                    'default' => true,
                ),
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
                array(
                    'type' => 'decimal',
                    'default' => true,
                    'label' => 'LBL_ESTIMATED_QUANTITY',
                    'enabled' => true,
                    'name' => 'estimated_quantity_c',
                ),
                array(
                    'default' => true,
                    'label' => 'LBL_QUANTITY',
                    'enabled' => true,
                    'name' => 'quantity',
                    'type' => 'decimal',
                ),
                array(
                    'type' => 'enum',
                    'default' => true,
                    'label' => 'LBL_UNIT_OF_MEASURE',
                    'enabled' => true,
                    'name' => 'unit_of_measure_c',
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
                    ),
                    'currency_format' => true,
                    'default' => true,
                ),
                array(
                    'type' => 'currency',
                    'default' => true,
                    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
                    'enabled' => true,
                    'name' => 'total_amount',
                ),
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
