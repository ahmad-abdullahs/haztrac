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
$viewdefs['ReportSchedules']['base']['view']['list'] = array(
    // TODO add more metadata
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'enabled' => true,
                    'default' => true,
                    'link' => true,
                ),
                array(
                    'name' => 'report_name',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'time_interval',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'active',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'date_start',
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'date_modified',
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'modified_by_name',
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'date_entered',
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'created_by_name',
                    'enabled' => true,
                    'default' => false,
                ),
            ),
        ),
    ),
);
