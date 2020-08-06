<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$module_name = 'competitor_cost';
$viewdefs[$module_name]['base']['view']['subpanel-create'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    array(
                        'name' => 'accounts_competitor_cost_1_name',
                        'label' => 'LBL_ACCOUNTS_COMPETITOR_COST_1_FROM_ACCOUNTS_TITLE',
                        'type' => 'filtered-relate',
                        'required' => true,
                        'span' => 6,
                    ),
                    array(
                        'name' => 'product_uom_competitor',
                        'label' => 'LBL_PRODUCT_UOM',
                        'type' => 'enum',
                        'span' => 6,
                    ),
                ),
                array(
                    array(
                        'name' => 'cost_price_competitor',
                        'label' => 'LBL_COST_PRICE',
                        'type' => 'currency',
                        'required' => true,
                        'span' => 6,
                    ),
                    array(
                        'name' => 'description_competitor',
                        'label' => 'LBL_DESCRIPTION',
                        'span' => 6,
                    ),
                ),
            ),
            'name_field' => 'name',
        )
    )
);
