<?php

$viewdefs['sales_and_services']['base']['view']['create'] = array(
    'template' => 'record',
    'buttons' => array(
        array(
            'name' => 'cancel_button',
            'type' => 'button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'events' => array(
                'click' => 'button:cancel_button:click',
            ),
        ),
        array(
            'name' => 'restore_button',
            'type' => 'button',
            'label' => 'LBL_RESTORE',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'select',
            'events' => array(
                'click' => 'button:restore_button:click',
            ),
        ),
        array(
            'name' => 'save_button',
            'type' => 'button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'primary' => true,
            'showOn' => 'create',
            'events' => array(
                'click' => 'button:save_button:click',
            ),
        ),
        array(
            'name' => 'duplicate_button',
            'type' => 'button',
            'label' => 'LBL_IGNORE_DUPLICATE_AND_SAVE',
            'primary' => true,
            'showOn' => 'duplicate',
            'events' => array(
                'click' => 'button:save_button:click',
            ),
        ),
        array(
            'name' => 'select_button',
            'type' => 'button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'primary' => true,
            'showOn' => 'select',
            'events' => array(
                'click' => 'button:save_button:click',
            ),
        ),
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
                        'commentlog',
                        'pdf_template_printer_widget',
                        'print_date',
                        // At time of copy we also need these fields to be populated
                        'ac_usepa_id_c',
                        'account_number_c',
                        'account_status_c',
                        'po_required',
                        'billing_address_third_party_name',
                        'billing_address_street_c',
                        'billing_address_city_c',
                        'billing_address_state_c',
                        'billing_address_postalcode_c',
                        'billing_address_country_c',
                        'shipping_address_third_party_name',
                        'shipping_address_street_c',
                        'shipping_address_city_c',
                        'shipping_address_state_c',
                        'shipping_address_postalcode_c',
                        'shipping_address_country_c',
                        'service_site_address_name',
                        'service_site_address_street_c',
                        'service_site_address_city_c',
                        'service_site_address_state_c',
                        'service_site_address_postalcode_c',
                        'service_site_address_country_c',
                        'lat_c',
                        'lon_c',
                        'instructions_notes_c',
                        'account_terms_c',
                        'team_name',
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
//                            3 =>
//                            array(
//                                'name' => 'shipping_address',
//                                'type' => 'fieldset',
//                                'css_class' => 'address',
//                                'label' => 'LBL_SHIPPING_ADDRESS',
//                                'fields' =>
//                                array(
//                                    0 =>
//                                    array(
//                                        'name' => 'shipping_address_third_party_name',
//                                        'css_class' => 'address_state',
//                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_THIRD_PARTY_NAME',
//                                    ),
//                                    1 =>
//                                    array(
//                                        'name' => 'shipping_address_street_c',
//                                        'css_class' => 'address_street',
//                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_STREET',
//                                    ),
//                                    2 =>
//                                    array(
//                                        'name' => 'shipping_address_city_c',
//                                        'css_class' => 'address_city',
//                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_CITY',
//                                    ),
//                                    3 =>
//                                    array(
//                                        'name' => 'shipping_address_state_c',
//                                        'css_class' => 'address_state',
//                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_STATE',
//                                    ),
//                                    4 =>
//                                    array(
//                                        'name' => 'shipping_address_postalcode_c',
//                                        'css_class' => 'address_zip',
//                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
//                                    ),
//                                    5 =>
//                                    array(
//                                        'name' => 'shipping_address_country_c',
//                                        'css_class' => 'address_country',
//                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
//                                    ),
//                                ),
//                            ),
//                            4 =>
//                            array(
//                                'name' => 'service_site_address_c',
//                                'type' => 'fieldset',
//                                'css_class' => 'address',
//                                'label' => 'LBL_SERVICE_SITE_ADDRESS',
//                                'fields' =>
//                                array(
//                                    0 =>
//                                    array(
//                                        'name' => 'service_site_address_name',
//                                        'css_class' => 'address_state',
//                                        'placeholder' => 'LBL_SERVICE_SITE_NAME',
//                                    ),
//                                    1 =>
//                                    array(
//                                        'name' => 'service_site_address_street_c',
//                                        'css_class' => 'address_street',
//                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_STREET',
//                                    ),
//                                    2 =>
//                                    array(
//                                        'name' => 'service_site_address_city_c',
//                                        'css_class' => 'address_city',
//                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_CITY',
//                                    ),
//                                    3 =>
//                                    array(
//                                        'name' => 'service_site_address_state_c',
//                                        'css_class' => 'address_state',
//                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_STATE',
//                                    ),
//                                    4 =>
//                                    array(
//                                        'name' => 'service_site_address_postalcode_c',
//                                        'css_class' => 'address_zip',
//                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_POSTALCODE',
//                                    ),
//                                    5 =>
//                                    array(
//                                        'name' => 'service_site_address_country_c',
//                                        'css_class' => 'address_country',
//                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_COUNTRY',
//                                    ),
//                                ),
//                            ),
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
//                                'name' => 'recurring_info',
//                                'dismiss_label' => true,
//                                'highlight' => true,
//                                'readonly' => true,
//                                'type' => 'info-label',
//                                'span' => 9,
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
//                                        'type' => 'radioenum-end-date-options',
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
//                                        'type' => 'int',
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
//                                        'type' => 'int',
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
//                                        'type' => 'int',
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
//                                        'type' => 'int',
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
        4 =>
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
//                                    0 => 'discount_price',
//                                    1 => 'list_price',
//                                    2 => 'cost_price',
//                                    3 => 'product_list_name_c',
                    ),
                    'span' => 12,
                ),
                1 =>
                array(
                    'name' => 'taxable_c',
                    'label' => 'LBL_TAXABLE',
                ),
            ),
        ),
    ),
    'templateMeta' =>
    array(
        'useTabs' => true,
    ),
);
