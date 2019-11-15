<?php

// created: 2019-08-31 02:15:28
$viewdefs['sales_and_services']['base']['view']['subpanel-for-accounts-accounts_sales_and_services_1'] = array(
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
                    'default' => true,
                    'label' => 'LBL_NAME',
                    'enabled' => true,
                    'name' => 'name',
                    'link' => true,
                    'type' => 'name',
                ),
                1 =>
                array(
                    'name' => 'estimated_rli_total',
                    'label' => 'LBL_ESTIMATED_RLI_TOTAL',
                    'enabled' => true,
                    'default' => true,
                ),
                2 =>
                array(
                    'name' => 'rli_total_c',
                    'label' => 'LBL_RLI_TOTAL',
                    'enabled' => true,
                    'default' => true,
                ),
                3 =>
                array(
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_PROFILE_NO',
                    'enabled' => true,
                    'name' => 'profile_no_c',
                ),
                4 =>
                array(
                    'type' => 'date',
                    'default' => true,
                    'label' => 'LBL_ON_DATE',
                    'enabled' => true,
                    'name' => 'on_date_c',
                ),
                5 =>
                array(
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_ON_TIME',
                    'enabled' => true,
                    'name' => 'on_time_c',
                ),
                6 =>
                array(
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_SVC_DAYS',
                    'enabled' => true,
                    'name' => 'svc_days_c',
                ),
                7 =>
                array(
                    'type' => 'enum',
                    'default' => true,
                    'label' => 'LBL_STATUS',
                    'enabled' => true,
                    'name' => 'status_c',
                ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
