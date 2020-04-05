<?php

$viewdefs['Contracts_Template'] = array(
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
                        'name' => 'panel_header',
                        'label' => 'LBL_PANEL_1',
                        'fields' =>
                        array(
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'link' => true,
                                'default' => true,
                                'enabled' => true,
                            ),
                            array(
                                'name' => 'contract_type_c',
                                'label' => 'LBL_CONTRACT_TYPE',
                                'default' => true,
                                'enabled' => true,
                            ),
                            array(
                                'name' => 'date_entered',
                                'label' => 'LBL_DATE_ENTERED',
                                'enabled' => true,
                                'readonly' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_ASSIGNED_TO',
                                'default' => true,
                                'enabled' => true,
                            ),
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_LIST_TEAM',
                                'default' => false,
                                'enabled' => true,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
