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

$viewdefs['HT_Manifest']['base']['view']['list-headerpane'] = array(
    'fields' => array(
        array(
            'name' => 'title',
            'type' => 'label',
            'default_value' => 'LBL_MODULE_NAME',
        ),
        array(
            'name' => 'collection-count',
            'type' => 'collection-count',
        ),
        array(
            'name' => 'rli_galon_total_title',
            'type' => 'label',
            'default_value' => '',
        ),
    ),
    'buttons' => array(
        array(
            'name' => 'email_manifest_button',
            'events' => array(
                'click' => 'button:email_manifest_button:click',
            ),
            'type' => 'button',
            'label' => 'LBL_EMAIL_MANIFEST',
            'css_class' => 'btn-group email-manifest-button',
            'acl_action' => 'current_user',
        ),
        array(
            'name'    => 'create_button',
            'type'    => 'button',
            'label'   => 'LBL_CREATE_BUTTON_LABEL',
            'css_class' => 'btn-primary',
            'acl_action' => 'create',
            'route' => array(
                'action'=>'create'
            )
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
);
