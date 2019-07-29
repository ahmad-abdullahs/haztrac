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
$dictionary['HintNotificationTarget'] = [
    'table' => 'hint_notification_targets',
    'audited' => false,
    'activity_enabled' => false,
    'duplicate_merge' => false,
    'fields' => [
        'type' => [
            'name' => 'type',
            'vname' => 'LBL_HINT_NOTIFICATION_TARGET_TYPE',
            'type' => 'varchar',
            'len' => '32',
            'required' => true,
        ],
        'credentials' => [
            'name' => 'credentials',
            'vname' => 'LBL_HINT_NOTIFICATION_TARGET_CREDENTIALS',
            'type' => 'longtext',
            'required' => true,
        ],
        'accountsets' => [
            'name' => 'accountsets',
            'type' => 'link',
            'relationship' => 'hint_accountsets_targets',
            'module' => 'HintAccountsets',
            'bean_name' => 'HintAccountset',
            'source' => 'non-db',
            'vname' => 'LBL_HINT_NOTIFICATION_TARGET_ACCOUNTSETS',
        ],
    ],
    'indices' => [],
    'relationships' => [],
    'optimistic_locking' => false,
    'unified_search' => false,
    'full_text_search' => false,
];

\VardefManager::createVardef('HintNotificationTargets', 'HintNotificationTarget', ['basic', 'assignable']);

$dictionary['HintNotificationTarget']['indices']['assigned_user_id_and_type'] = [
    'name' => 'idx_hint_notification_targets_assigned_type_del',
    'type' => 'index',
    'fields' => ['assigned_user_id', 'type', 'deleted'],
];

$dictionary['HintNotificationTarget']['fields']['id']['vname'] = 'LBL_HINT_NOTIFICATION_TARGET_ID';

$dictionary['HintNotificationTarget']['fields']['assigned_user_id']['required'] = true;
$dictionary['HintNotificationTarget']['fields']['assigned_user_id']['vname'] = 'LBL_HINT_NOTIFICATION_TARGET_USER_ID';
$dictionary['HintNotificationTarget']['fields']['assigned_user_name']['vname'] = 'LBL_HINT_NOTIFICATION_TARGET_USER_NAME';
