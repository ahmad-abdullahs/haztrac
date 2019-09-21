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
                    'name' => 'charge_c',
                    'label' => 'LBL_CHARGE',
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
                        0 => 'discount_price',
                        1 => 'quantity',
                        2 => 'discount_amount',
                    ),
                    'currency_format' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
);
