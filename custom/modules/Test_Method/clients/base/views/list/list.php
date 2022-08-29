<?php

$module_name = 'Test_Method';
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
                                'name' => 'method',
                                'label' => 'LBL_METHOD',
                                'enabled' => true,
                                'default' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'status',
                                'label' => 'LBL_STATUS',
                                'enabled' => true,
                                'default' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'uom',
                                'label' => 'LBL_UOM',
                                'enabled' => true,
                                'default' => true,
                            ),
                            4 =>
                            array(
                                'name' => 'test_name',
                                'label' => 'LBL_TEST_NAME',
                                'enabled' => true,
                                'default' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'alternate_name',
                                'label' => 'LBL_ALTERNATE_NAME',
                                'enabled' => true,
                                'default' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_ASSIGNED_TO_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                            ),
                            7 =>
                            array(
                                'name' => 'date_modified',
                                'enabled' => true,
                                'default' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'date_entered',
                                'enabled' => true,
                                'default' => true,
                            ),
                            9 =>
                            array(
                                'name' => 'method_description',
                                'label' => 'LBL_METHOD_DESCRIPTION',
                                'enabled' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            10 =>
                            array(
                                'name' => 'brief_popup_explanation_test',
                                'label' => 'LBL_BRIEF_POPUP_EXPLANATION_TEST',
                                'enabled' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            11 =>
                            array(
                                'name' => 'printable_certification',
                                'label' => 'LBL_PRINTABLE_CERTIFICATION',
                                'enabled' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            12 =>
                            array(
                                'name' => 'description',
                                'label' => 'LBL_DESCRIPTION',
                                'enabled' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            13 =>
                            array(
                                'name' => 'created_by_name',
                                'label' => 'LBL_CREATED',
                                'enabled' => true,
                                'readonly' => true,
                                'id' => 'CREATED_BY',
                                'link' => true,
                                'default' => false,
                            ),
                            14 =>
                            array(
                                'name' => 'modified_by_name',
                                'label' => 'LBL_MODIFIED',
                                'enabled' => true,
                                'readonly' => true,
                                'id' => 'MODIFIED_USER_ID',
                                'link' => true,
                                'default' => false,
                            ),
                            15 =>
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_TEAM',
                                'default' => false,
                                'enabled' => true,
                            ),
                            16 =>
                            array(
                                'name' => 'tag',
                                'label' => 'LBL_TAGS',
                                'enabled' => true,
                                'default' => false,
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
