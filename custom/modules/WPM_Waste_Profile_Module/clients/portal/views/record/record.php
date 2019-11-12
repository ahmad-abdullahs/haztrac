<?php

$viewdefs['WPM_Waste_Profile_Module'] = array(
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
                        'type' => 'button',
                        'name' => 'cancel_button',
                        'label' => 'LBL_CANCEL_BUTTON_LABEL',
                        'css_class' => 'btn-invisible btn-link',
                        'showOn' => 'edit',
                        'events' =>
                        array(
                            'click' => 'button:cancel_button:click',
                        ),
                    ),
                    1 =>
                    array(
                        'type' => 'rowaction',
                        'event' => 'button:save_button:click',
                        'name' => 'save_button',
                        'label' => 'LBL_SAVE_BUTTON_LABEL',
                        'css_class' => 'btn btn-primary',
                        'showOn' => 'edit',
                        'acl_action' => 'edit',
                    ),
                    2 =>
                    array(
                        'type' => 'actiondropdown',
                        'name' => 'main_dropdown',
                        'primary' => true,
                        'showOn' => 'view',
                        'buttons' =>
                        array(
                            0 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:edit_button:click',
                                'name' => 'edit_button',
                                'label' => 'LBL_EDIT_BUTTON_LABEL',
                                'acl_action' => 'edit',
                            ),
                            1 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:duplicate_button:click',
                                'name' => 'duplicate_button',
                                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                                'acl_module' => 'WPM_Waste_Profile_Module',
                                'acl_action' => 'create',
                            ),
                            3 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:delete_button:click',
                                'name' => 'delete_button',
                                'label' => 'LBL_DELETE_BUTTON_LABEL',
                                'acl_action' => 'delete',
                            ),
                        ),
                    ),
                    3 =>
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
                        'label' => 'LBL_RECORD_HEADER',
                        'header' => true,
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'picture',
                                'type' => 'avatar',
                                'width' => 42,
                                'height' => 42,
                                'dismiss_label' => true,
                                'readonly' => true,
                            ),
                            1 =>
                            array(
                                'name' => 'name',
                                'span' => 12,
                            ),
                            2 =>
                            array(
                                'name' => 'favorite',
                                'label' => 'LBL_FAVORITE',
                                'type' => 'favorite',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'follow',
                                'label' => 'LBL_FOLLOW',
                                'type' => 'follow',
                                'readonly' => true,
                                'dismiss_label' => true,
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
                                'name' => 'waste_profile_num_c',
                                'label' => 'LBL_WASTE_PROFILE_NUM',
                            ),
                            1 =>
                            array(
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
