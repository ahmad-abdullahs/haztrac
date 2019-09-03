<?php

$module_name = 'PNL_Permits_Licenses';
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
                                'acl_module' => 'PNL_Permits_Licenses',
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
                        'name' => 'LBL_RECORDVIEW_PANEL1',
                        'label' => 'LBL_RECORDVIEW_PANEL1',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'license_preview_c',
                                'label' => 'LBL_LICENSE_PREVIEW',
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
                            0 => 'category_id',
                            1 => 'subcategory_id',
                            2 =>
                            array(
                                'name' => 'pnl_permits_licenses_accounts_name',
                            ),
                            3 =>
                            array(
                                'name' => 'issuing_acount_c',
                                'studio' => 'visible',
                                'label' => 'LBL_ISSUING_ACOUNT',
                            ),
                            4 =>
                            array(
                                'name' => 'status_id',
                                'label' => 'LBL_DOC_STATUS',
                            ),
                            5 =>
                            array(
                                'name' => 'id_number_c',
                                'label' => 'LBL_ID_NUMBER',
                            ),
                            6 =>
                            array(
                                'name' => 'issuing_date_c',
                                'label' => 'LBL_ISSUING_DATE',
                            ),
                            7 =>
                            array(
                                'name' => 'exp_date',
                                'label' => 'LBL_DOC_EXP_DATE',
                            ),
                            8 =>
                            array(
                                'name' => 'days_prior_renewal_c',
                                'label' => 'LBL_DAYS_PRIOR_RENEWAL',
                            ),
                            9 =>
                            array(
                                'name' => 'renewal_date_c',
                                'label' => 'LBL_RENEWAL_DATE',
                            ),
                            10 =>
                            array(
                                'name' => 'renewal_instructions_c',
                                'studio' => 'visible',
                                'label' => 'LBL_RENEWAL_INSTRUCTIONS',
                                'span' => 12,
                            ),
                            11 =>
                            array(
                                'name' => 'uploadfile',
                                'populate_list' =>
                                array(
                                    0 => 'document_name',
                                ),
                            ),
                            12 =>
                            array(
                                'name' => 'care_of_party_c',
                                'studio' => 'visible',
                                'label' => 'LBL_CARE_OF_PARTY',
                            ),
                            13 =>
                            array(
                                'name' => 'description',
                                'span' => 12,
                            ),
                        ),
                    ),
                    3 =>
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
                            1 =>
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
                            2 => 'assigned_user_name',
                            3 => 'team_name',
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
                ),
                'templateMeta' =>
                array(
                    'useTabs' => false,
                ),
            ),
        ),
    ),
);
