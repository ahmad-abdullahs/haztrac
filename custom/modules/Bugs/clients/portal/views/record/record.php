<?php

$viewdefs['Bugs'] = array(
    'portal' =>
    array(
        'view' =>
        array(
            'record' =>
            array(
                'buttons' =>
                array(
                    0 =>
                    array(
                        'name' => 'sidebar_toggle',
                        'type' => 'sidebartoggle',
                    ),
                ),
                'panels' =>
                array(
                    0 =>
                    array(
                        'name' => 'panel_header',
                        'header' => true,
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'label' => 'LBL_RECORD_HEADER',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'picture',
                                'type' => 'avatar',
                                'size' => 'large',
                                'dismiss_label' => true,
                                'readonly' => true,
                            ),
                            1 =>
                            array(
                                'name' => 'name',
                                'span' => 12,
                            ),
                        ),
                    ),
                    1 =>
                    array(
                        'name' => 'panel_body',
                        'label' => 'LBL_RECORD_BODY',
                        'columns' => 2,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'bug_number',
                                'span' => 12,
                            ),
                            1 =>
                            array(
                                'name' => 'description',
                                'span' => 12,
                            ),
                            2 => 'status',
                            3 => 'type',
                            4 => 'source',
                            5 => 'product_category',
                            6 => 'priority',
                            7 =>
                            array(
                                'name' => 'resolution',
                                'readonly' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'work_log',
                                'span' => 12,
                            ),
                        ),
                    ),
                ),
                'templateMeta' =>
                array(
                    'useTabs' => false,
                ),
            ),
        ),
    ),
);
