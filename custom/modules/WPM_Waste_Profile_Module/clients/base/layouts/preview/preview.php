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

$viewdefs['WPM_Waste_Profile_Module']['base']['layout']['preview'] = array(
    'lazy_loaded' => 'true',
    'components' => array(
        array(
            'view' => 'preview-header',
        ),
        array(
            'view' => 'preview',
        ),
        array(
            'view' => 'comment-log-preview',
        ),
        array(
            'layout' => 'preview-activitystream',
            'context' => array(
                'module' => 'Activities',
                'forceNew' => true,
            ),
        ),
    ),
);

