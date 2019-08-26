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

$viewdefs['RevenueLineItems']['base']['view']['preview'] = array(
    'panels' => array(
        0 =>
        array(
            'name' => 'panel_header',
            'header' => true,
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'picture',
                    'type' => 'avatar',
                    'size' => 'large',
                    'dismiss_label' => true,
                    'readonly' => true,
                ),
                1 =>
                array(
                    'name' => 'name',
                    'label' => 'LBL_MODULE_NAME_SINGULAR',
                ),
                2 =>
                array(
                    'name' => 'favorite',
                    'label' => 'LBL_FAVORITE',
                    'type' => 'favorite',
                    'dismiss_label' => true,
                ),
                3 =>
                array(
                    'name' => 'follow',
                    'label' => 'LBL_FOLLOW',
                    'type' => 'follow',
                    'readonly' => true,
                    'dismiss_label' => true,
                ),
                4 =>
                array(
                    'type' => 'badge',
                    'name' => 'quote_id',
                    'event' => 'button:convert_to_quote:click',
                    'readonly' => true,
                    'tooltip' => 'LBL_CONVERT_RLI_TO_QUOTE',
                    'acl_module' => 'RevenueLineItems',
                ),
            ),
        ),
        1 =>
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labels' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'opportunity_name',
                    'filter_relate' =>
                    array(
                        'account_id' => 'account_id',
                    ),
                ),
                1 =>
                array(
                    'name' => 'account_name',
                    'readonly' => true,
                ),
                2 => 'sales_stage',
                3 => 'probability',
                4 =>
                array(
                    'name' => 'commit_stage',
                    'span' => 6,
                ),
                5 =>
                array(
                    'name' => 'date_closed',
                    'related_fields' =>
                    array(
                        0 => 'date_closed_timestamp',
                        1 => 'revenuelineitems_revenuelineitems_1',
                    ),
                    'span' => 6,
                ),
                6 =>
                array(
                    'name' => 'revenuelineitems_revenuelineitems_1',
                    'type' => 'relate-collection-preview',
                ),
//                6 => 'product_template_name',
//                7 =>
//                array(
//                    'name' => 'category_name',
//                    'type' => 'relate',
//                    'label' => 'LBL_CATEGORY',
//                ),
//                8 => 'quantity',
//                9 =>
//                array(
//                    'name' => 'discount_price',
//                    'type' => 'currency',
//                    'related_fields' =>
//                    array(
//                        0 => 'discount_price',
//                        1 => 'currency_id',
//                        2 => 'base_rate',
//                    ),
//                    'convertToBase' => true,
//                    'showTransactionalAmount' => true,
//                    'currency_field' => 'currency_id',
//                    'base_rate_field' => 'base_rate',
//                ),
//                10 =>
//                array(
//                    'name' => 'discount_amount',
//                    'type' => 'currency',
//                    'related_fields' =>
//                    array(
//                        0 => 'discount_amount',
//                        1 => 'currency_id',
//                        2 => 'base_rate',
//                    ),
//                    'convertToBase' => true,
//                    'showTransactionalAmount' => true,
//                    'currency_field' => 'currency_id',
//                    'base_rate_field' => 'base_rate',
//                ),
//                11 =>
//                array(
//                    'name' => 'total_amount',
//                    'type' => 'currency',
//                    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
//                    'readonly' => true,
//                    'related_fields' =>
//                    array(
//                        0 => 'total_amount',
//                        1 => 'currency_id',
//                        2 => 'base_rate',
//                    ),
//                    'convertToBase' => true,
//                    'showTransactionalAmount' => true,
//                    'currency_field' => 'currency_id',
//                    'base_rate_field' => 'base_rate',
//                ),
//                12 =>
//                array(
//                    'name' => 'likely_case',
//                    'type' => 'currency',
//                    'related_fields' =>
//                    array(
//                        0 => 'likely_case',
//                        1 => 'currency_id',
//                        2 => 'base_rate',
//                    ),
//                    'convertToBase' => true,
//                    'showTransactionalAmount' => true,
//                    'currency_field' => 'currency_id',
//                    'base_rate_field' => 'base_rate',
//                ),
//                13 =>
//                array(
//                    'name' => 'quote_name',
//                    'label' => 'LBL_ASSOCIATED_QUOTE',
//                    'related_fields' =>
//                    array(
//                        0 => 'mft_part_num',
//                    ),
//                    'readonly' => true,
//                ),
//                14 =>
//                array(
//                    'name' => 'tag',
//                    'span' => 6,
//                ),
//                15 =>
//                array(
//                    'name' => 'sales_and_services_revenuelineitems_1_name',
//                    'span' => 6,
//                ),
//                16 =>
//                array(
//                    'name' => 'ht_manifest_revenuelineitems_1_name',
//                ),
//                17 =>
//                array(
//                ),
//                18 =>
//                array(
//                    'name' => 'revenuelineitems_revenuelineitems_1_name',
//                ),
            ),
        ),
        2 =>
        array(
            'name' => 'panel_hidden',
            'label' => 'LBL_RECORD_SHOWMORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'best_case',
                    'type' => 'currency',
                    'related_fields' =>
                    array(
                        0 => 'best_case',
                        1 => 'currency_id',
                        2 => 'base_rate',
                    ),
                    'convertToBase' => true,
                    'showTransactionalAmount' => true,
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
                ),
                1 =>
                array(
                    'name' => 'worst_case',
                    'type' => 'currency',
                    'related_fields' =>
                    array(
                        0 => 'worst_case',
                        1 => 'currency_id',
                        2 => 'base_rate',
                    ),
                    'convertToBase' => true,
                    'showTransactionalAmount' => true,
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
                ),
                2 => 'next_step',
                3 => 'product_type',
                4 => 'lead_source',
                5 => 'campaign_name',
                6 => 'assigned_user_name',
                7 => 'team_name',
                8 =>
                array(
                    'name' => 'description',
                    'span' => 12,
                ),
                9 =>
                array(
                    'name' => 'list_price',
                    'readonly' => true,
                    'type' => 'currency',
                    'related_fields' =>
                    array(
                        0 => 'list_price',
                        1 => 'currency_id',
                        2 => 'base_rate',
                    ),
                    'convertToBase' => true,
                    'showTransactionalAmount' => true,
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
                ),
                10 => 'tax_class',
                11 =>
                array(
                    'name' => 'cost_price',
                    'readonly' => true,
                    'type' => 'currency',
                    'related_fields' =>
                    array(
                        0 => 'cost_price',
                        1 => 'currency_id',
                        2 => 'base_rate',
                    ),
                    'convertToBase' => true,
                    'showTransactionalAmount' => true,
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
                ),
                12 =>
                array(
                    'name' => 'date_entered_by',
                    'readonly' => true,
                    'type' => 'fieldset',
                    'inline' => true,
                    'label' => 'LBL_DATE_ENTERED',
                    'fields' =>
                    array(
                        0 =>
                        array(
                            'name' => 'date_entered',
                        ),
                        1 =>
                        array(
                            'type' => 'label',
                            'default_value' => 'LBL_BY',
                        ),
                        2 =>
                        array(
                            'name' => 'created_by_name',
                        ),
                    ),
                ),
                13 =>
                array(
                    'name' => 'date_modified_by',
                    'readonly' => true,
                    'type' => 'fieldset',
                    'inline' => true,
                    'label' => 'LBL_DATE_MODIFIED',
                    'fields' =>
                    array(
                        0 =>
                        array(
                            'name' => 'date_modified',
                        ),
                        1 =>
                        array(
                            'type' => 'label',
                            'default_value' => 'LBL_BY',
                        ),
                        2 =>
                        array(
                            'name' => 'modified_by_name',
                        ),
                    ),
                ),
                14 =>
                array(
                ),
            ),
        ),
    ),
);
