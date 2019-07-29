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
$viewdefs['Quotes']['mobile']['view']['edit'] = array(
    'templateMeta' => array(
        'maxColumns' => '1',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30')
        ),
    ),
    'panels' => array (
        array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                'quote_num',
                array(
                    'name' => 'name',
                    'events' => array(
                        'keyup' => 'update:quote',
                    ),
                    'related_fields' => array(
                        array(
                            'name' => 'bundles',
                            //Probably don't need ALL these...
                            //Copypasted from clients/base/view/record
                            'fields' => array(
                                'id',
                                'bundle_stage',
                                'currency_id',
                                'base_rate',
                                'currencies',
                                'name',
                                'deal_tot',
                                'deal_tot_usdollar',
                                'deal_tot_discount_percentage',
                                'new_sub',
                                'new_sub_usdollar',
                                'position',
                                'related_records',
                                'shipping',
                                'shipping_usdollar',
                                'subtotal',
                                'subtotal_usdollar',
                                'tax',
                                'tax_usdollar',
                                'taxrate_id',
                                'team_count',
                                'team_count_link',
                                'team_name',
                                'taxable_subtotal',
                                'total',
                                'total_usdollar',
                                'default_group',
                                array(
                                    'name' => 'product_bundle_items',
                                    'fields' => array(
                                        'name',
                                        'quote_id',
                                        'description',
                                        'quantity',
                                        'product_template_name',
                                        'product_template_id',
                                        'deal_calc',
                                        'mft_part_num',
                                        'discount_price',
                                        'discount_amount',
                                        'tax',
                                        'tax_class',
                                        'subtotal',
                                        'position',
                                        'currency_id',
                                        'base_rate',
                                        'discount_select',
                                        'total_amount',
                                    ),
                                    'max_num' => -1,
                                ),
                            ),
                            'max_num' => -1,
                            'order_by' => 'position:asc',
                        ),
                    ),
                ),
                'billing_account_name',
                'shipping_account_name',
                'quote_stage',
                'total',
                'date_quote_expected_closed',
                'quote_type',
                'description',
                'assigned_user_name',
                'team_name',
            ),
        ),
    ),
);