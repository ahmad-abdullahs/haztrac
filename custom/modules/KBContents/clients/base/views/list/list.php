<?php

$viewdefs['KBContents'] = array(
    'base' =>
    array(
        'view' =>
        array(
            'list' =>
            array(
                'panels' =>
                array(
                    0 =>
                    array(
                        'label' => 'LBL_PANEL_1',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                                'related_fields' =>
                                array(
                                    0 => 'kbdocument_id',
                                    1 => 'kbarticle_id',
                                    2 => 'kbdocument_body',
                                ),
                            ),
                            1 =>
                            array(
                                'name' => 'language',
                                'label' => 'LBL_LANG',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                                'type' => 'enum-config',
                                'key' => 'languages',
                            ),
                            2 =>
                            array(
                                'name' => 'status',
                                'label' => 'LBL_STATUS',
                                'enabled' => true,
                                'default' => true,
                                'type' => 'status',
                                'related_fields' =>
                                array(
                                    0 => 'active_date',
                                    1 => 'exp_date',
                                ),
                            ),
                            3 =>
                            array(
                                'name' => 'category_name',
                                'label' => 'LBL_CATEGORY_NAME',
                                'enabled' => true,
                                'default' => true,
                                'css_class' => 'overflow-visible',
                                'initial_filter' => 'by_category',
                                'initial_filter_label' => 'LBL_FILTER_CREATE_NEW',
                                'filter_relate' =>
                                array(
                                    'category_id' => 'category_id',
                                ),
                            ),
                            4 =>
                            array(
                                'name' => 'viewcount',
                                'label' => 'LBL_VIEWED_COUNT',
                                'enabled' => true,
                                'default' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'date_entered',
                                'label' => 'LBL_DATE_ENTERED',
                                'enabled' => true,
                                'default' => true,
                                'readonly' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'exp_date',
                                'label' => 'LBL_EXP_DATE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            7 =>
                            array(
                                'name' => 'is_external',
                                'label' => 'LBL_IS_EXTERNAL',
                                'enabled' => true,
                                'default' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'revision',
                                'label' => 'LBL_REVISION',
                                'enabled' => true,
                                'default' => false,
                                'readonly' => true,
                            ),
                            9 =>
                            array(
                                'name' => 'kbsapprover_name',
                                'label' => 'LBL_KBSAPPROVER',
                                'default' => false,
                                'enabled' => true,
                            ),
                            10 =>
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_ASSIGNED_TO',
                                'default' => false,
                                'enabled' => true,
                            ),
                        ),
                    ),
                ),
                'orderBy' =>
                array(
                    'field' => 'date_modified',
                    'direction' => 'desc',
                ),
            ),
        ),
    ),
);
