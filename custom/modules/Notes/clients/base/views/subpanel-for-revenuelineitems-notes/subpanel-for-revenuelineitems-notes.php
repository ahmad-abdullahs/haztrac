<?php

// created: 2020-10-03 02:27:41
$viewdefs['Notes']['base']['view']['subpanel-for-revenuelineitems-notes'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'label' => 'LBL_LIST_SUBJECT',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'name',
                    'link' => true,
                    'related_fields' =>
                    array(
                        'file_mime_type',
                        'file_ext',
                    ),
                ),
                array(
                    'name' => 'description',
                    'label' => 'LBL_DESCRIPTION',
                    'enabled' => true,
                    'sortable' => false,
                    'default' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'target_record_key' => 'assigned_user_id',
                    'target_module' => 'Employees',
                    'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'label' => 'LBL_LIST_DATE_MODIFIED',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'date_modified',
                ),
                array(
                    'label' => 'LBL_LIST_DATE_ENTERED',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'date_entered',
                ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
