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
$viewdefs['Products']['mobile']['view']['quote-data-group-list'] = array(
    'panels' => array(
        array(
            'name' => 'products_quote_data_group_list',
            'fields' => array(
                array(
                    'name' => 'line_num',
                    'label' => null,
                    'type' => 'int',
                    'readonly' => true,
                ),
                array(
                    'name' => 'quantity',
                    'label' => 'LBL_QUANTITY',
                    'type' => 'float',
                ),
                array(
                    'name' => 'product_template_name',
                    'rname' => 'name',
                    'id_name' => 'product_template_id',
                    'vname' => 'LBL_PRODUCT_TEMPLATE',
                    'label' => 'LBL_ITEM_NAME',
                    'type' => 'relate',
                    'module' => 'ProductTemplates',
                    'auto_populate' => true,
                    'label' => 'LBL_ITEM_NAME',
                    'required' => true,
                    'populate_list' => array(
                        'name' => 'name',
                        'category_id' => 'category_id',
                        'category_name' => 'category_name',
                        'mft_part_num' => 'mft_part_num',
                        'list_price' => 'list_price',
                        'cost_price' => 'cost_price',
                        'discount_price' => 'discount_price',
                        'list_usdollar' => 'list_usdollar',
                        'cost_usdollar' => 'cost_usdollar',
                        'discount_usdollar' => 'discount_usdollar',
                        'tax_class' => 'tax_class',
                        'weight' => 'weight',
                        'type_id' => 'type_id',
                        'type_name' => 'type_name',
                        'manufacturer_id' => 'manufacturer_id',
                        'manufacturer_name' => 'manufacturer_name',
                        'currency_id' => 'currency_id',
                        'base_rate' => 'base_rate',
                    ),
                ),
                array(
                    'name' => 'mft_part_num',
                    'label' => 'LBL_MFT_PART_NUM',
                    'type' => 'base',
                ),
                array(
                    'name' => 'discount_price',
                    'label' => 'LBL_DISCOUNT_PRICE',
                    'type' => 'currency',
                    'convertToBase' => true,
                    'showTransactionalAmount' => true,
                    'related_fields' => array(
                        'discount_price',
                        'currency_id',
                        'base_rate',
                    ),
                ),
                array(
                    'name' => 'discount',
                    'type' => 'fieldset',
                    'label' => 'LBL_DISCOUNT_AMOUNT',
                    'orientation' => 'horizontal',
                    'fields' => array(
                        array(
                            'type' => 'discount-select',
                            'name' => 'discount_select',
                            'no_default_action' => true,
                        ),
                        array(
                            'name' => 'discount_amount',
                            'label' => 'LBL_DISCOUNT_AMOUNT',
                            'type' => 'discount',
                            'convertToBase' => true,
                            'showTransactionalAmount' => true,
                        ),
                    ),
                ),
                array(
                    'name' => 'total_amount',
                    'label' => 'LBL_LINE_ITEM_TOTAL',
                    'type' => 'currency',
                    'showTransactionalAmount' => true,
                    'related_fields' => array(
                        'total_amount',
                        'currency_id',
                        'base_rate',
                    ),
                ),
            ),
        ),
    ),
);
