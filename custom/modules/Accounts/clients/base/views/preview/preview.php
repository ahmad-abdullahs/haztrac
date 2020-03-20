<?php

$viewdefs['Accounts'] = array(
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
                                'acl_module' => 'Accounts',
                                'acl_action' => 'create',
                            ),
                            7 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:historical_summary_button:click',
                                'name' => 'historical_summary_button',
                                'label' => 'LBL_HISTORICAL_SUMMARY',
                                'acl_action' => 'view',
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
                        'label' => 'LBL_PANEL_HEADER',
                        'header' => true,
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
                            ),
                            2 =>
                            array(
                                'name' => 'favorite',
                                'label' => 'LBL_FAVORITE',
                                'type' => 'favorite',
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
                                'name' => 'third_party',
                                'label' => 'LBL_THIRD_PARTY',
                                'type' => 'third-party',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'account_status',
                                'label' => 'LBL_ACCOUNT_BADGE_STATUS',
                                'type' => 'account-status',
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
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'account_type_cst_c',
                                'label' => 'LBL_ACCOUNT_TYPE_CST',
                                'type' => 'account-type-multienum',
                            ),
                            1 =>
                            array(
                                'name' => 'tag',
                                'tabindex' => '2',
                            ),
                            2 =>
                            array(
                                'name' => 'billing_address',
                                'type' => 'fieldset',
                                'css_class' => 'address',
                                'label' => 'LBL_BILLING_ADDRESS',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'billing_address_third_party_name',
                                        'css_class' => 'address_state',
                                        'placeholder' => 'LBL_BILLING_ADDRESS_THIRD_PARTY_NAME',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'billing_address_street',
                                        'css_class' => 'address_street',
                                        'placeholder' => 'LBL_BILLING_ADDRESS_STREET',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'billing_address_city',
                                        'css_class' => 'address_city',
                                        'placeholder' => 'LBL_BILLING_ADDRESS_CITY',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'billing_address_state',
                                        'css_class' => 'address_state',
                                        'placeholder' => 'LBL_BILLING_ADDRESS_STATE',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'billing_address_postalcode',
                                        'css_class' => 'address_zip',
                                        'placeholder' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'billing_address_country',
                                        'css_class' => 'address_country',
                                        'placeholder' => 'LBL_BILLING_ADDRESS_COUNTRY',
                                    ),
                                ),
                                'tabindex' => '11',
                            ),
                            3 =>
                            array(
                                'name' => 'shipping_address',
                                'type' => 'fieldset',
                                'css_class' => 'address',
                                'label' => 'LBL_SHIPPING_ADDRESS',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'shipping_address_third_party_name',
                                        'css_class' => 'address_state',
                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_THIRD_PARTY_NAME',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'shipping_address_street',
                                        'css_class' => 'address_street',
                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_STREET',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'shipping_address_city',
                                        'css_class' => 'address_city',
                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_CITY',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'shipping_address_state',
                                        'css_class' => 'address_state',
                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_STATE',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'shipping_address_postalcode',
                                        'css_class' => 'address_zip',
                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'shipping_address_country',
                                        'css_class' => 'address_country',
                                        'placeholder' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'copy',
                                        'label' => 'NTC_COPY_BILLING_ADDRESS',
                                        'type' => 'copy',
                                        'mapping' =>
                                        array(
                                            'billing_address_street' => 'shipping_address_street',
                                            'billing_address_city' => 'shipping_address_city',
                                            'billing_address_state' => 'shipping_address_state',
                                            'billing_address_postalcode' => 'shipping_address_postalcode',
                                            'billing_address_country' => 'shipping_address_country',
                                        ),
                                    ),
                                ),
                                'tabindex' => '12',
                            ),
                            4 =>
                            array(
                                'name' => 'physical_address_account_name',
                                'placeholder' => 'LBL_PHYSICAL_ADDRESS_ACCOUNT_NAME',
                            ),
                            5 =>
                            array(
                            ),
                            6 =>
                            array(
                                'name' => 'parent_name',
                                'tabindex' => '8',
                            ),
                            7 =>
                            array(
                                'name' => 'ac_usepa_id_c',
                                'label' => 'LBL_AC_USEPA_ID',
                            ),
                            8 =>
                            array(
                                'name' => 'website',
                                'tabindex' => '6',
                            ),
                            9 =>
                            array(
                                'name' => 'phone_office',
                                'tabindex' => '3',
                            ),
                            10 =>
                            array(
                                'name' => 'assigned_user_name',
                                'tabindex' => '13',
                            ),
                            11 =>
                            array(
                                'name' => 'phone_alternate',
                                'label' => 'LBL_PHONE_ALT',
                                'tabindex' => '4',
                            ),
                            12 =>
                            array(
                                'name' => 'team_name',
                                'tabindex' => '14',
                            ),
                            13 =>
                            array(
                                'name' => 'phone_fax',
                                'tabindex' => '5',
                            ),
                        ),
                    ),
                    2 =>
                    array(
                        'newTab' => true,
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
                                'name' => 'account_status_c',
                                'label' => 'LBL_ACCOUNT_STATUS',
                            ),
                            1 =>
                            array(
                            ),
                            2 =>
                            array(
                                'name' => 'account_number_c',
                                'label' => 'LBL_ACCOUNT_NUMBER',
                            ),
                            3 =>
                            array(
                                'name' => 'email',
                                'tabindex' => '7',
                            ),
                            4 =>
                            array(
                                'name' => 'service_level',
                            ),
                            5 =>
                            array(
                                'name' => 'account_terms_c',
                                'label' => 'LBL_ACCOUNT_TERMS',
                            ),
                            6 =>
                            array(
                                'name' => 'hour_operations_c',
                                'label' => 'LBL_HOUR_OPERATIONS',
                            ),
                            7 =>
                            array(
                                'name' => 'po_required',
                                'studio' => 'visible',
                                'label' => 'LBL_PO_REQUIRED',
                            ),
                            8 =>
                            array(
                            ),
                            9 =>
                            array(
                                'name' => 'different_service_site_c',
                                'label' => 'LBL_DIFFERENT_SERVICE_SITE',
                            ),
                            10 =>
                            array(
                                'name' => 'service_instruction_c',
                                'studio' => 'visible',
                                'label' => 'LBL_SERVICE_INSTRUCTION',
                            ),
                            11 =>
                            array(
                                'name' => 'service_site_address_c',
                                'type' => 'fieldset',
                                'css_class' => 'address',
                                'label' => 'LBL_SERVICE_SITE_ADDRESS',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'service_site_address_name',
                                        'css_class' => 'address_state',
                                        'placeholder' => 'LBL_SERVICE_SITE_NAME',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'service_site_address_street_c',
                                        'css_class' => 'address_street',
                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_STREET',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'service_site_address_city_c',
                                        'css_class' => 'address_city',
                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_CITY',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'service_site_address_state_c',
                                        'css_class' => 'address_state',
                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_STATE',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'service_site_address_postalcode_c',
                                        'css_class' => 'address_zip',
                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_POSTALCODE',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'service_site_address_country_c',
                                        'css_class' => 'address_country',
                                        'placeholder' => 'LBL_SERVICE_SITE_ADDRESS_COUNTRY',
                                    ),
                                ),
                            ),
                            12 =>
                            array(
                                'name' => 'hint_account_industry_c',
                                'label' => 'LBL_HINT_COMPANY_INDUSTRY',
                            ),
                            13 =>
                            array(
                                'name' => 'hint_account_industry_tags_c',
                                'label' => 'LBL_HINT_COMPANY_INDUSTRY_TAGS',
                            ),
                        ),
                    ),
                    3 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL5',
                        'label' => 'LBL_RECORDVIEW_PANEL5',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'rail_cif_num_c',
                                'label' => 'LBL_RAIL_CIF_NUM',
                            ),
                            1 =>
                            array(
                                'name' => 'rail_track_num_c',
                                'label' => 'LBL_RAIL_TRACK_NUM',
                            ),
                            2 =>
                            array(
                                'name' => 'rail_served_c',
                                'label' => 'LBL_RAIL_SERVED',
                            ),
                            3 =>
                            array(
                            ),
                            4 =>
                            array(
                                'name' => 'rail_address_street_c',
                                'studio' => 'visible',
                                'label' => 'LBL_RAIL_ADDRESS_STREET',
                            ),
                            5 =>
                            array(
                                'name' => 'rail_notes_c',
                                'studio' => 'visible',
                                'label' => 'LBL_RAIL_NOTES',
                            ),
                        ),
                    ),
                    4 =>
                    array(
                        'name' => 'panel_hidden',
                        'label' => 'LBL_RECORD_SHOWMORE',
                        'hide' => true,
                        'columns' => 2,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'industry',
                                'tabindex' => '9',
                            ),
                            1 =>
                            array(
                            ),
                            2 =>
                            array(
                                'name' => 'legal_business_name_c',
                                'label' => 'LBL_LEGAL_BUSINESS_NAME',
                            ),
                            3 =>
                            array(
                                'name' => 'ein_taxid_c',
                                'label' => 'LBL_EIN_TAXID',
                            ),
                            4 =>
                            array(
                                'name' => 'company_scac_code_c',
                                'label' => 'LBL_COMPANY_SCAC_CODE',
                            ),
                            5 =>
                            array(
                                'name' => 'contract_name_c',
                                'label' => 'LBL_CONTRACT_NAME',
                            ),
                            6 => 'ownership',
                            7 =>
                            array(
                                'name' => 'parent_company_c',
                                'studio' => 'visible',
                                'label' => 'LBL_PARENT_COMPANY',
                            ),
                            8 =>
                            array(
                                'name' => 'description',
                                'span' => 12,
                            ),
                            9 =>
                            array(
                                'name' => 'hint_account_fiscal_year_end_c',
                                'label' => 'LBL_HINT_COMPANY_FISCAL_YEAR_END',
                            ),
                            10 => 'ticker_symbol',
                            11 => 'annual_revenue',
                            12 => 'employees',
                            13 => 'sic_code',
                            14 =>
                            array(
                                'name' => 'hint_account_naics_code_lbl_c',
                                'label' => 'LBL_HINT_COMPANY_NAICS_CODE_LABEL',
                            ),
                            15 =>
                            array(
                                'name' => 'duns_num',
                                'readonly' => true,
                            ),
                            16 =>
                            array(
                            ),
                            17 =>
                            array(
                                'name' => 'twitter',
                            ),
                            18 =>
                            array(
                                'name' => 'hint_account_facebook_handle_c',
                                'label' => 'LBL_HINT_COMPANY_FACEBOOK',
                            ),
                            19 =>
                            array(
                                'name' => 'role_assigned_c',
                                'label' => 'LBL_ROLE_ASSIGNED',
                                'span' => 12,
                            ),
                        ),
                    ),
                    5 =>
                    array(
                        'newTab' => true,
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
