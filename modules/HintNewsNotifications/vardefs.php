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
$dictionary['HintNewsNotification'] = [
    'table' => 'hint_news_notifications',
    'audited' => false,
    'activity_enabled' => false,
    'duplicate_merge' => false,
    'fields' => [
        'category' => [
            'name' => 'category',
            'vname' => 'LBL_HINT_NEWS_NOTIFICATIONS_CATEGORY',
            'type' => 'varchar',
            'len' => '32',
            'required' => true,
        ],
        'title' => [
            'name' => 'title',
            'vname' => 'LBL_HINT_NEWS_NOTIFICATIONS_TITLE',
            'type' => 'varchar',
            'len' => '256',         // REMIND: long, but needs to support unicode chars
            'required' => true,
        ],
        'article_date' => [
            'name' => 'article_date',
            'vname' => 'LBL_HINT_NEWS_NOTIFICATIONS_ARTICLE_DATE',
            'type' => 'datetime',
            'required' => true,
        ],
        'photo_url' => [
            'name' => 'photo_url',
            'vname' => 'LBL_HINT_NEWS_NOTIFICATIONS_PHOTO_URL',
            'type' => 'text',
            'required' => true,
        ],
        'source_url' => [
            'name' => 'source_url',
            'vname' => 'LBL_HINT_NEWS_NOTIFICATIONS_SOURCE_URL',
            'type' => 'text',
            'required' => true,
        ],
        'publisher' => [
            'name' => 'publisher',
            'vname' => 'LBL_HINT_NEWS_NOTIFICATIONS_PUBLISHER',
            'type' => 'varchar',
            'len' => '64',        // REMIND: SWAG
            'required' => true,
        ],
    ],
    'indices' => [],
    'relationships' => [],
    'optimistic_locking' => false,
    'unified_search' => false,
    'full_text_search' => false,
];

\VardefManager::createVardef('HintNewsNotifications', 'HintNewsNotification', ['basic', 'assignable']);

$dictionary['HintNewsNotification']['fields']['id']['vname'] = 'LBL_HINT_NEWS_NOTIFICATIONS_ID';

$dictionary['HintNewsNotification']['fields']['assigned_user_id']['required'] = true;
$dictionary['HintNewsNotification']['fields']['assigned_user_id']['vname'] = 'LBL_HINT_NEWS_NOTIFICATIONS_USER_ID';
$dictionary['HintNewsNotification']['fields']['assigned_user_name']['vname'] = 'LBL_HINT_NEWS_NOTIFICATIONS_USER_NAME';
