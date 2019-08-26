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
$viewdefs['sales_and_services']['base']['layout']['subpanel-create'] = array(
    'type' => 'subpanel',
    'template' => 'panel',
    'components' => array(
        array(
            'view' => 'panel-top-create',
        ),
        array(
            'view' => 'subpanel-list-create-for-sas',
        )
    ),
    'last_state' => array(
        'id' => 'subpanel-create'
    ),
);
