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
$viewdefs['HintAccountsets']['base']['layout']['dashletconfiguration'] = [
    'components' => [
        [
            'layout' => [
                'type' => 'default',
                'name' => 'sidebar',
                'components' => [
                    [
                        'layout' => [
                            'type' => 'base',
                            'name' => 'main-pane',
                            'components' => [
                                [
                                    'layout' => [
                                        'type' => 'base',
                                        'name' => 'main-pane',
                                        'components' => [
                                            [
                                                'layout' => [
                                                    'type' => 'base',
                                                    'name' => 'main-pane',
                                                    'css_class' => 'main-pane span8 stage2-preferences-drawer',
                                                    'components' => [
                                                        [
                                                            'view' => 'dashletconfiguration-headerpane'
                                                        ], [
                                                            'layout' => 'stage2-news-preferences'
                                                        ]
                                                    ]
                                                ]
                                            ], [
                                                'layout' => [
                                                    'type' => 'base',
                                                    'name' => 'preview-pane',
                                                    'css_class' => 'side sidebar-content span4',
                                                    'components' => [
                                                        [
                                                            'view' => 'stage2-news-preferences-key-headerpane'
                                                        ], [
                                                            'layout' => 'stage2-news-preferences-key'
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
