<?php

$viewdefs['sales_and_services']['base']['view']['point-of-attention-list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'ac_usepa_id_c',
                    'label' => 'LBL_AC_USEPA_ID_C',
                ),
                array(
                    'name' => 'account_number_c',
                    'label' => 'LBL_ACCOUNT_NUMBER',
                ),
                array(
                    'name' => 'account_status_c',
                    'label' => 'LBL_ACCOUNT_STATUS',
                ),
                array(
                    'name' => 'estimated_rli_total',
                    'label' => 'LBL_RLI_EXTD_PRICE',
                    'type' => 'currency',
                    'width' => 'small',
                ),
                array(
                    'name' => 'estimated_rli_cost',
                    'label' => 'LBL_EXTD_COST',
                    'type' => 'currency',
                    'width' => 'xsmall',
                ),
                array(
                    'name' => 'estimated_rli_list',
                    'label' => 'LBL_EXTD_LIST',
                    'type' => 'currency',
                    'width' => 'xsmall',
                ),
                array(
                    'name' => 'estimated_rli_profit',
                    'label' => 'LBL_PROFIT',
                    'type' => 'currency',
                    'width' => 'xsmall',
                ),
                array(
                    'name' => 'estimated_rli_profit_margin',
                    'label' => 'LBL_PROFIT_MARGIN',
                    'width' => 'xsmall',
                ),
                array(
                    'name' => 'commission',
                    'label' => 'LBL_COMMISSION',
                    'type' => 'currency',
                    'width' => 'xsmall',
                ),
            )
        ),
    ),
);
