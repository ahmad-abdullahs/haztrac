<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$viewdefs['sales_and_services']['base']['view']['subpanel-list'] = array(
    'template' => 'flex-list',
    'favorite' => true,
    'rowactions' => array(
        'actions' => array(
            array(
                'type' => 'rowaction',
                'css_class' => 'btn',
                'tooltip' => 'LBL_PREVIEW',
                'event' => 'list:preview:fire',
                'icon' => 'fa-eye',
                'acl_action' => 'view',
            ),
            array(
                'type' => 'rowaction',
                'name' => 'edit_button',
                'icon' => 'fa-pencil',
                'label' => 'LBL_EDIT_BUTTON',
                'event' => 'list:editrow:fire',
                'acl_action' => 'edit',
            ),
            array(
                'type' => 'unlink-action',
                'name' => 'unlink_button',
                'icon' => 'fa-chain-broken',
                'label' => 'LBL_UNLINK_BUTTON',
            ),
            array(
                'type' => 'rowaction',
                'name' => 'duplicate_button',
                'event' => 'list:duplicate_button:fire',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_action' => 'create',
            ),
//            array(
//                'type' => 'convertbutton',
//                'icon' => 'fa-exchange',
//                'name' => 'record_convert',
//                'label' => 'LBL_CONVERT_BUTTON_TITLE',
//                'acl_action' => 'edit',
//            ),
            array(
                'type' => 'complete-sale-rowaction',
                'name' => 'complete_sale_button',
                'label' => 'LBL_COMPLETE_SALE',
                'acl_action' => 'edit',
            ),
            array(
                'type' => 'print-paperwork-rowaction',
                'name' => 'print_paperwork_button',
                'label' => 'LBL_PRINT_PAPERWORK',
                'acl_action' => 'edit',
            ),
        ),
    ),
    'last_state' => array(
        'id' => 'subpanel-list',
    ),
);
