<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$viewdefs['sales_and_services']['base']['view']['print-paperwork'] = array(
    'template' => 'record',
    'buttons' => array(
        array(
            'name' => 'close_button',
            'type' => 'button',
            'label' => 'LBL_CLOSE_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'events' => array(
                'click' => 'button:close_button:click',
            ),
        ),
        array(
            'name' => 'print_button',
            'type' => 'button',
            'label' => 'LBL_PRINT_BUTTON_LABEL',
            'primary' => true,
            'showOn' => 'create',
            'events' => array(
                'click' => 'button:print_button:click',
            ),
        ),
        array(
            'name' => 'print_queue_button',
            'type' => 'button',
            'label' => 'LBL_PRINT_QUEUE_BUTTON_LABEL',
            'primary' => true,
            'showOn' => 'create',
            'events' => array(
                'click' => 'button:print_queue_button:click',
            ),
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels' =>
    array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PRINT_PAPERWORK',
            'header' => true,
            'default_value' => 'LBL_PRINT_PAPERWORK',
            'dismiss_label' => true,
            'type' => 'title',
            'readonly' => true,
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'task_follow_label',
                    'label' => '',
                    'default_value' => 'LBL_PRINT_PAPERWORK',
                    'type' => 'label',
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'label' => true,
            'title' => '',
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => array(
                array(
                ),
            ),
        ),
    ),
    'templateMeta' =>
    array(
        'useTabs' => true,
        'maxColumns' => '2',
    ),
);
