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

$viewdefs['Doc_Manager']['base']['view']['list-headerpane'] = array(
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
    ),
    'buttons' => array(
        array(
            'name' => 'import_document_button',
            'events' => array(
                'click' => 'button:import_document_button:click',
            ),
            'type' => 'button',
            'label' => 'LBL_UPLOAD_ONLYOFFICE_FILE_TITLE',
            'css_class' => 'btn-group import-document-button',
            'acl_action' => 'current_user',
        ),
        array(
            'name' => 'create_button',
            'type' => 'button',
            'label' => 'LBL_CREATE_BUTTON_LABEL',
            'css_class' => 'btn-primary',
            'acl_action' => 'create',
            'route' => array(
                'action' => 'create'
            )
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
);
