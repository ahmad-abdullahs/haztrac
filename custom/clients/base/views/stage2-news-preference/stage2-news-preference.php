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
$viewdefs['base']['view']['stage2-news-preference'] = [
    'label_type' => [
        'type' => 'label',
        'default_value' => 'LBL_HINT_FOR',
        'cls' => 'stage2-notifications-pref-label'
    ],
    'input_type' => [
        'type' => 'enum',
        'name' => 'type',
        'options' => 'stage2_preferences_type',
        'cls' => 'stage2-notifications-pref-cat'
    ],
    'label_tag' => [
        'type' => 'label',
        'default_value' => 'LBL_HINT_WITH',
        'cls' => 'stage2-notifications-pref-label'
    ],
    'input_tag' => [
        'name' => 'tag',
        'type' => 'tag',
        'cls' => 'stage2-notifications-pref-tags'
    ],
    'label_category' => [
        'type' => 'label',
        'default_value' => 'LBL_HINT_SHOW_ME',
        'cls' => 'stage2-notifications-pref-label'
    ],
    'input_category' => [
        'type' => 'enum',
        'name' => 'category',
        'options' => 'stage2_preferences_category',
        'cls' => 'stage2-notifications-pref-news-cat'
    ],
    'label_target' => [
        'type' => 'label',
        'default_value' => 'LBL_HINT_NOTIFY_ME_BY',
        'cls' => 'stage2-notifications-pref-label',
    ],
    'input_sugar' => [
        'name' => 'sugar',
        'type' => 'stage2_preficon',
        'icon_class' => 'fa-newspaper-o',
        'cls' => 'stage2-notifications-pref-icon'
    ],
    'input_browser' => [
        'name' => 'browser',
        'type' => 'stage2_preficon',
        'icon_class' => 'fa-bell',
        'cls' => 'stage2-notifications-pref-icon'
    ],
    'input_browser_disabled' => [
        'name' => 'disabled',
        'action' => 'disabled',
        'type' => 'stage2_preficon',
        'icon_class' => 'fa-bell-slash',
        'cls' => 'stage2-notifications-pref-icon'
    ],
    'input_immediate' => [
        'name' => 'email-immediate',
        'type' => 'stage2_preficon',
        'icon_class' => 'fa-envelope',
        'cls' => 'stage2-notifications-pref-icon'
    ],
    'input_daily' => [
        'name' => 'email-daily',
        'type' => 'stage2_preficon',
        'icon_class' => 'fa-calendar-o',
        'icon_text' => '1',
        'cls' => 'stage2-notifications-pref-icon'
    ],
    'input_weekly' => [
        'name' => 'email-weekly',
        'type' => 'stage2_preficon',
        'icon_class' => 'fa-calendar-o',
        'icon_text' => '7',
        'cls' => 'stage2-notifications-pref-icon'
    ]
];
