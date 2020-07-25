<?php

$viewdefs['sales_and_services']['base']['view']['financial-point-of-attention'] = array(
    'panels' =>
    array(
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' =>
            array(
                array(
                    'name' => 'estimated_rli_total',
                    'label' => 'LBL_RLI_EXTD_PRICE',
                    'type' => 'currency',
                    'readonly' => true,
                ),
                array(
                    'name' => 'estimated_rli_cost',
                    'label' => 'LBL_EXTD_COST',
                    'type' => 'currency',
                    'readonly' => true,
                ),
                array(
                    'name' => 'estimated_rli_list',
                    'label' => 'LBL_EXTD_LIST',
                    'type' => 'currency',
                    'readonly' => true,
                ),
                array(
                    'name' => 'estimated_rli_profit',
                    'label' => 'LBL_PROFIT',
                    'type' => 'currency',
                    'readonly' => true,
                ),
                array(
                    'name' => 'estimated_rli_profit_margin',
                    'label' => 'LBL_PROFIT_MARGIN',
                    'readonly' => true,
                ),
                array(
                    'name' => 'commission',
                    'label' => 'LBL_COMMISSION',
                    'type' => 'currency',
                    'readonly' => true,
                ),
            ),
        ),
    ),
    'templateMeta' => array(
        'useTabs' => true,
    )
);
