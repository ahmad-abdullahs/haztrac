<?php

$module_name = 'HT_Manifest';
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
                                'name' => 'manifest_no_actual_c',
                                'type' => 'manifest-no',
                                'label' => 'LBL_MANIFEST_NO_ACTUAL',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'small',
                                'related_fields' => array(
                                    0 => 'rli_galon_total',
                                ),
                            ),
                            1 =>
                            array(
                                'name' => 'manifest_number',
                                'label' => 'LBL_MANIFEST_NUMBER',
                                'enabled' => true,
                                'readonly' => true,
                                'default' => true,
                                'width' => 'small',
                            ),
                            2 =>
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                                'width' => 'large',
                            ),
                            3 =>
                            array(
                                'name' => 'accounts_ht_manifest_1_name',
                                'label' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_ACCOUNTS_TITLE',
                                'enabled' => true,
                                'id' => 'ACCOUNTS_HT_MANIFEST_1ACCOUNTS_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                                'width' => 'large',
                            ),
                            4 =>
                            array(
                                'name' => 'consolidate_c',
                                'label' => 'LBL_CONSOLIDATE',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'small',
                            ),
                            5 =>
                            array(
                                'name' => 'status_c',
                                'label' => 'LBL_STATUS',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'small',
                            ),
                            6 =>
                            array(
                                'name' => 'start_date_c',
                                'label' => 'LBL_START_DATE',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'small',
                            ),
                            7 =>
                            array(
                                'name' => 'manifest_days',
                                'label' => 'LBL_MANIFEST_DAYS',
                                'type' => 'base-colorcoded',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xsmall',
                            ),
                            8 =>
                            array(
                                'name' => 'designated_facility_c',
                                'label' => 'LBL_DESIGNATED_FACILITY',
                                'enabled' => true,
                                'id' => 'ACCOUNT_ID_C',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                                'width' => 'medium',
                            ),
                            9 =>
                            array(
                                'name' => 'manifest_tenth_day_date',
                                'label' => 'LBL_MANIFEST_TENTH_DAY_DATE',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'small',
                            ),
                            10 =>
                            array(
                                'name' => 'complete_date_c',
                                'label' => 'LBL_COMPLETE_DATE',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'small',
                            ),
                            11 =>
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_TEAM',
                                'default' => false,
                                'enabled' => true,
                            ),
                            12 =>
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_ASSIGNED_TO_NAME',
                                'default' => false,
                                'enabled' => true,
                                'link' => true,
                            ),
                            13 =>
                            array(
                                'name' => 'date_entered',
                                'enabled' => true,
                                'default' => false,
                            ),
                            14 =>
                            array(
                                'name' => 'date_modified',
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
