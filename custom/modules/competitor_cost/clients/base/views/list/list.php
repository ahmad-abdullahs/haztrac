<?php

$module_name = 'competitor_cost';
$viewdefs[$module_name] = array(
    'base' =>
    array(
        'view' =>
        array(
            'list' =>
            array(
                'panels' =>
                array(
                    0 =>
                    array(
                        'label' => 'LBL_PANEL_1',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'default' => true,
                                'enabled' => true,
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
                                'name' => 'competitor_cost_revenuelineitems_name',
                                'label' => 'LBL_COMPETITOR_COST_REVENUELINEITEMS_FROM_REVENUELINEITEMS_TITLE',
                                'enabled' => true,
                                'id' => 'COMPETITOR_COST_REVENUELINEITEMSREVENUELINEITEMS_IDA',
                                'link' => true,
                                'sortable' => false,
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
                                'name' => 'cost_price_competitor',
                                'label' => 'LBL_COST_PRICE',
                                'enabled' => true,
                                'currency_format' => true,
                                'default' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_ASSIGNED_TO_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'date_modified',
                                'enabled' => true,
                                'default' => true,
                            ),
                            7 =>
                            array(
                                'name' => 'date_entered',
                                'enabled' => true,
                                'default' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_TEAM',
                                'default' => false,
                                'enabled' => true,
                            ),
                        ),
                    ),
                ),
                'orderBy' =>
                array(
                    'field' => 'date_modified',
                    'direction' => 'desc',
                ),
            ),
        ),
    ),
);
