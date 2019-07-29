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
$viewdefs['base']['layout']['hint-news-panel'] = [
    'css_class' => 'hint-panel-content',
    'components' => [
        [
            'view' => [
                'type' => 'hint-panel-header',
                'icon' => 'newspaper-o',
                'title' => 'LBL_HINT_NEWS',
                'fields' => [
                   [
                        'type' => 'hint-news-panel-filter',
                        'view' => 'edit',
                        'name' => 'categories',
                        'default' => 'All',
                        'searchBarThreshold' => 1,
                        'options' => 'stage2_preferences_category'
                    ], [
                        'type' => 'hint-news-preferences-trigger',
                        'icon' => 'fa-cog',
                        'view' => 'detail'
                    ]
                ]
            ]
        ], [
            'view' => [
                'type' => 'stage2-news'
            ]
        ]
    ]
];
