<?php

$viewdefs['sales_and_services'] = array(
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
                                    0 => 'commentlog',
                                    1 => 'pdf_template_printer_widget',
                                    2 => 'print_date',
                                    3 => 'ac_usepa_id_c',
                                    4 => 'account_number_c',
                                    5 => 'account_status_c',
                                    6 => 'po_required',
                                    7 => 'billing_address_third_party_name',
                                    8 => 'billing_address_street_c',
                                    9 => 'billing_address_city_c',
                                    10 => 'billing_address_state_c',
                                    11 => 'billing_address_postalcode_c',
                                    12 => 'billing_address_country_c',
                                    13 => 'shipping_address_third_party_name',
                                    14 => 'shipping_address_street_c',
                                    15 => 'shipping_address_city_c',
                                    16 => 'shipping_address_state_c',
                                    17 => 'shipping_address_postalcode_c',
                                    18 => 'shipping_address_country_c',
                                    19 => 'service_site_address_name',
                                    20 => 'service_site_address_street_c',
                                    21 => 'service_site_address_city_c',
                                    22 => 'service_site_address_state_c',
                                    23 => 'service_site_address_postalcode_c',
                                    24 => 'service_site_address_country_c',
                                    25 => 'lat_c',
                                    26 => 'lon_c',
                                    27 => 'instructions_notes_c',
                                    28 => 'account_terms_c',
                                    29 => 'team_name',
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
                                'name' => 'status_c',
                                'studio' => 'visible',
                                'label' => 'LBL_STATUS',
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
                                'name' => 'contacts_sales_and_services_1_name',
                                'label' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_CONTACTS_TITLE',
                                'initial_filter' => 'filterAccountsTemplate',
                                'initial_filter_label' => 'LBL_FILTER_ACCOUNTS_TEMPLATE',
                                'filter_relate' =>
                                array(
                                    'accounts_sales_and_services_1accounts_ida' => 'account_id_cst',
                                ),
                            ),
                            2 => 'assigned_user_name',
                            3 => 'team_name',
                            4 =>
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
                            5 =>
                            array(
                                'name' => 'account_terms_c',
                                'type' => 'account-terms',
                                'label' => 'LBL_ACCOUNT_TERMS',
                            ),
                            6 =>
                            array(
                                'name' => 'on_date_c',
                                'label' => 'LBL_ON_DATE',
                            ),
                            7 =>
                            array(
                                'name' => 'on_time_c',
                                'label' => 'LBL_ON_TIME',
                            ),
                            8 =>
                            array(
                                'name' => 'instructions_notes_c',
                                'studio' => 'visible',
                                'label' => 'LBL_INSTRUCTIONS_NOTES',
                            ),
                            9 =>
                            array(
                                'name' => 'internal_notes_c',
                                'studio' => 'visible',
                                'label' => 'LBL_INTERNAL_NOTES',
                            ),
                            10 =>
                            array(
                                'name' => 'status_c',
                                'label' => 'LBL_STATUS',
                            ),
                            11 =>
                            array(
                                'name' => 'print_status_c',
                                'label' => 'LBL_PRINT_STATUS',
                            ),
                            12 =>
                            array(
                                'name' => 'estimated_rli_total',
                                'label' => 'LBL_ESTIMATED_RLI_TOTAL',
                            ),
                            13 =>
                            array(
                                'name' => 'rli_total_c',
                                'label' => 'LBL_RLI_TOTAL',
                            ),
                            14 =>
                            array(
                                'name' => 'transporter_carrier_c',
                                'type' => 'transporter',
                                'studio' => 'visible',
                                'label' => 'LBL_TRANSPORTER_CARRIER',
                            ),
                            15 =>
                            array(
                                'name' => 'destination_ship_to_c',
                                'studio' => 'visible',
                                'label' => 'LBL_DESTINATION_SHIP_TO',
                            ),
                            16 =>
                            array(
                                'name' => 'sales_and_service_assets_and_objects',
                                'type' => 'multienum-relate',
                                'label' => 'LBL_SALES_AND_SERVICE_ASSETS_AND_OBJECTS',
                                'span' => 12,
                            ),
                        ),
                    ),
                    2 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
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
                                'name' => 'status_c',
                                'label' => 'LBL_STATUS',
                            ),
                            2 =>
                            array(
                                'name' => 'account_terms_c',
                                'label' => 'LBL_ACCOUNT_TERMS',
                            ),
                            3 =>
                            array(
                                'name' => 'payment_status_c',
                                'label' => 'LBL_PAYMENT_STATUS',
                            ),
                            4 =>
                            array(
                                'name' => 'payment_reference_c',
                                'label' => 'LBL_PAYMENT_REFERENCE',
                            ),
                            5 =>
                            array(
                                'name' => 'closing_notes_c',
                                'studio' => 'visible',
                                'label' => 'LBL_CLOSING_NOTES',
                            ),
                            6 =>
                            array(
                                'name' => 'lab_result_c',
                                'studio' => 'visible',
                                'label' => 'LBL_LAB_RESULT',
                            ),
                            7 =>
                            array(
                                'name' => 'sales_and_service_total_c',
                                'label' => 'LBL_SALES_AND_SERVICE_TOTAL',
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
                        ),
                    ),
                    4 =>
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
                            ),
                            1 =>
                            array(
                            ),
                            2 =>
                            array(
                                'name' => 'recurring_start_date_c',
                                'label' => 'LBL_RECURRING_START_DATE',
                            ),
                            3 =>
                            array(
                                'name' => 'timings',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'end_date_option_c',
                                        'label' => 'LBL_END_DATE_OPTION',
                                        'span' => 3,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'grid_start',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'recurring_end_date_c',
                                        'label' => 'LBL_RECURRING_END_DATE',
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'occurrences_c',
                                        'label' => 'LBL_OCCURRENCES',
                                        'span' => 2,
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                            ),
                            4 =>
                            array(
                                'name' => 'occurs_c',
                                'type' => 'radioenum-linear',
                                'style' => 'width: 100%;',
                                'label' => 'LBL_OCCURS',
                            ),
                            5 =>
                            array(
                            ),
                            6 =>
                            array(
                                'name' => 'daily_repeat_on',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span5 record-cell',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'daily_repeats_on_c',
                                        'label' => 'LBL_DAILY_REPEATS_ON',
                                        'span' => 3,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'daily_skip_weekends_c',
                                        'label' => 'LBL_SKIP_WEEKENDS',
                                        'span' => 3,
                                        'exclude_inline' => true,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span4 record-cell',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'filler_field',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'vis_action_hidden',
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'filler_field',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'vis_action_hidden',
                                    ),
                                    7 =>
                                    array(
                                        'name' => 'daily_after_no_of_days_c',
                                        'span' => 2,
                                    ),
                                    8 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                                'span' => 12,
                            ),
                            7 =>
                            array(
                                'name' => 'weekly_repeat_on',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span5 record-cell',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'weekly_repeats_on_c',
                                        'label' => 'LBL_WEEKLY_REPEATS_ON',
                                        'span' => 3,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'weekly_by_day_of_the_week_c',
                                        'label' => 'LBL_BY_DAY_OF_THE_WEEK',
                                        'type' => 'multienum-checkbox',
                                        'style' => 'width: 100%;',
                                        'exclude_inline' => true,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span4 record-cell',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'filler_field',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'vis_action_hidden',
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'filler_field',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'vis_action_hidden',
                                    ),
                                    7 =>
                                    array(
                                        'name' => 'weekly_after_no_of_weeks_c',
                                        'span' => 2,
                                    ),
                                    8 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                                'span' => 12,
                            ),
                            8 =>
                            array(
                                'name' => 'monthly_repeat_on_one',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span5 record-cell',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'monthly_repeats_on_c',
                                        'label' => 'LBL_MONTHLY_REPEATS_ON',
                                        'span' => 3,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span4 record-cell',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'filler_field',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'vis_action_hidden',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'filler_field',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'vis_action_hidden',
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'monthly_after_no_of_months_c',
                                        'span' => 2,
                                    ),
                                    7 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                                'span' => 12,
                            ),
                            9 =>
                            array(
                                'name' => 'monthly_repeat_on_two',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span5 record-cell',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'monthly_on_the_specific_day_of_month_c',
                                        'label' => 'LBL_ON_THE_SPECIFIC_DAY_OF_MONTH',
                                        'type' => 'single-radioenum',
                                        'dependent_radio' => 'monthly_by_day_of_week_on_c',
                                        'span' => 3,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'monthly_skip_weekends_c',
                                        'label' => 'LBL_MONTHLY_SKIP_WEEKENDS',
                                        'span' => 3,
                                        'exclude_inline' => true,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span4 record-cell',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'monthly_specific_day_of_month_c',
                                        'span' => 2,
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                                'span' => 12,
                            ),
                            10 =>
                            array(
                                'name' => 'monthly_repeat_on_three',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span5 record-cell',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'monthly_by_day_of_week_on_c',
                                        'label' => 'LBL_BY_DAY_OF_WEEK_ON',
                                        'type' => 'single-radioenum',
                                        'dependent_radio' => 'monthly_on_the_specific_day_of_month_c',
                                        'span' => 3,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span2 record-cell',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'monthly_week_no_c',
                                        'span' => 2,
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span2 record-cell',
                                    ),
                                    7 =>
                                    array(
                                        'name' => 'monthly_month_day_c',
                                        'span' => 2,
                                    ),
                                    8 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                                'span' => 12,
                            ),
                            11 =>
                            array(
                                'name' => 'yearly_repeat_on_one',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span5 record-cell',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'yearly_repeat_every_year_c',
                                        'label' => 'LBL_YEARLY_REPEAT_EVERY_YEAR',
                                        'span' => 3,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                                'span' => 12,
                            ),
                            12 =>
                            array(
                                'name' => 'yearly_repeat_on_two',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span5 record-cell',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'yearly_on_specific_date_c',
                                        'label' => 'LBL_YEARLY_ON_SPECIFIC_DATE',
                                        'type' => 'single-radioenum',
                                        'dependent_radio' => 'yearly_by_day_of_the_week_c',
                                        'span' => 3,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'yearly_skip_weekends_c',
                                        'label' => 'LBL_YEARLY_SKIP_WEEKENDS',
                                        'span' => 3,
                                        'exclude_inline' => true,
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
                                        'name' => 'yearly_on_specific_month_c',
                                        'span' => 2,
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
                                        'name' => 'yearly_date_of_month_c',
                                        'span' => 2,
                                    ),
                                    9 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                ),
                                'span' => 12,
                            ),
                            13 =>
                            array(
                                'name' => 'yearly_repeat_on_three',
                                'type' => 'fieldset-sas',
                                'inline' => true,
                                'equal_spacing' => true,
                                'show_child_labels' => true,
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span5 record-cell',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'yearly_by_day_of_the_week_c',
                                        'label' => 'LBL_YEARLY_BY_DAY_OF_THE_WEEK',
                                        'type' => 'single-radioenum',
                                        'dependent_radio' => 'yearly_on_specific_date_c',
                                        'span' => 3,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span2 record-cell',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'yearly_week_no_c',
                                        'span' => 2,
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span2 record-cell',
                                    ),
                                    7 =>
                                    array(
                                        'name' => 'yearly_by_day_of_the_week_li_c',
                                        'span' => 2,
                                    ),
                                    8 =>
                                    array(
                                        'name' => 'grid_end',
                                    ),
                                    9 =>
                                    array(
                                        'name' => 'grid_start',
                                        'label' => 'LBL_FILLER',
                                        'css_class' => 'span2 record-cell',
                                    ),
                                    10 =>
                                    array(
                                        'name' => 'yearly_by_day_of_week_month_c',
                                        'span' => 2,
                                    ),
                                    11 =>
                                    array(
                                        'name' => 'grid_end',
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
                        'name' => 'LBL_RECORDVIEW_PANEL5',
                        'label' => 'LBL_RECORDVIEW_PANEL5',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
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
                            1 =>
                            array(
                                'name' => 'svc_type_c',
                                'label' => 'LBL_SVC_TYPE',
                            ),
                            2 =>
                            array(
                                'name' => 'profile_no_c',
                                'label' => 'LBL_PROFILE_NO',
                            ),
                            3 =>
                            array(
                                'name' => 'svc_days_c',
                                'label' => 'LBL_SVC_DAYS',
                            ),
                            4 =>
                            array(
                                'name' => 'quotes_sales_and_services_1_name',
                                'label' => 'LBL_QUOTES_SALES_AND_SERVICES_1_FROM_QUOTES_TITLE',
                            ),
                            5 =>
                            array(
                                'name' => 'contracts_sales_and_services_1_name',
                                'label' => 'LBL_CONTRACTS_SALES_AND_SERVICES_1_FROM_CONTRACTS_TITLE',
                            ),
                        ),
                    ),
                    6 =>
                    array(
                        'newTab' => true,
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
                                'name' => 'audit',
                                'label' => 'Audit',
                                'type' => 'audit-list-field',
                                'relatedModule' => 'sales_and_services',
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
                            1 =>
                            array(
                                'name' => 'taxable_c',
                                'label' => 'LBL_TAXABLE',
                            ),
                            2 =>
                            array(
                            ),
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
