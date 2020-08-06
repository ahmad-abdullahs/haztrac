<?php

// created: 2020-08-04 05:07:46
$viewdefs['competitor_cost']['base']['view']['subpanel-for-revenuelineitems-competitor_cost_revenuelineitems'] = array(
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
                    'label' => 'LBL_NAME',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'name',
                    'link' => true,
                ),
                1 =>
                array(
                    'name' => 'accounts_competitor_cost_1_name',
                    'label' => 'LBL_ACCOUNTS_COMPETITOR_COST_1_FROM_ACCOUNTS_TITLE',
                    'enabled' => true,
                    'id' => 'ACCOUNTS_COMPETITOR_COST_1ACCOUNTS_IDA',
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
        ),
    ),
    'orderBy' =>
    array(
        'field' => 'date_modified',
        'direction' => 'desc',
    ),
    'type' => 'subpanel-list',
);
