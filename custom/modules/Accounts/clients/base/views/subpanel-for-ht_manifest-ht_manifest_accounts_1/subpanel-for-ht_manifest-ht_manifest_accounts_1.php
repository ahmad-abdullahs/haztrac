<?php

// created: 2019-10-26 01:22:00
$viewdefs['Accounts']['base']['view']['subpanel-for-ht_manifest-ht_manifest_accounts_1'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'default' => true,
                    'label' => 'LBL_LIST_ACCOUNT_NAME',
                    'enabled' => true,
                    'name' => 'name',
                    'link' => true,
                    'related_fields' => array(
                        0 => 'transfer_date',
                    ),
                ),
                array(
                    'name' => 'transfer_date',
                    'label' => 'LBL_LIST_TRANSFER_DATE',
                    'enabled' => true,
                    'default' => true,
                    'type' => 'date',
                    'link' => false,
                ),
                array(
                    'name' => 'tag',
                    'label' => 'LBL_TAGS',
                    'enabled' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
