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
            'name' => 'cancel_button',
            'type' => 'button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'events' => array(
                'click' => 'button:cancel_button:click',
            ),
        ),
        array(
            'name' => 'save_button',
            'type' => 'button',
//            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'label' => 'LBL_PRINT_BUTTON_LABEL',
            'primary' => true,
            'showOn' => 'create',
            'events' => array(
                'click' => 'button:save_button:click',
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
            'columns' => 1,
            'label' => true,
            'title' => '',
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' =>
            array(
                array(
//                    'name' => 'print_paperword_today',
                    'name' => 'recurring_sale_c',
                    'label' => 'LBL_PRINT_PAPERWORD_TODAY',
                    'type' => 'bool',
                ),
                array(
//                    'name' => 'print_paperword_tomorrow',
                    'name' => 'taxable_c',
                    'type' => 'bool',
                    'label' => 'LBL_PRINT_PAPERWORD_TOMORROW',
                ),
                array(
//                    'name' => 'print_paperword_tomorrow',
                    'name' => 'payment_paid_c',
                    'type' => 'bool',
                    'label' => 'LBL_PRINT_PAPERWORD_AFTER_PAYMENT',
                ),
                array(
                    'name' => 'date_start',
                    'label' => 'LBL_PRINT_PAPERWORD_START_DATE',
                    'type' => 'datetimecombo',
                    'required' => true,
                ),
                array(
                    'name' => 'date_end',
                    'label' => 'LBL_PRINT_PAPERWORD_END_DATE',
                    'type' => 'datetimecombo',
                    'required' => true,
                ),
                array(
                    'name' => 'print_manifest',
                    'label' => 'LBL_PRINT_MANIFEST',
                    'type' => 'button',
                    'primary' => true,
                    'events' => array(
                        'click' => 'button:print_manifest:click',
                    ),
                ),
                array(
                    'name' => 'xaxis',
                    'label' => 'X-Axis',
                    'type' => 'int',
                    'len' => '2',
                    'default' => '50',
                    'span' => 6
                ),
                array(
                    'name' => 'yaxis',
                    'label' => 'Y-Axis',
                    'type' => 'int',
                    'len' => '2',
                    'default' => '19',
                    'span' => 6
                ),
            ),
        ),
    ),
    'templateMeta' =>
    array(
        'useTabs' => false,
        'maxColumns' => '2',
    ),
);
