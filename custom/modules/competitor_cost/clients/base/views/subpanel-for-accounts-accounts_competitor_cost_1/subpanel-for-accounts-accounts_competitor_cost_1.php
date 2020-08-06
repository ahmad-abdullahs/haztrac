<?php

// created: 2020-08-04 05:15:11
$viewdefs['competitor_cost']['base']['view']['subpanel-for-accounts-accounts_competitor_cost_1'] = array(
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
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'enabled' => true,
                    'link' => true,
                    'default' => true,
                ),
                1 =>
                array(
                    'name' => 'competitor_cost_revenuelineitems_name',
                    'label' => 'LBL_COMPETITOR_COST_REVENUELINEITEMS_FROM_REVENUELINEITEMS_TITLE',
                    'enabled' => true,
                    'id' => 'COMPETITOR_COST_REVENUELINEITEMSREVENUELINEITEMS_IDA',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                2 =>
                array(
                    'name' => 'cost_price_competitor',
                    'label' => 'LBL_COST_PRICE',
                    'enabled' => true,
                    'currency_format' => true,
                    'default' => true,
                ),
                3 =>
                array(
                    'name' => 'product_uom_competitor',
                    'label' => 'LBL_PRODUCT_UOM',
                    'enabled' => true,
                    'default' => true,
                ),
                4 =>
                array(
                    'name' => 'description_competitor',
                    'label' => 'LBL_DESCRIPTION',
                    'enabled' => true,
                    'sortable' => false,
                    'default' => true,
                ),
            ),
            'name_field' => 'name',
        ),
    ),
    'type' => 'subpanel-list',
);
