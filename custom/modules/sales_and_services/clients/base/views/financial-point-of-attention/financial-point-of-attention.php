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
                    'name' => 'rli_extd_price',
                    'label' => 'LBL_RLI_EXTD_PRICE',
                    'readonly' => true,
                ),
                array(
                    'name' => 'extd_cost',
                    'label' => 'LBL_EXTD_COST',
                    'readonly' => true,
                ),
                array(
                    'name' => 'extd_list',
                    'label' => 'LBL_EXTD_LIST',
                    'readonly' => true,
                ),
                array(
                    'name' => 'profit',
                    'label' => 'LBL_PROFIT',
                    'readonly' => true,
                ),
                array(
                    'name' => 'profit_margin',
                    'label' => 'LBL_PROFIT_MARGIN',
                    'readonly' => true,
                ),
                array(
                    'name' => 'commission',
                    'label' => 'LBL_COMMISSION',
                    'readonly' => true,
                ),
            ),
        ),
    ),
    'templateMeta' => array(
        'useTabs' => true,
    )
);
