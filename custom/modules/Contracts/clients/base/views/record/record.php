<?php

$viewdefs['Contracts'] = array(
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
                                'acl_module' => 'Manufacturers',
                                'acl_action' => 'create',
                            ),
                            7 =>
                            array(
                                'type' => 'divider',
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
                        ),
                    ),
                    1 =>
                    array(
                        'name' => 'panel_body',
                        'label' => 'LBL_RECORD_BODY',
                        'columns' => 2,
                        'labels' => true,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 => 'reference_code',
                            1 =>
                            array(
                                'name' => 'contract_number_c',
                                'label' => 'LBL_CONTRACT_NUMBER',
                            ),
                            2 => 'account_name',
                            3 => 'status',
                            4 => 'opportunity_name',
                            5 => 'start_date',
                            6 => 'type_name',
                            7 => 'end_date',
                            8 =>
                            array(
                                'name' => 'total_contract_value',
                                'convertToBase' => true,
                                'showTransactionalAmount' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'related_fields' =>
                                array(
                                    0 => 'currency_id',
                                    1 => 'base_rate',
                                ),
                            ),
                            9 => 'contract_term',
                            10 => 'expiration_notice',
                            11 => 'company_signed_date',
                            12 => 'description',
                            13 => 'customer_signed_date',
                            14 =>
                            array(
                                'name' => 'tag',
                                'span' => 6,
                            ),
                            15 =>
                            array(
                                'name' => 'contract_type_c',
                                'label' => 'LBL_CONTRACT_TYPE',
                                'span' => 6,
                            ),
                        ),
                    ),
                    2 =>
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
                            array(
                                'name' => 'accounts_contact_role_widget',
                                'type' => 'accounts_contact_role_widget',
                                'dismiss_label' => true,
                                'span' => 12,
                                'related_fields' => array(
                                    'accounts_contact_role_widget',
                                ),
                                'fields' => array(
                                    array(
                                        'name' => 'accounts_contact_role_widget_name',
                                        'css_class' => 'accounts_contact_role_widget_name',
                                        'label' => 'LBL_ACCOUNTS_CONTACT_ROLE_WIDGET_ACCOUNT',
                                        'rname' => 'name',
                                        'type' => 'relate',
                                        'id_name' => 'accounts_contact_role_widget_name_id',
                                        'module' => 'Accounts',
                                        'link' => true,
                                        'span' => 4,
                                        'sortable' => false,
                                    ),
                                    array(
                                        'name' => 'accounts_contact_role_widget_contact_name',
                                        'css_class' => 'accounts_contact_role_widget_contact_name',
                                        'label' => 'LBL_ACCOUNTS_CONTACT_ROLE_WIDGET_CONTACT_NAME',
                                        'rname' => 'name',
                                        'type' => 'relate',
                                        'id_name' => 'accounts_contact_role_widget_contact_name_id',
                                        'module' => 'Contacts',
                                        'link' => true,
                                        'span' => 4,
                                        'sortable' => false,
                                    ),
                                    array(
                                        'name' => 'accounts_contact_role_widget_role',
                                        'css_class' => 'accounts_contact_role_widget_role',
                                        'label' => 'LBL_ACCOUNTS_CONTACT_ROLE_WIDGET_ROLE',
                                        'type' => 'enum',
                                        'options' => 'accounts_contact_role_widget_list',
                                        'span' => 3
                                    ),
                                )
                            ),
                        ),
                    ),
                    3 =>
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
                                'name' => 'contract_specification',
                                'type' => 'contract_specification',
                                'dismiss_label' => true,
                                'related_fields' =>
                                array(
                                    0 => 'contract_specification',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'contract_specification_name',
                                        'css_class' => 'contract_specification_name',
                                        'label' => 'LBL_CONTRACT_SPECIFICATION_NAME',
                                        'type' => 'text',
                                        'span' => 6,
                                        'required' => true,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'contract_specification_text_details',
                                        'css_class' => 'contract_specification_text_details',
                                        'label' => 'LBL_CONTRACT_SPECIFICATION_TEXT_DETAILS',
                                        'type' => 'text',
                                        'span' => 5,
                                    ),
                                ),
                                'span' => 12,
                            ),
                        ),
                    ),
                    4 =>
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
                                'name' => 'product_specification_c',
                                'label' => 'LBL_PRODUCT_SPECIFICATION',
                            ),
                            1 =>
                            array(
                                'name' => 'quantity_c',
                                'label' => 'LBL_QUANTITY',
                            ),
                            2 =>
                            array(
                                'name' => 'tolerance_c',
                                'label' => 'LBL_TOLERANCE',
                            ),
                            3 =>
                            array(
                                'name' => 'delivery_location_c',
                                'label' => 'LBL_DELIVERY_LOCATION',
                            ),
                            4 =>
                            array(
                                'name' => 'mode_of_transport_c',
                                'label' => 'LBL_MODE_OF_TRANSPORT',
                            ),
                            5 =>
                            array(
                                'name' => 'delivery_period_c',
                                'label' => 'LBL_DELIVERY_PERIOD',
                            ),
                            6 =>
                            array(
                                'name' => 'delivery_term_c',
                                'label' => 'LBL_DELIVERY_TERM',
                            ),
                            7 =>
                            array(
                                'name' => 'pricing_details_c',
                                'label' => 'LBL_PRICING_DETAILS',
                            ),
                            8 =>
                            array(
                                'name' => 'pricing_period_c',
                                'label' => 'LBL_PRICING_PERIOD',
                            ),
                            9 =>
                            array(
                                'name' => 'quantity_determination_c',
                                'label' => 'LBL_QUANTITY_DETERMINATION',
                            ),
                            10 =>
                            array(
                                'name' => 'quality_determination_c',
                                'label' => 'LBL_QUALITY_DETERMINATION',
                            ),
                            11 =>
                            array(
                                'name' => 'pay_term_c',
                                'label' => 'LBL_PAY_TERM',
                            ),
                            12 =>
                            array(
                                'name' => 'credit_support_c',
                                'label' => 'LBL_CREDIT_SUPPORT',
                            ),
                            13 =>
                            array(
                            ),
                            14 =>
                            array(
                                'name' => 'inspection_c',
                                'studio' => 'visible',
                                'label' => 'LBL_INSPECTION',
                            ),
                            15 =>
                            array(
                            ),
                            16 =>
                            array(
                                'name' => 'miscellaneous_provisions_c',
                                'studio' => 'visible',
                                'label' => 'LBL_MISCELLANEOUS_PROVISIONS',
                            ),
                            17 =>
                            array(
                            ),
                            18 =>
                            array(
                                'name' => 'remarks_c',
                                'studio' => 'visible',
                                'label' => 'LBL_REMARKS',
                            ),
                            19 =>
                            array(
                            ),
                        ),
                    ),
                    5 =>
                    array(
                        'name' => 'panel_hidden',
                        'label' => 'LBL_RECORD_SHOWMORE',
                        'hide' => true,
                        'columns' => 2,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 => 'assigned_user_name',
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
                            2 => 'team_name',
                            3 =>
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
                ),
                'templateMeta' =>
                array(
                    'useTabs' => false,
                ),
            ),
        ),
    ),
);
