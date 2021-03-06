<?php

$viewdefs['sales_and_services'] = array(
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
                        'type' => 'button',
                        'name' => 'close_drawer_button',
                        'label' => 'LBL_CLOSE_DRAWER_BUTTON_LABEL',
                        'css_class' => 'btn-invisible btn-link',
                        'showOn' => 'view',
                        'events' =>
                        array(
                            'click' => 'button:close_drawer_button:click',
                        ),
                    ),
                    3 =>
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
                                'name' => 'print_paperwork_button',
                                'event' => 'button:print_paperwork_button:click',
                                'label' => 'LBL_PRINT_PAPERWORK',
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
                                'acl_module' => 'sales_and_services',
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
                    4 =>
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
                            1 =>
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'related_fields' =>
                                array(
                                    0 => 'ac_usepa_id_c',
                                    1 => 'account_number_c',
                                    2 => 'account_status_c',
                                    3 => 'po_required',
                                    4 => 'commentlog',
                                    5 => 'revenuelineitems_revenuelineitems_1',
                                    6 => 'revenuelineitems_revenuelineitems_1_right',
                                    7 => 'sales_and_services_revenuelineitems_1',
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
                            4 =>
                            array(
                                'name' => 'sales_and_service_status',
                                'label' => 'LBL_SALES_AND_SERVICE_STATUS_BADGE',
                                'type' => 'sales-and-service-status',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'ss_number',
                                'readonly' => true,
                                'comment' => 'Visual unique identifier',
                                'studio' =>
                                array(
                                    'quickcreate' => false,
                                ),
                                'label' => 'LBL_SS_NUMBER',
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
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'accounts_sales_and_services_1_name',
                                'label' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_ACCOUNTS_TITLE',
                                'type' => 'relate-autopopulate-team-related',
                            ),
                            1 =>
                            array(
                                'name' => 'service_manifest_c',
                                'label' => 'LBL_SERVICE_MANIFEST',
                                'enabled' => true,
                                'id' => 'HT_MANIFEST_ID_C',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'contacts_sales_and_services_1_name',
                                'label' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_CONTACTS_TITLE',
                                'initial_filter' => 'filterAccountsTemplate',
                                'initial_filter_label' => 'LBL_FILTER_ACCOUNTS_TEMPLATE',
                                'filter_relate' =>
                                array(
                                    'accounts_sales_and_services_1accounts_ida' => 'account_id_cst',
                                ),
                            ),
                            3 => 'assigned_user_name',
                            4 => 'team_name',
                            5 =>
                            array(
                                'name' => 'po_number_c',
                                'label' => 'LBL_PO_NUMBER',
                                'initial_filter' => 'filterByAccountId',
                                'initial_filter_label' => 'LBL_FILTER_BY_ACCOUNT_ID',
                                'filter_relate' =>
                                array(
                                    'accounts_sales_and_services_1accounts_ida' => 'account_id_c',
                                ),
                            ),
                            6 =>
                            array(
                                'name' => 'account_terms_c',
                                'label' => 'LBL_ACCOUNT_TERMS',
                            ),
                            7 =>
                            array(
                                'name' => 'on_date_c',
                                'label' => 'LBL_ON_DATE',
                            ),
                            8 =>
                            array(
                                'name' => 'on_time_c',
                                'label' => 'LBL_ON_TIME',
                            ),
                            9 =>
                            array(
                                'name' => 'instructions_notes_c',
                                'studio' => 'visible',
                                'label' => 'LBL_INSTRUCTIONS_NOTES',
                            ),
                            10 =>
                            array(
                                'name' => 'internal_notes_c',
                                'studio' => 'visible',
                                'label' => 'LBL_INTERNAL_NOTES',
                            ),
                            11 =>
                            array(
                                'name' => 'estimated_rli_total',
                                'label' => 'LBL_ESTIMATED_RLI_TOTAL',
                            ),
                            12 =>
                            array(
                                'name' => 'rli_total_c',
                                'label' => 'LBL_RLI_TOTAL',
                            ),
                            13 =>
                            array(
                                'name' => 'transporter_carrier_c',
                                'type' => 'transporter',
                                'studio' => 'visible',
                                'label' => 'LBL_TRANSPORTER_CARRIER',
                            ),
                            14 =>
                            array(
                                'name' => 'destination_ship_to_c',
                                'studio' => 'visible',
                                'label' => 'LBL_DESTINATION_SHIP_TO',
                            ),
                            15 =>
                            array(
                                'name' => 'sales_and_service_assets_and_objects',
                                'type' => 'multienum-relate',
                                'label' => 'LBL_SALES_AND_SERVICE_ASSETS_AND_OBJECTS',
                            ),
//                            16 =>
//                            array(
//                                'name' => 'commentlog',
//                                'displayParams' =>
//                                array(
//                                    'type' => 'commentlog',
//                                    'fields' =>
//                                    array(
//                                        0 => 'entry',
//                                        1 => 'date_entered',
//                                        2 => 'created_by_name',
//                                    ),
//                                    'max_num' => 100,
//                                ),
//                                'studio' =>
//                                array(
//                                    'listview' => false,
//                                    'recordview' => true,
//                                ),
//                                'label' => 'LBL_COMMENTLOG',
//                                'span' => 12,
//                            ),
                        ),
                    ),
                    2 =>
                    array(
                        'name' => 'panel_hidden',
                        'label' => 'LBL_SHOW_MORE',
                        'hide' => true,
                        'columns' => 2,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'description',
                                'span' => 12,
                            ),
                            1 =>
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
                            2 =>
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
                            3 =>
                            array(
                                'name' => 'taxable_c',
                                'label' => 'LBL_TAXABLE',
                            ),
                        ),
                    ),
                    3 =>
                    array(
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'name' => 'panel_recurring',
                        'label' => 'LBL_RECORDVIEW_PANEL6',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => true,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'recurring_sale_c',
                                'label' => 'LBL_RECURRING_SALE',
//                                'span' => 3,
                            ),
                            1 =>
                            array(
                                'name' => 'recurring_start_date_c',
                                'label' => 'LBL_RECURRING_START_DATE',
                            ),
                        ),
                    ),
                    4 =>
                    array(
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'name' => 'panel_completion',
                        'label' => 'LBL_RECORDVIEW_PANEL4',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'complete_date_c',
                                'label' => 'LBL_COMPLETE_DATE',
                            ),
                            1 =>
                            array(
                                'name' => 'payment_status_c',
                                'label' => 'LBL_PAYMENT_STATUS',
                            ),
                            2 =>
                            array(
                                'name' => 'payment_reference_c',
                                'label' => 'LBL_PAYMENT_REFERENCE',
                            ),
                            3 =>
                            array(
                                'name' => 'closing_notes_c',
                                'studio' => 'visible',
                                'label' => 'LBL_CLOSING_NOTES',
                                'span' => 6,
                            ),
                            4 =>
                            array(
                                'name' => 'lab_result_c',
                                'studio' => 'visible',
                                'label' => 'LBL_LAB_RESULT',
                            ),
                            5 =>
                            array(
                                'name' => 'sales_and_service_total_c',
                                'label' => 'LBL_SALES_AND_SERVICE_TOTAL',
                            ),
                        ),
                    ),
                    5 =>
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
                            array(
                                'name' => 'svc_type_c',
                                'label' => 'LBL_SVC_TYPE',
                            ),
                            array(
                                'name' => 'profile_no_c',
                                'label' => 'LBL_PROFILE_NO',
                            ),
                            array(
                                'name' => 'svc_days_c',
                                'label' => 'LBL_SVC_DAYS',
                            ),
                            array(
                                'name' => 'quotes_sales_and_services_1_name',
                                'label' => 'LBL_QUOTES_SALES_AND_SERVICES_1_FROM_QUOTES_TITLE',
                            ),
                            array(
                                'name' => 'contracts_sales_and_services_1_name',
                                'label' => 'LBL_CONTRACTS_SALES_AND_SERVICES_1_FROM_CONTRACTS_TITLE',
                            ),
                            array(
                                'name' => 'sales_and_services_revenuelineitems_1',
                                'type' => 'relate-collection-preview',
                            )
                        ),
                    ),
                ),
                'templateMeta' =>
                array(
                    'useTabs' => true,
                ),
            ),
        ),
    ),
);
