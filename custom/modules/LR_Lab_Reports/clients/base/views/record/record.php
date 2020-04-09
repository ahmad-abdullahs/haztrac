<?php

$viewdefs['LR_Lab_Reports'] = array(
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
                                'acl_module' => 'LR_Lab_Reports',
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
                            10 =>
                            array(
                                'type' => 'divider',
                            ),
                            11 =>
                            array(
                                'type' => 'report-preview',
                                'label' => 'LBL_REPORT_PREVIEW',
                                'acl_action' => 'view',
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
                            ),
                            1 =>
                            array(
                                'name' => 'document_name',
                                'related_fields' =>
                                array(
                                    0 => 'commentlog',
                                ),
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
                        'newTab' => true,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL0',
                        'label' => 'LBL_RECORDVIEW_PANEL0',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                        ),
                    ),
                    2 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL1',
                        'label' => 'LBL_RECORDVIEW_PANEL1',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'lab_report_preview_c',
                                'label' => 'LBL_LAB_REPORT_PREVIEW',
                                'span' => 12,
                            ),
                        ),
                    ),
                    3 =>
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
                                'name' => 'sample_id_number_c',
                                'label' => 'LBL_SAMPLE_ID_NUMBER',
                                'tabindex' => '30',
                                'readonly' => true,
                            ),
                            1 =>
                            array(
                                'name' => 'status_id',
                                'label' => 'LBL_DOC_STATUS',
                                'tabindex' => '3',
                            ),
                            2 =>
                            array(
                                'name' => 'accounts_lr_lab_reports_1_name',
                                'tabindex' => '9',
                                'type' => 'advance-relate',
                                'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_1_FROM_ACCOUNTS_TITLE_CST',
                            ),
                            3 =>
                            array(
                                'name' => 'accounts_lr_lab_reports_2_name',
                                'tabindex' => '10',
                                'type' => 'advance-relate',
                                'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_2_FROM_ACCOUNTS_TITLE_CST',
                            ),
                            4 =>
                            array(
                                'name' => 'accounts_lr_lab_reports_3_name',
                                'studio' => 'visible',
                                'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_ACCOUNTS_TITLE_CST',
                                'type' => 'advance-relate',
                            ),
                            5 =>
                            array(
                                'name' => 'generator_c',
                                'studio' => 'visible',
                                'label' => 'LBL_GENERATOR',
                            ),
                            6 =>
                            array(
                                'name' => 'project_name_c',
                                'label' => 'LBL_PROJECT_NAME',
                                'tabindex' => '2',
                            ),
                            7 =>
                            array(
                                'name' => 'other_ref_number_c',
                                'label' => 'LBL_OTHER_REF_NUMBER',
                                'tabindex' => '11',
                            ),
                            8 =>
                            array(
                                'name' => 'commodity_c',
                                'label' => 'LBL_COMMODITY',
                                'tabindex' => '4',
                            ),
                            9 =>
                            array(
                                'name' => 'project_lr_lab_reports_1_name',
                            ),
                            10 =>
                            array(
                                'name' => 'project_description_c',
                                'studio' => 'visible',
                                'label' => 'LBL_PROJECT_DESCRIPTION',
                            ),
                            11 =>
                            array(
                                'name' => 'object_number_c',
                                'label' => 'LBL_OBJECT_NUMBER',
                                'tabindex' => '5',
                            ),
                            12 =>
                            array(
                                'name' => 'assigned_user_name',
                                'tabindex' => '13',
                            ),
                            13 =>
                            array(
                                'name' => 'team_name',
                                'tabindex' => '14',
                            ),
                        ),
                    ),
                    4 =>
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
                                'name' => 'multi_files',
                                'label' => 'Attachments',
                                'dismiss_label' => true,
                                'type' => 'multi_file_widget',
                                'linkField' => 'lr_lab_reports_mv_attachments',
                                'relatedModule' => 'mv_Attachments',
                                'columns' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'uploadfile',
                                        'label' => 'LBL_FILE_UPLOAD',
                                        'type' => 'file',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'category_id',
                                        'type' => 'enum',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'lab_ref_number',
                                        'type' => 'text',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'analysis_date',
                                        'type' => 'date',
                                    ),
                                ),
                                'span' => 12,
                            ),
                        ),
                    ),
                    5 =>
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
                                'name' => 'sample_date_time_c',
                                'label' => 'LBL_SAMPLE_DATE_TIME',
                                'tabindex' => '6',
                            ),
                            1 =>
                            array(
                                'name' => 'sent_via_c',
                                'label' => 'LBL_SENT_VIA',
                                'tabindex' => '7',
                            ),
                            2 =>
                            array(
                                'name' => 'sample_size_c',
                                'label' => 'LBL_SAMPLE_SIZE',
                            ),
                            3 =>
                            array(
                                'name' => 'sample_physical_state_c',
                                'label' => 'LBL_SAMPLE_PHYSICAL_STATE',
                            ),
                            4 =>
                            array(
                            ),
                            5 =>
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
                                'name' => 'lr_lab_reports_templates_lr_lab_reports_1_name',
                            ),
                            1 =>
                            array(
                            ),
                            2 =>
                            array(
                                'name' => 'lab_analysis_c',
                                'label' => 'LBL_LAB_ANALYSIS',
                                'span' => 12,
                            ),
                            3 =>
                            array(
                                'name' => 'analysis_metals_c',
                                'label' => 'LBL_ANALYSIS_METALS',
                                'span' => 12,
                            ),
                            4 =>
                            array(
                                'name' => 'special_instructions_c',
                                'studio' => 'visible',
                                'label' => 'LBL_SPECIAL_INSTRUCTIONS',
                                'tabindex' => '11',
                            ),
                            5 =>
                            array(
                                'name' => 'instructions_c',
                                'studio' => 'visible',
                                'label' => 'LBL_INSTRUCTIONS',
                                'tabindex' => '12',
                            ),
                        ),
                    ),
                    7 =>
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
                                'name' => 'description',
                                'tabindex' => '15',
                                'span' => 6,
                            ),
                            1 =>
                            array(
                                'name' => 'tag',
                                'tabindex' => '27',
                                'span' => 6,
                            ),
                            2 =>
                            array(
                                'name' => 'wpm_waste_profile_module_lr_lab_reports_name',
                            ),
                            3 =>
                            array(
                                'name' => 'manifests',
                                'type' => 'manifests',
                                'label' => 'LBL_MANIFESTS',
                                'dismiss_label' => true,
                                'tabindex' => '10',
                            ),
                            4 =>
                            array(
                                'name' => 'date_modified_by',
                                'readonly' => true,
                                'inline' => true,
                                'type' => 'fieldset',
                                'label' => 'LBL_DATE_MODIFIED',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'date_modified',
                                    ),
                                    1 =>
                                    array(
                                        'type' => 'label',
                                        'default_value' => 'LBL_BY',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'modified_by_name',
                                    ),
                                ),
                            ),
                            5 =>
                            array(
                                'name' => 'date_entered_by',
                                'readonly' => true,
                                'inline' => true,
                                'type' => 'fieldset',
                                'label' => 'LBL_DATE_ENTERED',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'date_entered',
                                    ),
                                    1 =>
                                    array(
                                        'type' => 'label',
                                        'default_value' => 'LBL_BY',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'created_by_name',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    8 =>
                    array(
                        'newTab' => true,
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
                                'name' => 'audit',
                                'label' => 'Audit',
                                'type' => 'audit-list-field',
                                'relatedModule' => 'LR_Lab_Reports',
                                'readonly' => true,
                                'columns' =>
                                array(
                                    0 =>
                                    array(
                                        'type' => 'field-name',
                                        'name' => 'field_name',
                                        'label' => 'Field',
                                        'sortable' => true,
                                        'width' => '20%',
                                    ),
                                    1 =>
                                    array(
                                        'type' => 'base',
                                        'name' => 'before',
                                        'label' => 'Old Value',
                                        'sortable' => false,
                                        'width' => '20%',
                                    ),
                                    2 =>
                                    array(
                                        'type' => 'base',
                                        'name' => 'after',
                                        'label' => 'New Value',
                                        'sortable' => false,
                                        'width' => '20%',
                                    ),
                                    3 =>
                                    array(
                                        'type' => 'base',
                                        'name' => 'created_by_username',
                                        'label' => 'Changed By',
                                        'sortable' => true,
                                        'width' => '10%',
                                    ),
                                    4 =>
                                    array(
                                        'type' => 'source',
                                        'name' => 'source',
                                        'label' => 'Source',
                                        'sortable' => false,
                                        'width' => '10%',
                                        'module' => 'Users',
                                        'link' => true,
                                    ),
                                    5 =>
                                    array(
                                        'type' => 'datetimecombo',
                                        'name' => 'date_created',
                                        'label' => 'Change Date',
                                        'options' => 'date_range_search_dom',
                                        'sortable' => true,
                                        'width' => '20%',
                                    ),
                                ),
                                'relatedFields' =>
                                array(
                                ),
                                'allowedFieldList' =>
                                array(
                                ),
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
