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
$viewdefs['Home']['base']['view']['hint-news-dashlet'] = [
    'custom_toolbar' => [
        'buttons' => [
            [
                'type' => 'hint-news-dashlet-search'
            ], [
                'dropdown_buttons' => [
                    [
                        'type' => 'dashletaction',
                        'action' => 'editClicked',
                        'label' => 'LBL_DASHLET_CONFIG_EDIT_LABEL',
                    ], [
                        'type' => 'dashletaction',
                        'action' => 'refreshClicked',
                        'label' => 'LBL_DASHLET_REFRESH_LABEL',
                    ], [
                        'type' => 'dashletaction',
                        'action' => 'toggleClicked',
                        'label' => 'LBL_DASHLET_MINIMIZE',
                        'event' => 'minimize',
                    ], [
                        'type' => 'dashletaction',
                        'action' => 'removeClicked',
                        'label' => 'LBL_DASHLET_REMOVE_LABEL',
                    ]
                ]
            ]
        ],
        
    ],
    'dashlets' => [
        [
            'label' => 'LBL_HINT_NEWS_ALERT',
            'description' => 'LBL_HINT_NEWS_ALERT',
            'config' => [
                'limit' => '20',
                'module' => 'HintAccountsets',
                'type' => 'hint-news-dashlet',
                'name' => 'dashletconfiguration'
            ],
            'preview' => [
                'title' => 'LBL_HINT_NEWS_ALERT',
                'limit' => '3',
            ]
        ]
    ]
];
