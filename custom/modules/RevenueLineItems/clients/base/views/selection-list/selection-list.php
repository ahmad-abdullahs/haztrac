<?php

$viewdefs['RevenueLineItems'] = array(
    'base' =>
    array(
        'view' =>
        array(
            'selection-list' =>
            array(
                'panels' =>
                array(
                    0 =>
                    array(
                        'name' => 'panel_header',
                        'label' => 'LBL_PANEL_1',
                        'fields' =>
                        array(
//                            array(
//                                'name' => 'id',
//                                'enabled' => true,
//                                'default' => true,
//                            ),
                            array(
                                'name' => 'name',
                                'link' => true,
                                'label' => 'LBL_LIST_NAME',
                                'enabled' => true,
                                'default' => true,
                                'related_fields' =>
                                array(
                                    0 => 'revenuelineitems_revenuelineitems_1',
                                ),
                            ),
                            array(
                                'name' => 'account_name',
                                'readonly' => true,
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
                                'name' => 'unit_of_measure_c',
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
                                ),
                                'currency_format' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'related_rli_total_c',
                                'label' => 'LBL_RELATED_RLI_TOTAL',
                                'enabled' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'is_bundle_product_c',
                                'label' => 'LBL_IS_BUNDLE_PRODUCT',
                                'enabled' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'rli_type_c',
                                'label' => 'LBL_RLI_TYPE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'probability',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'date_closed',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'commit_stage',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'product_template_name',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'category_name',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'likely_case',
                                'required' => true,
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'currency_id',
                                    1 => 'base_rate',
                                ),
                                'convertToBase' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'best_case',
                                'required' => true,
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'currency_id',
                                    1 => 'base_rate',
                                ),
                                'convertToBase' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'worst_case',
                                'required' => true,
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'currency_id',
                                    1 => 'base_rate',
                                ),
                                'convertToBase' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'sales_stage',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'opportunity_name',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'quote_name',
                                'label' => 'LBL_ASSOCIATED_QUOTE',
                                'related_fields' =>
                                array(
                                    0 => 'quote_id',
                                ),
                                'readonly' => true,
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'assigned_user_name',
                                'enabled' => true,
                                'default' => false,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
