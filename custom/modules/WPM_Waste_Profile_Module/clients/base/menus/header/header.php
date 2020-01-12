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

$moduleName = 'WPM_Waste_Profile_Module';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'route' => "#$moduleName/create",
        'label' => 'LNK_NEW_RECORD',
        'acl_action' => 'create',
        'acl_module' => $moduleName,
        'icon' => 'fa-plus',
    ),
    array(
        'route' => "#WPM_Waste_Profile_Template/create",
        'label' => 'LNK_NEW_RECORD_WPM_WASTE_PROFILE_TEMPLATE',
        'acl_action' => 'create',
        'acl_module' => 'WPM_Waste_Profile_Template',
        'icon' => 'fa-plus',
    ),
    array(
        'route' => "#wp_terms_and_conditions/create",
        'label' => 'LNK_NEW_RECORD_WPM_WASTE_PROFILE_TERMS_AND_CONDITIONS',
        'acl_action' => 'create',
        'acl_module' => 'wp_terms_and_conditions',
        'icon' => 'fa-plus',
    ),
    array(
        'route' => "#$moduleName",
        'label' => 'LNK_LIST',
        'acl_action' => 'list',
        'acl_module' => $moduleName,
        'icon' => 'fa-bars',
    ),
    array(
        'route' => "#WPM_Waste_Profile_Template",
        'label' => 'LNK_LIST_WPM_WASTE_PROFILE_TEMPLATE',
        'acl_action' => 'list',
        'acl_module' => 'WPM_Waste_Profile_Template',
        'icon' => 'fa-bars',
    ),
    array(
        'route' => "#wp_terms_and_conditions",
        'label' => 'LNK_LIST_WPM_WASTE_PROFILE_TERMS_AND_CONDITIONS',
        'acl_action' => 'list',
        'acl_module' => 'wp_terms_and_conditions',
        'icon' => 'fa-bars',
    ),
);
