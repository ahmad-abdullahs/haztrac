<?php

// created: 2019-06-17 16:45:52
$viewdefs['sales_and_services']['base']['view']['subpanel-for-accounts'] = array(
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
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_PROFILE_NO',
                    'enabled' => true,
                    'name' => 'profile_no_c',
                ),
                2 =>
                array(
                    'type' => 'date',
                    'default' => true,
                    'label' => 'LBL_ON_DATE',
                    'enabled' => true,
                    'name' => 'on_date_c',
                ),
                3 =>
                array(
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_ON_TIME',
                    'enabled' => true,
                    'name' => 'on_time_c',
                ),
                4 =>
                array(
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_SVC_DAYS',
                    'enabled' => true,
                    'name' => 'svc_days_c',
                ),
                5 =>
                array(
                    'type' => 'enum',
                    'default' => true,
                    'label' => 'LBL_STATUS',
                    'enabled' => true,
                    'name' => 'status_c',
                ),
                6 =>
                array(
                    'name' => 'team_name',
                    'label' => 'LBL_TEAM',
                    'default' => false,
                    'enabled' => false,
                    'width' => '9',
                ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
