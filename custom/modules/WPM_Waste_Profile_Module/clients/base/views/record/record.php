<?php

$module_name = 'WPM_Waste_Profile_Module';
$viewdefs[$module_name] = array(
    'base' =>
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
                                'type' => 'shareaction',
                                'name' => 'share',
                                'label' => 'LBL_RECORD_SHARE_BUTTON',
                                'acl_action' => 'view',
                            ),
                            2 =>
                            array(
                                'type' => 'rowaction',
                                'name' => 'convert_to_lab_template',
                                'event' => 'button:convert_to_lab_template_button:click',
                                'label' => 'LBL_CONVERT_TO_LAB_TEMPLATE',
                                'acl_action' => 'view',
                            ),
                            3 =>
                            array(
                                'type' => 'pdfaction',
                                'name' => 'download-pdf',
                                'label' => 'LBL_PDF_VIEW',
                                'action' => 'download',
                                'acl_action' => 'view',
                            ),
                            4 =>
                            array(
                                'type' => 'pdfaction',
                                'name' => 'email-pdf',
                                'label' => 'LBL_PDF_EMAIL',
                                'action' => 'email',
                                'acl_action' => 'view',
                            ),
                            5 =>
                            array(
                                'type' => 'divider',
                            ),
                            6 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:find_duplicates_button:click',
                                'name' => 'find_duplicates_button',
                                'label' => 'LBL_DUP_MERGE',
                                'acl_action' => 'edit',
                            ),
                            7 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:duplicate_button:click',
                                'name' => 'duplicate_button',
                                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                                'acl_module' => 'WPM_Waste_Profile_Module',
                                'acl_action' => 'create',
                            ),
                            8 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:audit_button:click',
                                'name' => 'audit_button',
                                'label' => 'LNK_VIEW_CHANGE_LOG',
                                'acl_action' => 'view',
                            ),
                            9 =>
                            array(
                                'type' => 'divider',
                            ),
                            10 =>
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
                            4 =>
                            array(
                                'name' => 'profile_acceptance',
                                'label' => 'LBL_PROFILE_ACCEPTANCE',
                                'type' => 'profile-acceptance',
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
                                'name' => 'waste_profile_template_c',
                                'studio' => 'visible',
                                'label' => 'LBL_WASTE_PROFILE_TEMPLATE',
                                'type' => 'waste-profile-template-relate',
                            ),
                            1 =>
                            array(
                                'name' => 'submission_type_c',
                                'label' => 'LBL_SUBMISSION_TYPE',
                            ),
                            2 =>
                            array(
                                'name' => 'accounts_wpm_waste_profile_module_2_name',
                            ),
                            3 =>
                            array(
                                'name' => 'wp_usepa_id_c',
                                'label' => 'LBL_WP_USEPA_ID',
                            ),
                            4 =>
                            array(
                                'name' => 'generator_type_c',
                                'label' => 'LBL_GENERATOR_TYPE',
                            ),
                            5 =>
                            array(
                            ),
                            6 =>
                            array(
                                'name' => 'accounts_wpm_waste_profile_module_1_name',
                            ),
                            7 =>
                            array(
                                'name' => 'waste_profile_num_c',
                                'label' => 'LBL_WASTE_PROFILE_NUM',
                                'readonly' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'accounts_wpm_waste_profile_module_3_name',
                            ),
                            9 =>
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
                            6 =>
                            array(
                                'name' => 'quest_small_in_large_container_c',
                                'label' => 'LBL_SMALL_IN_LARGE_CONTAINER',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            7 =>
                            array(
                                'name' => 'quest_small_in_large_container_c_1',
                                'default_value' => 'LBL_SMALL_IN_LARGE_CONTAINER',
                                'type' => 'label',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
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
                                'type' => 'radioenum-linear',
                            ),
                            1 =>
                            array(
                                'name' => 'wp_color_c',
                                'label' => 'LBL_WP_COLOR',
                            ),
                            2 =>
                            array(
                                'name' => 'liquid_solid_mixture_group',
                                'type' => 'custom-fieldset',
                                'inline' => true,
                                'equal_spacing' => true,
                                'span' => 12,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    1 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span2 record-cell',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'free_liquid_c',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span2 record-cell',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'settled_solid_c',
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    7 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span2 record-cell',
                                    ),
                                    8 =>
                                    array(
                                        'name' => 'total_suspended_solid_c',
                                    ),
                                    9 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                                'span' => 12,
                            ),
                            3 =>
                            array(
                                'name' => 'describe_appearance_c',
                                'label' => 'LBL_DESCRIBE_APPEARANCE',
                            ),
                            4 =>
                            array(
                                'name' => 'number_of_phases_c',
                                'label' => 'LBL_NUMBER_OF_PHASES',
                            ),
                            5 =>
                            array(
                                'name' => 'odor_c',
                                'label' => 'LBL_ODOR',
                                'type' => 'radioenum-linear',
                            ),
                            6 =>
                            array(
                                'name' => 'odor_description_c',
                                'label' => 'LBL_ODOR_DESCRIPTION',
                            ),
                            7 =>
                            array(
                                'name' => 'flash_point_c',
                                'label' => 'LBL_FLASH_POINT',
                                'type' => 'radioenum-linear',
                            ),
                            8 =>
                            array(
                                'name' => 'btu_c',
                                'label' => 'LBL_BTU',
                                'type' => 'radioenum-linear',
                            ),
                            9 =>
                            array(
                                'name' => 'ash_content_c',
                                'label' => 'LBL_ASH_CONTENT',
                                'type' => 'radioenum-linear',
                            ),
                            10 =>
                            array(
                                'name' => 'ph_c',
                                'label' => 'LBL_PH',
                                'type' => 'radioenum-linear',
                            ),
                            11 =>
                            array(
                                'name' => 'viscosity_c',
                                'label' => 'LBL_VISCOSITY',
                                'type' => 'radioenum-linear',
                            ),
                            12 =>
                            array(
                                'name' => 'specific_gravity_c',
                                'label' => 'LBL_SPECIFIC_GRAVITY',
                                'type' => 'radioenum-linear',
                            ),
                            13 =>
                            array(
                                'name' => 'boiling_point_c',
                                'label' => 'LBL_BOILING_POINT',
                                'type' => 'radioenum-linear',
                            ),
                            14 =>
                            array(
                                'name' => 'melting_point_c',
                                'label' => 'LBL_MELTING_POINT',
                                'type' => 'radioenum-linear',
                            ),
                            15 =>
                            array(
                                'name' => 'total_organic_carbon_c',
                                'label' => 'LBL_TOTAL_ORGANIC_CARBON',
                                'type' => 'radioenum-linear',
                            ),
                            16 =>
                            array(
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
                        'columns' => 3,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'composition',
                                'type' => 'composition',
                                'dismiss_label' => true,
                                'span' => 12,
                                'related_fields' =>
                                array(
                                    0 => 'composition',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'composition_name',
                                        'css_class' => 'composition_name',
                                        'label' => 'LBL_COMPOSITION_NAME',
                                        'type' => 'text',
                                        'span' => 4,
                                        'required' => true,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'composition_min',
                                        'css_class' => 'composition_min',
                                        'label' => 'LBL_COMPOSITION_MIN',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'composition_max',
                                        'css_class' => 'composition_max',
                                        'label' => 'LBL_COMPOSITION_MAX',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'composition_uom',
                                        'css_class' => 'composition_uom',
                                        'label' => 'LBL_COMPOSITION_UOM',
                                        'type' => 'enum',
                                        'options' => 'uom_list',
                                        'span' => 3,
                                    ),
                                ),
                                'footer_fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'empty_field1',
                                        'css_class' => 'hidden',
                                        'span' => 4,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'empty_field2',
                                        'css_class' => '',
                                        'type' => 'non-html-field',
                                        'label' => 'LBL_COMPOSITION_MAX_TOTAL',
                                        'span' => 2,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'composition_max_total',
                                        'css_class' => 'composition_max_total',
                                        'label' => 'LBL_COMPOSITION_MAX_TOTAL',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'readonly' => true,
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'empty_field3',
                                        'css_class' => 'hidden',
                                        'span' => 3,
                                    ),
                                ),
                                'span' => 12,
                            ),
                            1 =>
                            array(
                                'name' => 'quest_contain_heavy_metals_c',
                                'label' => 'LBL_QUEST_CONTAIN_HEAVY_METALS',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            2 =>
                            array(
                                'name' => 'quest_contain_heavy_metals_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_CONTAIN_HEAVY_METALS',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            3 =>
                            array(
                                'span' => 2,
                            ),
                            4 =>
                            array(
                                'name' => 'describe_with_dimensions_c',
                                'label' => 'LBL_DESCRIBE_WITH_DIMENSIONS',
                                'span' => 10,
                            ),
                            5 =>
                            array(
                                'name' => 'quest_metal_in_powdered_form_c',
                                'label' => 'LBL_QUEST_METAL_IN_POWDERED_FORM',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            6 =>
                            array(
                                'name' => 'quest_metal_in_powdered_form_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_METAL_IN_POWDERED_FORM',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            7 =>
                            array(
                                'span' => 2,
                            ),
                            8 =>
                            array(
                                'name' => 'describe_metal_in_powdered_form_c',
                                'label' => 'LBL_DESCRIBE_THE_DETAILS',
                                'span' => 10,
                            ),
                            9 =>
                            array(
                                'name' => 'quest_animal_waste_c',
                                'label' => 'LBL_QUEST_ANIMAL_WASTE',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            10 =>
                            array(
                                'name' => 'quest_animal_waste_c_1',
                                'default_value' => 'LBL_QUEST_ANIMAL_WASTE',
                                'type' => 'label',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            11 =>
                            array(
                                'span' => 2,
                            ),
                            12 =>
                            array(
                                'name' => 'describe_animal_waste_c',
                                'label' => 'LBL_DESCRIBE_THE_DETAILS',
                                'span' => 10,
                            ),
                            13 =>
                            array(
                                'span' => 2,
                            ),
                            14 =>
                            array(
                                'name' => 'acknowledge_0',
                                'default_value' => 'LBL_ACKNOWLEDGE_0',
                                'type' => 'label',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            15 =>
                            array(
                                'span' => 2,
                            ),
                            16 =>
                            array(
                                'name' => 'acknowledge_1_c',
                                'label' => 'LBL_ACKNOWLEDGE_1',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            17 =>
                            array(
                                'name' => 'acknowledge_1_c_1',
                                'default_value' => 'LBL_ACKNOWLEDGE_1',
                                'type' => 'label',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 8,
                            ),
                            18 =>
                            array(
                                'span' => 2,
                            ),
                            19 =>
                            array(
                                'name' => 'acknowledge_2_c',
                                'label' => 'LBL_ACKNOWLEDGE_2',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            20 =>
                            array(
                                'name' => 'acknowledge_2_c_1',
                                'default_value' => 'LBL_ACKNOWLEDGE_2',
                                'type' => 'label',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 8,
                            ),
                            21 =>
                            array(
                                'name' => 'quest_packaging_requirements_c',
                                'label' => 'LBL_QUEST_PACKAGING_REQUIREMENTS',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            22 =>
                            array(
                                'name' => 'quest_packaging_requirements_c_1',
                                'default_value' => 'LBL_QUEST_PACKAGING_REQUIREMENTS',
                                'type' => 'label',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            23 =>
                            array(
                                'span' => 2,
                            ),
                            24 =>
                            array(
                                'name' => 'describe_packaging_requirements_c',
                                'label' => 'LBL_DESCRIBE_THE_DETAILS',
                                'span' => 10,
                            ),
                            25 =>
                            array(
                                'name' => 'quest_double_bagged_c',
                                'label' => 'LBL_QUEST_DOUBLE_BAGGED',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            26 =>
                            array(
                                'name' => 'quest_double_bagged_c_1',
                                'default_value' => 'LBL_QUEST_DOUBLE_BAGGED',
                                'type' => 'label',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            27 =>
                            array(
                                'name' => 'associated_source_code_c',
                                'label' => 'LBL_ASSOCIATED_SOURCE_CODE',
                                'type' => 'enum-same-key-and-value',
                                'span' => 12,
                            ),
                            28 =>
                            array(
                                'name' => 'associated_form_code_c',
                                'label' => 'LBL_ASSOCIATED_FORM_CODE',
                                'type' => 'enum-same-key-and-value',
                                'span' => 12,
                            ),
                        ),
                    ),
                    7 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL8',
                        'label' => 'LBL_RECORDVIEW_PANEL8',
                        'columns' => 3,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'lbl_constituent_header_1',
                                'type' => 'label',
                                'default_value' => 'LBL_CONSTITUENT_HEADER',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 12,
                                // 'background_color' => '#ebedef',
                            ),
                            1 =>
                            array(
                                'span' => 12,
                            ),
                            2 =>
                            array(
                                'name' => 'constituent_regulated',
                                'type' => 'constituent_regulated',
                                'label' => 'LBL_CONSTITUENT_REGULATED',
                                'span' => 6,
                                'primary_field' => 'constituent_regulated_epa_waste_code',
                                'related_fields' =>
                                array(
                                    0 => 'constituent_regulated',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'constituent_regulated_epa_waste_code',
                                        'css_class' => 'constituent_regulated_epa_waste_code',
                                        'label' => 'LBL_CONSTITUENT_EPA_WASTE_CODE',
                                        'type' => 'enum',
                                        'options' => 'WP_EPA_CODES',
                                        'span' => 3,
                                        'required' => true,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'constituent_regulated_regulatory_level',
                                        'css_class' => 'constituent_regulated_regulatory_level',
                                        'label' => 'LBL_CONSTITUENT_REGULATORY_LEVEL',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'constituent_regulated_tclp',
                                        'css_class' => 'constituent_regulated_tclp',
                                        'label' => 'LBL_CONSTITUENT_TCLP',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'constituent_regulated_uom',
                                        'css_class' => 'constituent_regulated_uom',
                                        'label' => 'LBL_CONSTITUENT_UOM',
                                        'type' => 'enum',
                                        'options' => 'uom_list',
                                        'span' => 3,
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'constituent_regulated_not_applicable',
                                        'css_class' => 'constituent_regulated_not_applicable',
                                        'label' => 'LBL_CONSTITUENT_NOT_APPLICABLE',
                                        'type' => 'bool',
                                        'span' => 1,
                                    ),
                                ),
                            ),
                            3 =>
                            array(
                                'name' => 'constituent_volatile',
                                'type' => 'constituent_volatile',
                                'label' => 'LBL_CONSTITUENT_VOLATILE',
                                'span' => 6,
                                'primary_field' => 'constituent_volatile_epa_waste_code',
                                'related_fields' =>
                                array(
                                    0 => 'constituent_volatile',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'constituent_volatile_epa_waste_code',
                                        'css_class' => 'constituent_volatile_epa_waste_code',
                                        'label' => 'LBL_CONSTITUENT_EPA_WASTE_CODE',
                                        'type' => 'enum',
                                        'options' => 'WP_EPA_CODES',
                                        'span' => 3,
                                        'required' => true,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'constituent_volatile_regulatory_level',
                                        'css_class' => 'constituent_volatile_regulatory_level',
                                        'label' => 'LBL_CONSTITUENT_REGULATORY_LEVEL',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'constituent_volatile_tclp',
                                        'css_class' => 'constituent_volatile_tclp',
                                        'label' => 'LBL_CONSTITUENT_TCLP',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'constituent_volatile_uom',
                                        'css_class' => 'constituent_volatile_uom',
                                        'label' => 'LBL_CONSTITUENT_UOM',
                                        'type' => 'enum',
                                        'options' => 'uom_list',
                                        'span' => 3,
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'constituent_volatile_not_applicable',
                                        'css_class' => 'constituent_volatile_not_applicable',
                                        'label' => 'LBL_CONSTITUENT_NOT_APPLICABLE',
                                        'type' => 'bool',
                                        'span' => 1,
                                    ),
                                ),
                            ),
                            4 =>
                            array(
                                'name' => 'constituent_semivolatile',
                                'type' => 'constituent_semivolatile',
                                'label' => 'LBL_CONSTITUENT_SEMIVOLATILE',
                                'span' => 6,
                                'primary_field' => 'constituent_semivolatile_epa_waste_code',
                                'related_fields' =>
                                array(
                                    0 => 'constituent_semivolatile',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'constituent_semivolatile_epa_waste_code',
                                        'css_class' => 'constituent_semivolatile_epa_waste_code',
                                        'label' => 'LBL_CONSTITUENT_EPA_WASTE_CODE',
                                        'type' => 'enum',
                                        'options' => 'WP_EPA_CODES',
                                        'span' => 3,
                                        'required' => true,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'constituent_semivolatile_regulatory_level',
                                        'css_class' => 'constituent_semivolatile_regulatory_level',
                                        'label' => 'LBL_CONSTITUENT_REGULATORY_LEVEL',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'constituent_semivolatile_tclp',
                                        'css_class' => 'constituent_semivolatile_tclp',
                                        'label' => 'LBL_CONSTITUENT_TCLP',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'constituent_semivolatile_uom',
                                        'css_class' => 'constituent_semivolatile_uom',
                                        'label' => 'LBL_CONSTITUENT_UOM',
                                        'type' => 'enum',
                                        'options' => 'uom_list',
                                        'span' => 3,
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'constituent_semivolatile_not_applicable',
                                        'css_class' => 'constituent_semivolatile_not_applicable',
                                        'label' => 'LBL_CONSTITUENT_NOT_APPLICABLE',
                                        'type' => 'bool',
                                        'span' => 1,
                                    ),
                                ),
                            ),
                            5 =>
                            array(
                                'name' => 'constituent_pesticide_herbicide',
                                'type' => 'constituent_pesticide_herbicide',
                                'label' => 'LBL_CONSTITUENT_PESTICIDE_HERBICIDE',
                                'span' => 6,
                                'primary_field' => 'constituent_pesticide_herbicide_epa_waste_code',
                                'related_fields' =>
                                array(
                                    0 => 'constituent_pesticide_herbicide',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'constituent_pesticide_herbicide_epa_waste_code',
                                        'css_class' => 'constituent_pesticide_herbicide_epa_waste_code',
                                        'label' => 'LBL_CONSTITUENT_EPA_WASTE_CODE',
                                        'type' => 'enum',
                                        'options' => 'WP_EPA_CODES',
                                        'span' => 3,
                                        'required' => true,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'constituent_pesticide_herbicide_regulatory_level',
                                        'css_class' => 'constituent_pesticide_herbicide_regulatory_level',
                                        'label' => 'LBL_CONSTITUENT_REGULATORY_LEVEL',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'constituent_pesticide_herbicide_tclp',
                                        'css_class' => 'constituent_pesticide_herbicide_tclp',
                                        'label' => 'LBL_CONSTITUENT_TCLP',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'constituent_pesticide_herbicide_uom',
                                        'css_class' => 'constituent_pesticide_herbicide_uom',
                                        'label' => 'LBL_CONSTITUENT_UOM',
                                        'type' => 'enum',
                                        'options' => 'uom_list',
                                        'span' => 3,
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'constituent_pesticide_herbicide_not_applicable',
                                        'css_class' => 'constituent_pesticide_herbicide_not_applicable',
                                        'label' => 'LBL_CONSTITUENT_NOT_APPLICABLE',
                                        'type' => 'bool',
                                        'span' => 1,
                                    ),
                                ),
                            ),
                            6 =>
                            array(
                                'name' => 'constituent_other',
                                'type' => 'constituent_other',
                                'label' => 'LBL_CONSTITUENT_OTHER',
                                'span' => 6,
                                'primary_field' => 'constituent_other_epa_waste_code',
                                'related_fields' =>
                                array(
                                    0 => 'constituent_other',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'constituent_other_epa_waste_code',
                                        'css_class' => 'constituent_other_epa_waste_code',
                                        'label' => 'LBL_CONSTITUENT_EPA_WASTE_CODE',
                                        'type' => 'enum',
                                        'options' => 'WP_EPA_CODES',
                                        'span' => 3,
                                        'required' => true,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'constituent_other_regulatory_level',
                                        'css_class' => 'constituent_other_regulatory_level',
                                        'label' => 'LBL_CONSTITUENT_REGULATORY_LEVEL',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'constituent_other_tclp',
                                        'css_class' => 'constituent_other_tclp',
                                        'label' => 'LBL_CONSTITUENT_TCLP',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'constituent_other_uom',
                                        'css_class' => 'constituent_other_uom',
                                        'label' => 'LBL_CONSTITUENT_UOM',
                                        'type' => 'enum',
                                        'options' => 'uom_list',
                                        'span' => 3,
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'constituent_other_not_applicable',
                                        'css_class' => 'constituent_other_not_applicable',
                                        'label' => 'LBL_CONSTITUENT_NOT_APPLICABLE',
                                        'type' => 'bool',
                                        'span' => 1,
                                    ),
                                ),
                            ),
                            7 =>
                            array(
                                'span' => 6,
                            ),
                            8 =>
                            array(
                                'name' => 'quest_hoc_c',
                                'label' => 'LBL_QUEST_HOC_C',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            9 =>
                            array(
                                'name' => 'quest_hoc_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_HOC_C',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            10 =>
                            array(
                                'span' => 2,
                            ),
                            11 =>
                            array(
                                'name' => 'notes_hoc_c',
                                'studio' => 'visible',
                                'label' => 'LBL_NOTES_HOC_C',
                                'dismiss_label' => true,
                                'span' => 10,
                            ),
                            12 =>
                            array(
                                'name' => 'quest_pcb_c',
                                'label' => 'LBL_QUEST_PCB_C',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            13 =>
                            array(
                                'name' => 'quest_pcb_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_PCB_C',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            14 =>
                            array(
                                'span' => 2,
                            ),
                            15 =>
                            array(
                                'name' => 'notes_pcb_c',
                                'studio' => 'visible',
                                'label' => 'LBL_NOTES_PCB_C',
                                'dismiss_label' => true,
                                'span' => 10,
                            ),
                            16 =>
                            array(
                                'span' => 2,
                            ),
                            17 =>
                            array(
                                'name' => 'pcb_present_c',
                                'label' => 'LBL_PCB_PRESENT',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            18 =>
                            array(
                                'name' => 'pcb_present_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_PCB_PRESENT',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 8,
                            ),
                            19 =>
                            array(
                                'name' => 'undisclosed_hazards_c',
                                'label' => 'LBL_UNDISCLOSED_HAZARDS',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            20 =>
                            array(
                                'name' => 'undisclosed_hazards_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_UNDISCLOSED_HAZARDS',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            21 =>
                            array(
                                'span' => 2,
                            ),
                            22 =>
                            array(
                                'name' => 'undisclosed_hazards_comments_c',
                                'studio' => 'visible',
                                'label' => 'LBL_UNDISCLOSED_HAZARDS_COMMENTS',
                                'dismiss_label' => true,
                                'span' => 10,
                            ),
                            23 =>
                            array(
                                'name' => 'quest_usepa_hazardous_waste_c',
                                'label' => 'LBL_QUEST_USEPA_HAZARDOUS_WASTE',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            24 =>
                            array(
                                'name' => 'quest_usepa_hazardous_waste_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_USEPA_HAZARDOUS_WASTE',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            25 =>
                            array(
                                'span' => 2,
                            ),
                            26 =>
                            array(
                                'name' => 'notes_usepa_hazardous_waste_c',
                                'type' => 'waste-code-multienum',
                                'studio' => 'visible',
                                'label' => 'LBL_NOTES_USEPA_HAZARDOUS_WASTE',
                                'dismiss_label' => true,
                                'span' => 10,
                            ),
                            27 =>
                            array(
                                'name' => 'quest_any_state_code_apply_c',
                                'label' => 'LBL_QUEST_ANY_STATE_CODE_APPLY',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            28 =>
                            array(
                                'name' => 'quest_any_state_code_apply_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_ANY_STATE_CODE_APPLY',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            29 =>
                            array(
                                'span' => 2,
                            ),
                            30 =>
                            array(
                                'name' => 'notes_any_state_code_apply_c',
                                'type' => 'enum-same-key-and-value',
                                'studio' => 'visible',
                                'label' => 'LBL_NOTES_ANY_STATE_CODE_APPLY',
                                'dismiss_label' => true,
                                'span' => 10,
                            ),
                            31 =>
                            array(
                                'name' => 'quest_foreign_waste_code_c',
                                'label' => 'LBL_QUEST_FOREIGN_WASTE_CODE',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            32 =>
                            array(
                                'name' => 'quest_foreign_waste_code_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_FOREIGN_WASTE_CODE',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            33 =>
                            array(
                                'span' => 2,
                            ),
                            34 =>
                            array(
                                'name' => 'notes_foreign_waste_code_c',
                                'label' => 'LBL_NOTES_FOREIGN_WASTE_CODE',
                                'dismiss_label' => true,
                                'span' => 10,
                            ),
                            35 =>
                            array(
                                'name' => 'quest_40_cfr_part_c',
                                'label' => 'LBL_QUEST_40_CFR_PART',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            36 =>
                            array(
                                'name' => 'quest_40_cfr_part_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_40_CFR_PART',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            37 =>
                            array(
                                'span' => 2,
                            ),
                            38 =>
                            array(
                                'name' => 'notes_40_cfr_part_1_c',
                                'studio' => 'visible',
                                'label' => 'LBL_NOTES_40_CFR_PART_1',
                                'span' => 10,
                            ),
                            39 =>
                            array(
                                'span' => 2,
                            ),
                            40 =>
                            array(
                                'name' => 'notes_40_cfr_part_2_c',
                                'label' => 'LBL_NOTES_40_CFR_PART_2',
                                'span' => 10,
                            ),
                            41 =>
                            array(
                                'name' => 'quest_universal_waste_c',
                                'label' => 'LBL_QUEST_UNIVERSAL_WASTE',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            42 =>
                            array(
                                'name' => 'quest_universal_waste_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_UNIVERSAL_WASTE',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            43 =>
                            array(
                                'name' => 'quest_is_cesqg_c',
                                'label' => 'LBL_QUEST_IS_CESQG',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            44 =>
                            array(
                                'name' => 'quest_is_cesqg_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_IS_CESQG',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            45 =>
                            array(
                                'name' => 'quest_is_rcra_exempt_commerc_c',
                                'label' => 'LBL_QUEST_IS_RCRA_EXEMPT_COMMERC',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            46 =>
                            array(
                                'name' => 'quest_is_rcra_exempt_commerc_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_IS_RCRA_EXEMPT_COMMERC',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            47 =>
                            array(
                                'name' => 'quest_generate_f006_or_f019_c',
                                'label' => 'LBL_QUEST_GENERATE_F006_OR_F019',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            48 =>
                            array(
                                'name' => 'quest_generate_f006_or_f019_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_GENERATE_F006_OR_F019',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            49 =>
                            array(
                                'name' => 'quest_found_at_40_cfr_c',
                                'label' => 'LBL_QUEST_FOUND_AT_40_CFR',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            50 =>
                            array(
                                'name' => 'quest_found_at_40_cfr_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_FOUND_AT_40_CFR',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            51 =>
                            array(
                                'name' => 'quest_contains_vocs_c',
                                'label' => 'LBL_QUEST_CONTAINS_VOCS',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            52 =>
                            array(
                                'name' => 'quest_contains_vocs_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_CONTAINS_VOCS',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            53 =>
                            array(
                                'name' => 'quest_greater_than_20organic_c',
                                'label' => 'LBL_QUEST_GREATER_THAN_20ORGANIC',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            54 =>
                            array(
                                'name' => 'quest_greater_than_20organic_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_GREATER_THAN_20ORGANIC',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            55 =>
                            array(
                                'name' => 'quest_vapor_pressure_77_c',
                                'label' => 'LBL_QUEST_VAPOR_PRESSURE_77',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            56 =>
                            array(
                                'name' => 'quest_vapor_pressure_77_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_VAPOR_PRESSURE_77',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            57 =>
                            array(
                                'name' => 'quest_cercla_regulated_c',
                                'label' => 'LBL_QUEST_CERCLA_REGULATED',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            58 =>
                            array(
                                'name' => 'quest_cercla_regulated_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_CERCLA_REGULATED',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            59 =>
                            array(
                                'name' => 'quest_one_of_neshap_rule_c',
                                'label' => 'LBL_QUEST_ONE_OF_NESHAP_RULE',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            60 =>
                            array(
                                'name' => 'quest_one_of_neshap_rule_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_ONE_OF_NESHAP_RULE',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                            ),
                            61 =>
                            array(
                                'span' => 2,
                            ),
                            62 =>
                            array(
                                'name' => 'neshap_rules_c',
                                'label' => 'LBL_NESHAP_RULES',
                                'span' => 10,
                            ),
                            63 =>
                            array(
                                'name' => 'quest_is_usepa_hazardous_c',
                                'label' => 'LBL_QUEST_IS_USEPA_HAZARDOUS',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            64 =>
                            array(
                                'name' => 'quest_is_usepa_hazardous_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_IS_USEPA_HAZARDOUS',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                            65 =>
                            array(
                                'span' => 2,
                            ),
                            66 =>
                            array(
                                'name' => 'quest_waste_from_facility_c',
                                'label' => 'LBL_QUEST_WASTE_FROM_FACILITY',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            67 =>
                            array(
                                'name' => 'quest_waste_from_facility_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_WASTE_FROM_FACILITY',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 8,
                            ),
                            68 =>
                            array(
                                'span' => 2,
                            ),
                            69 =>
                            array(
                                'name' => 'quest_total_annual_benzene_c',
                                'label' => 'LBL_QUEST_TOTAL_ANNUAL_BENZENE',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            70 =>
                            array(
                                'name' => 'quest_total_annual_benzene_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_QUEST_TOTAL_ANNUAL_BENZENE',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 8,
                            ),
                            71 =>
                            array(
                                'span' => 3,
                            ),
                            72 =>
                            array(
                                'name' => 'notes_tab_quantity_c',
                                'label' => 'LBL_NOTES_TAB_QUANTITY',
                                'span' => 5,
                            ),
                            73 =>
                            array(
                                'name' => 'notes_tab_quantity_c_1',
                                'type' => 'label',
                                'label' => 'Unit',
                                'default_value' => 'LBL_NOTES_TAB_QUANTITY_1',
                                'noInline' => true,
                                'span' => 4,
                            ),
                            74 =>
                            array(
                                'span' => 3,
                            ),
                            75 =>
                            array(
                                'name' => 'notes_describe_knowledge_c_header_1',
                                'type' => 'label',
                                'default_value' => 'LBL_NOTES_DESCRIBE_KNOWLEDGE_HEADER_1',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 6,
                            ),
                            76 =>
                            array(
                                'name' => 'notes_describe_knowledge_c_header_2',
                                'type' => 'label',
                                'default_value' => 'LBL_NOTES_DESCRIBE_KNOWLEDGE_HEADER_2',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 3,
                            ),
                            77 =>
                            array(
                                'span' => 3,
                            ),
                            78 =>
                            array(
                                'name' => 'notes_describe_knowledge_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_NOTES_DESCRIBE_KNOWLEDGE',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 3,
                            ),
                            79 =>
                            array(
                                'name' => 'notes_describe_knowledge_c',
                                'studio' => 'visible',
                                'label' => 'LBL_NOTES_DESCRIBE_KNOWLEDGE',
                                'dismiss_label' => true,
                                'span' => 6,
                            ),
                            80 =>
                            array(
                                'name' => 'choose_hazards_that_apply_c',
                                'label' => 'LBL_CHOOSE_HAZARDS_THAT_APPLY',
                                'type' => 'multienum-checkbox',
                                'perline' => 4,
                                'inrow' => true,
                                'span' => 12,
                            ),
                        ),
                    ),
                    8 =>
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
                                'name' => 'arizona_special_waste_c',
                                'label' => 'LBL_ARIZONA_SPECIAL_WASTE',
                                'type' => 'radioenum-linear',
                                'dismiss_label' => true,
                                'span' => 2,
                            ),
                            1 =>
                            array(
                                'name' => 'arizona_special_waste_c_1',
                                'type' => 'label',
                                'default_value' => 'LBL_ARIZONA_SPECIAL_WASTE',
                                'dismiss_label' => true,
                                'noInline' => true,
                                'span' => 10,
                                // 'background_color' => '#ebedef',
                            ),
                        ),
                    ),
                    9 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL4',
                        'label' => 'LBL_RECORDVIEW_PANEL4',
                        'columns' => 3,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'proper_shipping_name',
                                'studio' => 'visible',
                                'label' => 'LBL_PROPER_SHIPPING_NAME',
                            ),
                            1 =>
                            array(
                                'name' => 'erg_no',
                                'label' => 'LBL_ERG_NO',
                            ),
                            2 =>
                            array(
                                'name' => 'manifest_additional_info',
                                'label' => 'LBL_MANIFEST_ADDITIONAL_INFO',
                            ),
                            3 =>
                            array(
                            ),
                            4 =>
                            array(
                                'name' => 'transportation_type_c',
                                'label' => 'LBL_TRANSPORTATION_TYPE',
                                'type' => 'radioenum-linear',
                                'style' => 'width: 100%;',
                                'span' => 12,
                            ),
                            5 =>
                            array(
                                'name' => 'shipment_quantity_c',
                                'label' => 'LBL_SHIPMENT_QUANTITY',
                            ),
                            6 =>
                            array(
                                'name' => 'shipment_quantity_bulkliquid_c',
                                'label' => 'LBL_SHIPMENT_QUANTITY_BULKLIQUID',
                            ),
                            7 =>
                            array(
                                'name' => 'shipment_quantity_bulksolid_c',
                                'label' => 'LBL_SHIPMENT_QUANTITY_BULKSOLID',
                            ),
                            8 =>
                            array(
                                'name' => 'storage_capacity_c',
                                'label' => 'LBL_STORAGE_CAPACITY',
                            ),
                            9 =>
                            array(
                            ),
                            10 =>
                            array(
                            ),
                            11 =>
                            array(
                                'name' => 'container_type_c',
                                'label' => 'LBL_CONTAINER_TYPE',
                            ),
                            12 =>
                            array(
                            ),
                            13 =>
                            array(
                            ),
                            14 =>
                            array(
                                'name' => 'shipment_container_type_drum_c',
                                'label' => 'LBL_SHIPMENT_CONTAINER_TYPE_DRUM',
                            ),
                            15 =>
                            array(
                            ),
                            16 =>
                            array(
                            ),
                            17 =>
                            array(
                                'name' => 'shipment_container_type_othe_c',
                                'label' => 'LBL_SHIPMENT_CONTAINER_TYPE_OTHE',
                            ),
                            18 =>
                            array(
                            ),
                            19 =>
                            array(
                            ),
                            20 =>
                            array(
                                'name' => 'special_instructions',
                                'label' => 'LBL_SPECIAL_INSTRUCTIONS',
                            ),
                            21 =>
                            array(
                            ),
                            22 =>
                            array(
                            ),
                        ),
                    ),
                    10 =>
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
                                'name' => 'comments_or_requests_c',
                                'label' => 'LBL_COMMENTS_OR_REQUESTS',
                            ),
                            1 =>
                            array(
                            ),
                        ),
                    ),
                    11 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL10',
                        'label' => 'LBL_RECORDVIEW_PANEL10',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'certificates',
                                'span' => 12,
                            ),
                        ),
                    ),
                    12 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL11',
                        'label' => 'LBL_RECORDVIEW_PANEL11',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'generator_sign_date_c',
                                'label' => 'LBL_GENERATOR_SIGN_DATE',
                                'type' => 'add-an-year',
                            ),
                            1 =>
                            array(
                                'name' => 'profile_expiration_date_c',
                                'label' => 'LBL_PROFILE_EXPIRATION_DATE',
                            ),
                            2 =>
                            array(
                                'name' => 'profile_acceptance_c',
                                'label' => 'LBL_PROFILE_ACCEPTANCE',
                            ),
                            3 =>
                            array(
                                'name' => 'filename',
                                'comment' => 'File name associated with the note (attachment)',
                                'label' => 'LBL_FILENAME',
                            ),
                            4 =>
                            array(
                                'name' => 'commentlog',
                                'displayParams' =>
                                array(
                                    'type' => 'commentlog',
                                    'fields' =>
                                    array(
                                        0 => 'entry',
                                        1 => 'date_entered',
                                        2 => 'created_by_name',
                                    ),
                                    'max_num' => 100,
                                ),
                                'studio' =>
                                array(
                                    'listview' => false,
                                    'recordview' => true,
                                ),
                                'label' => 'LBL_COMMENTLOG',
                                'span' => 12,
                            ),
                        ),
                    ),
                    13 =>
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
                            0 =>
                            array(
                            ),
                            1 =>
                            array(
                            ),
                            2 => 'assigned_user_name',
                            3 => 'team_name',
                            4 =>
                            array(
                                'name' => 'created_by_name',
                                'readonly' => true,
                                'label' => 'LBL_CREATED',
                            ),
                            5 =>
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
                            6 =>
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
                            7 =>
                            array(
                            ),
                            8 =>
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
