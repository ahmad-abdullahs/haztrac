<?php

$viewdefs['base']['view']['active-manifest'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_ACTIVE_MANIFEST_DASHLET',
            'description' => 'LBL_ACTIVE_MANIFEST_DASHLET_DESCRIPTION',
            'config' => array(
                'limit' => 10,
                'visibility' => 'user'
            ),
            'preview' => array(
                'limit' => 10,
                'visibility' => 'user'
            ),
            'filter' => array(
                'module' => array(
                    'Home',
                ),
            ),
        ),
    ),
    'custom_toolbar' => array(
        'buttons' => array(
            array(
                'type' => 'actiondropdown',
                'no_default_action' => true,
                'icon' => 'fa-plus',
                'buttons' => array(
                    array(
                        'type' => 'dashletaction',
                        'action' => 'createRecord',
                        'params' => array(
                            'module' => 'HT_Manifest',
                        ),
                        'label' => 'LBL_CREATE_Manifest',
                        'acl_action' => 'create',
                        'acl_module' => 'HT_Manifest',
                    ),
                ),
            ),
            array(
                'dropdown_buttons' => array(
                    array(
                        'type' => 'dashletaction',
                        'action' => 'editClicked',
                        'label' => 'LBL_DASHLET_CONFIG_EDIT_LABEL',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'refreshClicked',
                        'label' => 'LBL_DASHLET_REFRESH_LABEL',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'toggleClicked',
                        'label' => 'LBL_DASHLET_MINIMIZE',
                        'event' => 'minimize',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'removeClicked',
                        'label' => 'LBL_DASHLET_REMOVE_LABEL',
                    ),
                ),
            ),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'limit',
                    'label' => 'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS',
                    'type' => 'enum',
                    'options' => 'tasks_limit_options',
                ),
            ),
        ),
    ),
    'tabs' => array(
        array(
            'active' => true,
            'filters' => array(
                'status_c' => array('$equals' => 'Active'),
            ),
            'label' => 'LBL_ACTIVE_MANIFEST_DASHLET_ACTIVE',
            'module' => 'HT_Manifest',
            'order_by' => 'date_modified:desc',
            'record_date' => 'date_modified',
            'row_actions' => array(
            ),
            'fields' => array(
                'name',
                'assigned_user_name',
                'assigned_user_id',
                'date_modified',
            ),
        ),
        array(
            'filters' => array(
                'status_c' => array('$equals' => 'Inactive'),
            ),
            'label' => 'LBL_ACTIVE_MANIFEST_DASHLET_INACTIVE',
            'module' => 'HT_Manifest',
            'order_by' => 'date_modified:desc',
            'record_date' => 'date_modified',
            'row_actions' => array(
            ),
            'fields' => array(
                'name',
                'assigned_user_name',
                'assigned_user_id',
                'date_modified',
            ),
        ),
    ),
);
