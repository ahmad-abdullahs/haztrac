<?php

$viewdefs['RevenueLineItems']['base']['view']['related-account-revenuelineitems'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'link' => true,
                    'label' => 'LBL_LIST_NAME',
                    'enabled' => true,
                    'default' => true,
                    'type' => 'relate-populate-rli',
                    'related_fields' =>
                    array(
                        'name',
                        'description',
                        'product_template_id',
                        'product_template_name',
                        'account_id',
                        'type_id',
                        'manufacturer_id',
                        'manufacturer_name',
                        'category_id',
                        'category_name',
                        'cost_price',
                        'discount_price',
                        'list_price',
                        'cost_usdollar',
                        'discount_usdollar',
                        'list_usdollar',
                        'status',
                        'weight',
                        'pricing_formula',
                        'best_case',
                        'likely_case',
                        'worst_case',
                        'product_type',
                        'type_name',
                        'products',
                        'account_name',
                        'assigned_user_id',
                        'assigned_user_name',
                        'is_bundle_product_c',
                        'rli_as_template_c',
                        'product_uom_c',
                        'ht_manifest_revenuelineitems_1_name',
                        'ht_manifest_revenuelineitems_1',
                        'ht_manifest_revenuelineitems_1ht_manifest_ida',
                    ),
                ),
                array(
                    'name' => 'related_rli_total_c',
                    'label' => 'LBL_BUNDLE_TOTAL',
                    'sortable' => false,
                    'enabled' => true,
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
                    ),
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
            )
        ),
    ),
);
