<?php

// created: 2019-11-27 04:47:04
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-sales_and_services-sales_and_services_revenuelineitems_1'] = array(
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
                    'type' => 'open-in-drawer',
                    'related_fields' =>
                    array_merge(
                            array(
                        'currency_id',
                        'base_rate',
                        'is_bundle_product_c',
                        'v_vendors_id_c',
                        'manifest_required_c',
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
                        'product_vendor_c',
                        'v_vendors_id_c',
                        'shipping_hazardous_materia_c',
                        'state_regulated_c',
                        'mft_part_num',
                        'estimated_total_amount',
                        'product_list_name_c',
                        'commentlog',
                            ), getViewFields('recordview', 'RevenueLineItems')),
                ),
                1 =>
                array(
                    'name' => 'waste_profile_relate_c',
                    'label' => 'LBL_WASTE_PROFILE_RELATE',
                    'enabled' => true,
                    'id' => 'WPM_WASTE_PROFILE_MODULE_ID_C',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                2 =>
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
                3 =>
                array(
                    'type' => 'decimal',
                    'default' => true,
                    'label' => 'LBL_ESTIMATED_QUANTITY',
                    'enabled' => true,
                    'name' => 'estimated_quantity_c',
                ),
                4 =>
                array(
                    'default' => true,
                    'label' => 'LBL_QUANTITY',
                    'enabled' => true,
                    'name' => 'quantity',
                    'type' => 'decimal',
                ),
                5 =>
                array(
                    'type' => 'enum',
                    'default' => true,
                    'label' => 'LBL_UNIT_OF_MEASURE',
                    'enabled' => true,
                    'name' => 'product_uom_c',
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
                        2 => 'is_bundle_product_c',
                        3 => 'rli_as_template_c',
                    ),
                    'currency_format' => true,
                    'default' => true,
                ),
                7 =>
                array(
                    'name' => 'estimated_total_amount',
                    'label' => 'LBL_ESTIMATED_TOTAL_AMOUNT',
                    'enabled' => true,
                    'currency_format' => true,
                    'default' => true,
                ),
                8 =>
                array(
                    'name' => 'total_amount',
                    'type' => 'currency',
                    'default' => true,
                    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
                    'enabled' => true,
                ),
                9 =>
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
