<?php

$module_name = 'WPM_Waste_Profile_Module';
$viewdefs[$module_name] = array(
    'base' =>
    array(
        'view' =>
        array(
            'preview' =>
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
                                'type' => 'shareaction',
                                'name' => 'share',
                                'label' => 'LBL_RECORD_SHARE_BUTTON',
                                'acl_action' => 'view',
                            ),
                            2 =>
                            array(
                                'type' => 'pdfaction',
                                'name' => 'download-pdf',
                                'label' => 'LBL_PDF_VIEW',
                                'action' => 'download',
                                'acl_action' => 'view',
                            ),
                            3 =>
                            array(
                                'type' => 'pdfaction',
                                'name' => 'email-pdf',
                                'label' => 'LBL_PDF_EMAIL',
                                'action' => 'email',
                                'acl_action' => 'view',
                            ),
                            4 =>
                            array(
                                'type' => 'divider',
                            ),
                            5 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:find_duplicates_button:click',
                                'name' => 'find_duplicates_button',
                                'label' => 'LBL_DUP_MERGE',
                                'acl_action' => 'edit',
                            ),
                            6 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:duplicate_button:click',
                                'name' => 'duplicate_button',
                                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                                'acl_module' => 'WPM_Waste_Profile_Module',
                                'acl_action' => 'create',
                            ),
                            7 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:audit_button:click',
                                'name' => 'audit_button',
                                'label' => 'LNK_VIEW_CHANGE_LOG',
                                'acl_action' => 'view',
                            ),
                            8 =>
                            array(
                                'type' => 'divider',
                            ),
                            9 =>
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
                            1 => 'name',
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
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL12',
                        'label' => 'LBL_RECORDVIEW_PANEL12',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'profile_preview',
                                'label' => 'LBL_PROFILE_PREVIEW',
                                'span' => 12,
                            ),
                        ),
                    ),
                    2 =>
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
                                'name' => 'submission_type_c',
                                'label' => 'LBL_SUBMISSION_TYPE',
                            ),
                            1 =>
                            array(
                                'name' => 'generator_type_c',
                                'label' => 'LBL_GENERATOR_TYPE',
                            ),
                            2 =>
                            array(
                                'name' => 'accounts_wpm_waste_profile_module_1_name',
                            ),
                            3 =>
                            array(
                                'name' => 'waste_profile_num_c',
                                'label' => 'LBL_WASTE_PROFILE_NUM',
                            ),
                            4 =>
                            array(
                                'name' => 'accounts_wpm_waste_profile_module_2_name',
                            ),
                            5 =>
                            array(
                                'name' => 'wp_usepa_id_c',
                                'label' => 'LBL_WP_USEPA_ID',
                            ),
                            6 =>
                            array(
                                'name' => 'tag',
                                'span' => 12,
                            ),
                            7 =>
                            array(
                            ),
                            8 =>
                            array(
                            ),
                            9 =>
                            array(
                            ),
                            10 =>
                            array(
                            ),
                        ),
                    ),
                    3 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL1',
                        'label' => 'LBL_RECORDVIEW_PANEL1',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'wp_waste_name_c',
                                'label' => 'LBL_WP_WASTE_NAME',
                            ),
                            1 =>
                            array(
                            ),
                            2 =>
                            array(
                                'name' => 'wp_generating_process_c',
                                'studio' => 'visible',
                                'label' => 'LBL_WP_GENERATING_PROCESS',
                            ),
                            3 =>
                            array(
                                'name' => 'generator_knowledge_c',
                                'label' => 'LBL_GENERATOR_KNOWLEDGE',
                            ),
                            4 =>
                            array(
                                'name' => 'service_frequency_c',
                                'label' => 'LBL_SERVICE_FREQUENCY',
                            ),
                            5 =>
                            array(
                            ),
                        ),
                    ),
                    4 =>
                    array(
                        'name' => 'panel_hidden',
                        'label' => 'LBL_SHOW_MORE',
                        'hide' => true,
                        'columns' => 2,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'physical_state_c',
                                'label' => 'LBL_PHYSICAL_STATE',
                            ),
                            1 =>
                            array(
                                'name' => 'wp_color_c',
                                'label' => 'LBL_WP_COLOR',
                            ),
                            2 =>
                            array(
                                'name' => 'describe_appearance_c',
                                'label' => 'LBL_DESCRIBE_APPEARANCE',
                            ),
                            3 =>
                            array(
                                'name' => 'number_of_phases_c',
                                'label' => 'LBL_NUMBER_OF_PHASES',
                            ),
                            4 =>
                            array(
                                'name' => 'odor_c',
                                'label' => 'LBL_ODOR',
                            ),
                            5 =>
                            array(
                                'name' => 'odor_description_c',
                                'label' => 'LBL_ODOR_DESCRIPTION',
                            ),
                            6 =>
                            array(
                                'name' => 'flash_point_c',
                                'label' => 'LBL_FLASH_POINT',
                            ),
                            7 =>
                            array(
                                'name' => 'btu_c',
                                'label' => 'LBL_BTU',
                            ),
                            8 =>
                            array(
                                'name' => 'ash_content_c',
                                'label' => 'LBL_ASH_CONTENT',
                            ),
                            9 =>
                            array(
                                'name' => 'ph_c',
                                'label' => 'LBL_PH',
                            ),
                            10 =>
                            array(
                                'name' => 'viscosity_c',
                                'label' => 'LBL_VISCOSITY',
                            ),
                            11 =>
                            array(
                                'name' => 'specific_gravity_c',
                                'label' => 'LBL_SPECIFIC_GRAVITY',
                            ),
                        ),
                    ),
                    5 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL2',
                        'label' => 'LBL_RECORDVIEW_PANEL2',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'wp_test_radio_c',
                                'label' => 'LBL_WP_TEST_RADIO',
                            ),
                            1 =>
                            array(
                            ),
                        ),
                    ),
                    6 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL3',
                        'label' => 'LBL_RECORDVIEW_PANEL3',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                            ),
                            1 =>
                            array(
                            ),
                        ),
                    ),
                    7 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL6',
                        'label' => 'LBL_RECORDVIEW_PANEL6',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                            ),
                            1 =>
                            array(
                            ),
                        ),
                    ),
                    8 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL4',
                        'label' => 'LBL_RECORDVIEW_PANEL4',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                            ),
                            1 =>
                            array(
                            ),
                        ),
                    ),
                    9 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL5',
                        'label' => 'LBL_RECORDVIEW_PANEL5',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                            ),
                            1 =>
                            array(
                            ),
                        ),
                    ),
                    10 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL7',
                        'label' => 'LBL_RECORDVIEW_PANEL7',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 => 'assigned_user_name',
                            1 => 'team_name',
                            2 =>
                            array(
                                'name' => 'created_by_name',
                                'readonly' => true,
                                'label' => 'LBL_CREATED',
                            ),
                            3 =>
                            array(
                                'name' => 'date_entered',
                                'comment' => 'Date record created',
                                'studio' =>
                                array(
                                    'portaleditview' => false,
                                ),
                                'readonly' => true,
                                'label' => 'LBL_DATE_ENTERED',
                            ),
                            4 =>
                            array(
                                'name' => 'date_modified',
                                'comment' => 'Date record last modified',
                                'studio' =>
                                array(
                                    'portaleditview' => false,
                                ),
                                'readonly' => true,
                                'label' => 'LBL_DATE_MODIFIED',
                            ),
                            5 =>
                            array(
                            ),
                            6 =>
                            array(
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
