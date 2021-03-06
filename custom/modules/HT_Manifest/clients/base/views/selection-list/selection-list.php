<?php

$module_name = 'HT_Manifest';
$viewdefs[$module_name] = array(
    'base' =>
    array(
        'view' =>
        array(
            'selection-list' =>
            array(
                'panels' =>
                array(
                    0 =>
                    array(
                        'label' => 'LBL_PANEL_1',
                        'fields' =>
                        array(
                            array(
                                'name' => 'start_date_c',
                                'label' => 'LBL_START_DATE',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'small',
                            ),
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                                'width' => 'small',
                                'related_fields' =>
                                array(
                                    0 => 'transporter',
                                ),
                            ),
                            array(
                                'name' => 'consolidate_c',
                                'label' => 'LBL_CONSOLIDATE',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xxsmall',
                            ),
                            array(
                                'name' => 'accounts_ht_manifest_1_name',
                                'label' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_ACCOUNTS_TITLE',
                                'enabled' => true,
                                'id' => 'ACCOUNTS_HT_MANIFEST_1ACCOUNTS_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                            ),
                            array(
                                'name' => 'ht_manifest_v_vendors_name',
                                'label' => 'LBL_HT_MANIFEST_V_VENDORS_FROM_V_VENDORS_TITLE',
                                'enabled' => true,
                                'id' => 'HT_MANIFEST_V_VENDORSHT_MANIFEST_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                                'width' => 'small',
                            ),
                            array(
                                'name' => 'status_c',
                                'label' => 'LBL_STATUS',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'small',
                            ),
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_TEAM',
                                'default' => true,
                                'enabled' => true,
                                'width' => 'small',
                            ),
                            array(
                                'name' => 'manifest_number',
                                'label' => 'LBL_MANIFEST_NUMBER',
                                'enabled' => true,
                                'readonly' => true,
                                'default' => true,
                            ),
                            array(
                                'label' => 'LBL_DATE_MODIFIED',
                                'enabled' => true,
                                'default' => false,
                                'name' => 'date_modified',
                                'readonly' => true,
                            ),
                            array(
                                'name' => 'complete_date_c',
                                'label' => 'LBL_COMPLETE_DATE',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_ASSIGNED_TO_NAME',
                                'default' => false,
                                'enabled' => true,
                                'link' => true,
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
