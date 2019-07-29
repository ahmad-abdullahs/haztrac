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
$dictionary['HintAccountset'] = [
    'table' => 'hint_accountsets',
    'audited' => false,
    'activity_enabled' => false,
    'duplicate_merge' => false,
    'fields' => [
        'type' => [
            'name' => 'type',
            'vname' => 'LBL_HINT_ACCOUNTSET_TYPE',
            'type' => 'varchar',
            'len' => '20',
            'required' => true,
        ],
        'category' => [
            'name' => 'category',
            'vname' => 'LBL_HINT_ACCOUNTSET_CATEGORY',
            'type' => 'varchar',
            'len' => '128',         // REMIND: may be a little large
            'required' => true,
        ],
        'targets' => [
            'name' => 'targets',
            'vname' => 'LBL_HINT_ACCOUNTSET_TARGETS',
            'type' => 'HintAccountsetTargets',
            'link' => 'notification_targets',
            'source' => 'non-db',
            'massupdate' => false,
            'exportable' => false,
            'sortable' => false,
            'full_text_search' => [
                'enabled' => false,
                'searchable' => false,
            ],
        ],
        'notification_targets' => [
            'name' => 'notification_targets',
            'type' => 'link',
            'relationship' => 'hint_accountsets_targets',
            'module' => 'HintNotificationTargets',
            'bean_name' => 'HintNotificationTarget',
            'source' => 'non-db',
            'vname' => 'LBL_HINT_ACCOUNTSET_NOTIFICATION_TARGETS',
        ],
    ],
    'indices' => [],
    'relationships' => [],
    'optimistic_locking' => false,
    'unified_search' => false,
    'full_text_search' => false,
];

\VardefManager::createVardef('HintAccountsets', 'HintAccountset', ['basic', 'assignable']);

$dictionary['HintAccountset']['fields']['id']['vname'] = 'LBL_HINT_ACCOUNTSET_ID';

$dictionary['HintAccountset']['fields']['assigned_user_id']['required'] = true;
$dictionary['HintAccountset']['fields']['assigned_user_id']['vname'] = 'LBL_HINT_ACCOUNTSET_USER_ID';
$dictionary['HintAccountset']['fields']['assigned_user_name']['vname'] = 'LBL_HINT_ACCOUNTSET_USER_NAME';
