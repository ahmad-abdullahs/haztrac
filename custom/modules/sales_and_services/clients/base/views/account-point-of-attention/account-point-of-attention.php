<?php

$viewdefs['sales_and_services']['base']['view']['account-point-of-attention'] = array(
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
                    'name' => 'ac_usepa_id_c',
                    'label' => 'LBL_AC_USEPA_ID_C',
                    'readonly' => true,
                ),
                array(
                    'name' => 'account_number_c',
                    'label' => 'LBL_ACCOUNT_NUMBER',
                    'readonly' => true,
                ),
                array(
                    'name' => 'account_status_c',
                    'label' => 'LBL_ACCOUNT_STATUS',
                    'readonly' => true,
                ),
            ),
        ),
    ),
    'templateMeta' => array(
        'useTabs' => true,
    )
);
