<?php

$viewdefs['HT_Assets_and_Objects'] = array(
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
                                'type' => 'name',
                                'label' => 'LBL_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                                'width' => 'large',
                            ),
                            1 =>
                            array(
                                'name' => 'asset_type_c',
                                'label' => 'LBL_ASSET_TYPE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'asset_object_marking_no_c',
                                'label' => 'LBL_ASSET_OBJECT_MARKING_NO',
                                'enabled' => true,
                                'default' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'model_year_c',
                                'label' => 'LBL_MODEL_YEAR',
                                'enabled' => true,
                                'default' => true,
                            ),
                            4 =>
                            array(
                                'name' => 'make_c',
                                'label' => 'LBL_MAKE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'model_c',
                                'label' => 'LBL_MODEL',
                                'enabled' => true,
                                'default' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'object_no_c',
                                'label' => 'LBL_OBJECT_NO',
                                'enabled' => true,
                                'default' => true,
                            ),
                            7 =>
                            array(
                                'name' => 'asset_location_c',
                                'label' => 'LBL_ASSET_LOCATION',
                                'enabled' => true,
                                'id' => 'ACCOUNT_ID_C',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_TEAM',
                                'default' => false,
                                'enabled' => true,
                                'width' => 'medium',
                            ),
                            9 =>
                            array(
                                'name' => 'date_modified',
                                'enabled' => true,
                                'default' => false,
                            ),
                            10 =>
                            array(
                                'name' => 'date_entered',
                                'enabled' => true,
                                'default' => false,
                            ),
                            11 =>
                            array(
                                'name' => 'asset_number',
                                'label' => 'LBL_ASSET_NUMBER',
                                'enabled' => true,
                                'readonly' => true,
                                'default' => false,
                            ),
                            12 =>
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_ASSIGNED_TO_NAME',
                                'default' => false,
                                'enabled' => true,
                                'link' => true,
                                'width' => 'medium',
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
