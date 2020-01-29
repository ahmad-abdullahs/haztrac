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
$viewdefs['ProductTemplates']['base']['view']['subpanel-for-product_templates_accounts'] = array(
    'type' => 'subpanel-list',
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'enabled' => true,
                    'default' => true,
                    'link' => true,
                    'related_fields' =>
                    array(
                        0 => 'vendor_part_num',
                    ),
                ),
                array(
                    'name' => 'cost_price',
                    'type' => 'currency',
                    'related_fields' =>
                    array(
                        0 => 'cost_usdollar',
                        1 => 'currency_id',
                        2 => 'base_rate',
                    ),
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
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
                array(
                    'name' => 'list_price',
                    'type' => 'currency',
                    'related_fields' =>
                    array(
                        0 => 'list_usdollar',
                        1 => 'currency_id',
                        2 => 'base_rate',
                    ),
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
                    'enabled' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
);
