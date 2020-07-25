<?php

$viewdefs['sales_and_services']['base']['view']['financial-point-of-attention-lv'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'estimated_rli_total',
                    'label' => 'LBL_RLI_EXTD_PRICE',
                    'type' => 'currency',
                ),
                array(
                    'name' => 'estimated_rli_cost',
                    'label' => 'LBL_EXTD_COST',
                    'type' => 'currency',
                ),
                array(
                    'name' => 'estimated_rli_list',
                    'label' => 'LBL_EXTD_LIST',
                    'type' => 'currency',
                ),
                array(
                    'name' => 'estimated_rli_profit',
                    'label' => 'LBL_PROFIT',
                    'type' => 'currency',
                ),
                array(
                    'name' => 'estimated_rli_profit_margin',
                    'label' => 'LBL_PROFIT_MARGIN',
                ),
                array(
                    'name' => 'commission',
                    'label' => 'LBL_COMMISSION',
                    'type' => 'currency',
                ),
            )
        ),
    ),
);
