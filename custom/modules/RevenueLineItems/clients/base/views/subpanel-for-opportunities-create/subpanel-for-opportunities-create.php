<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-opportunities-create'] = array(
    'rowactions' => array(
        'actions' => array(
            array(
                'type' => 'rowaction',
                'css_class' => 'btn deleteBtn',
                'icon' => 'fa-minus',
                'event' => 'list:deleterow:fire',
            ),
            array(
                'type' => 'rowaction',
                'css_class' => 'btn addBtn',
                'icon' => 'fa-plus',
                'event' => 'list:addrow:fire',
            ),
        ),
    ),
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
                    'related_fields' =>
                    array(
                        'name',
                        'line_number',
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
                    'name' => 'ht_manifest_revenuelineitems_1_name',
                    'label' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
                    'enabled' => true,
                    'id' => 'HT_MANIFEST_REVENUELINEITEMS_1HT_MANIFEST_IDA',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                array(
                    'name' => 'type_name',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'estimated_quantity_c',
                    'label' => 'LBL_ESTIMATED_QUANTITY',
                    'enabled' => true,
                    'default' => true,
                ),
//                array(
//                    'name' => 'quantity',
//                    'enabled' => true,
//                    'default' => true,
//                ),
                array(
                    'name' => 'product_uom_c',
                    'label' => 'LBL_PRODUCT_UOM',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'discount_price',
                    'type' => 'currency',
                    'related_fields' =>
                    array(
                        0 => 'discount_usdollar',
                        1 => 'currency_id',
                        2 => 'base_rate',
                    ),
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
                    'enabled' => true,
                    'default' => true,
                ),
//                array(
//                    'name' => 'charge_c',
//                    'label' => 'LBL_CHARGE',
//                    'enabled' => true,
//                    'related_fields' =>
//                    array(
//                        0 => 'currency_id',
//                        1 => 'base_rate',
//                    ),
//                    'currency_format' => true,
//                    'default' => true,
//                ),
                array(
                    'name' => 'estimated_total_amount',
                    'label' => 'LBL_ESTIMATED_TOTAL_AMOUNT',
                    'enabled' => true,
                    'currency_format' => true,
                    'default' => true,
                ),
//                array(
//                    'name' => 'total_amount',
//                    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
//                    'enabled' => true,
//                    'related_fields' =>
//                    array(
//                        0 => 'currency_id',
//                        1 => 'base_rate',
//                        2 => 'is_bundle_product_c',
//                        3 => 'rli_as_template_c',
//                    ),
//                    'currency_format' => true,
//                    'default' => true,
//                ),
                array(
                    'name' => 'assigned_user_name',
                    'enabled' => true,
                    'default' => true
                )
            )
        ),
    ),
);
