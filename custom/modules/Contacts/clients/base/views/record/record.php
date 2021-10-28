<?php

$viewdefs['Contacts'] = array(
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
                                'type' => 'manage-subscription',
                                'name' => 'manage_subscription_button',
                                'label' => 'LBL_MANAGE_SUBSCRIPTIONS',
                                'showOn' => 'view',
                                'value' => 'edit',
                            ),
                            6 =>
                            array(
                                'type' => 'vcard',
                                'name' => 'vcard_button',
                                'label' => 'LBL_VCARD_DOWNLOAD',
                                'acl_action' => 'edit',
                            ),
                            7 =>
                            array(
                                'type' => 'divider',
                            ),
                            8 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:find_duplicates_button:click',
                                'name' => 'find_duplicates',
                                'label' => 'LBL_DUP_MERGE',
                                'acl_action' => 'edit',
                            ),
                            9 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:duplicate_button:click',
                                'name' => 'duplicate_button',
                                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                                'acl_module' => 'Contacts',
                                'acl_action' => 'create',
                            ),
                            10 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:historical_summary_button:click',
                                'name' => 'historical_summary_button',
                                'label' => 'LBL_HISTORICAL_SUMMARY',
                                'acl_action' => 'view',
                            ),
                            11 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:audit_button:click',
                                'name' => 'audit_button',
                                'label' => 'LNK_VIEW_CHANGE_LOG',
                                'acl_action' => 'view',
                            ),
                            12 =>
                            array(
                                'type' => 'contact-info-snapshot',
                                'label' => 'LBL_CONTACT_INFO_SNAPSHOT',
                                'acl_action' => 'view',
                            ),
                            13 =>
                            array(
                                'type' => 'divider',
                            ),
                            14 =>
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
                            ),
                            1 =>
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'dismiss_label' => true,
                                'type' => 'fullname',
                                'fields' =>
                                array(
                                    0 => 'salutation',
                                    1 => 'first_name',
                                    2 => 'last_name',
                                ),
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
                                'name' => 'completename_c',
                                'label' => 'LBL_COMPLETENAME',
                            ),
                            1 =>
                            array(
                                'name' => 'phonetic_name_c',
                                'label' => 'LBL_PHONETIC_NAME',
                            ),
                            2 => 'title',
                            3 => 'phone_mobile',
                            4 => 'department',
                            5 => 'phone_work',
                            6 => 'do_not_call',
                            7 => 'phone_fax',
                            8 =>
                            array(
                                'name' => 'accounts_and_roles_widget',
                                'type' => 'accounts_and_roles_widget',
                                'dismiss_label' => true,
                                'related_fields' =>
                                array(
                                    0 => 'accounts_and_roles_widget',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'accounts_and_roles_widget_name',
                                        'css_class' => 'accounts_and_roles_widget_name',
                                        'label' => 'LBL_ACCOUNTS_AND_ROLES_WIDGET_ACCOUNT',
                                        'rname' => 'name',
                                        'type' => 'relate',
                                        'id_name' => 'accounts_and_roles_widget_name_id',
                                        'module' => 'Accounts',
                                        'link' => true,
                                        'span' => 5,
                                        'sortable' => false,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'accounts_and_roles_widget_role',
                                        'css_class' => 'accounts_and_roles_widget_role',
                                        'label' => 'LBL_ACCOUNTS_AND_ROLES_WIDGET_ROLE',
                                        'type' => 'enum',
                                        'options' => 'contact_role_list',
                                        'span' => 4,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'accounts_and_roles_widget_add_role',
                                        'css_class' => 'pull-left addOption',
                                        'label' => '➕',
                                        'type' => 'button',
                                        'groupname' => 'add_role',
                                        'dismiss_label' => true,
                                        'span' => 1,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'accounts_and_roles_widget_primary_account',
                                        'css_class' => 'accounts_and_roles_widget_name_primary_account',
                                        'label' => 'LBL_ACCOUNTS_AND_ROLES_WIDGET_PRIMARY',
                                        'type' => 'primary-radio',
                                        'groupname' => 'primary_account',
                                        'span' => 1,
                                    ),
                                ),
                            ),
                            9 => 'email',
                            10 =>
                            array(
                                'name' => 'tag',
                                'span' => 6,
                            ),
                            11 =>
                            array(
                                'name' => 'v_vendors_contacts_name',
                                'span' => 6,
                            ),
                            12 => 'team_name',
                            13 =>
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
                    2 =>
                    array(
                        'columns' => 2,
                        'name' => 'panel_hidden',
                        'label' => 'LBL_RECORD_SHOWMORE',
                        'hide' => true,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'hint_industry_tags_c',
                                'label' => 'LBL_HINT_COMPANY_INDUSTRY_TAGS',
                            ),
                            1 =>
                            array(
                                'name' => 'facebook',
                                'comment' => 'The facebook name of the user',
                                'label' => 'LBL_FACEBOOK',
                            ),
                            2 =>
                            array(
                                'name' => 'primary_address',
                                'type' => 'fieldset',
                                'css_class' => 'address',
                                'label' => 'LBL_PRIMARY_ADDRESS',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'primary_address_street',
                                        'css_class' => 'address_street',
                                        'placeholder' => 'LBL_PRIMARY_ADDRESS_STREET',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'primary_address_city',
                                        'css_class' => 'address_city',
                                        'placeholder' => 'LBL_PRIMARY_ADDRESS_CITY',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'primary_address_state',
                                        'css_class' => 'address_state',
                                        'placeholder' => 'LBL_PRIMARY_ADDRESS_STATE',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'primary_address_postalcode',
                                        'css_class' => 'address_zip',
                                        'placeholder' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'primary_address_country',
                                        'css_class' => 'address_country',
                                        'placeholder' => 'LBL_PRIMARY_ADDRESS_COUNTRY',
                                    ),
                                ),
                            ),
                            3 =>
                            array(
                                'name' => 'alt_address',
                                'type' => 'fieldset',
                                'css_class' => 'address',
                                'label' => 'LBL_ALT_ADDRESS',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'alt_address_street',
                                        'css_class' => 'address_street',
                                        'placeholder' => 'LBL_ALT_ADDRESS_STREET',
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'alt_address_city',
                                        'css_class' => 'address_city',
                                        'placeholder' => 'LBL_ALT_ADDRESS_CITY',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'alt_address_state',
                                        'css_class' => 'address_state',
                                        'placeholder' => 'LBL_ALT_ADDRESS_STATE',
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'alt_address_postalcode',
                                        'css_class' => 'address_zip',
                                        'placeholder' => 'LBL_ALT_ADDRESS_POSTALCODE',
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'alt_address_country',
                                        'css_class' => 'address_country',
                                        'placeholder' => 'LBL_ALT_ADDRESS_COUNTRY',
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'copy',
                                        'label' => 'NTC_COPY_PRIMARY_ADDRESS',
                                        'type' => 'copy',
                                        'mapping' =>
                                        array(
                                            'primary_address_street' => 'alt_address_street',
                                            'primary_address_city' => 'alt_address_city',
                                            'primary_address_state' => 'alt_address_state',
                                            'primary_address_postalcode' => 'alt_address_postalcode',
                                            'primary_address_country' => 'alt_address_country',
                                        ),
                                    ),
                                ),
                            ),
                            4 => 'twitter',
                            5 =>
                            array(
                                'name' => 'dnb_principal_id',
                                'readonly' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'description',
                                'span' => 12,
                            ),
                            7 => 'report_to_name',
                            8 => 'sync_contact',
                            9 => 'lead_source',
                            10 => 'assigned_user_name',
                            11 =>
                            array(
                                'name' => 'campaign_name',
                                'span' => 12,
                            ),
                            12 =>
                            array(
                                'name' => 'preferred_language',
                                'type' => 'language',
                                'span' => 12,
                            ),
                            13 => 'portal_name',
                            14 => 'portal_active',
                            15 =>
                            array(
                                'name' => 'portal_password',
                                'type' => 'change-password',
                            ),
                            16 =>
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
                    3 =>
                    array(
                        'newTab' => true,
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
                                'name' => 'contact_history_c',
                                'studio' => 'visible',
                                'readonly' => true,
                                'label' => 'LBL_CONTACT_HISTORY',
                                'span' => 12,
                            ),
                            1 =>
                            array(
                                'name' => 'contact_to_account_history',
                                'studio' => 'visible',
                                'readonly' => true,
                                'label' => 'LBL_CONTACT_TO_ACCOUNT_HISTORY',
                                'span' => 12,
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
