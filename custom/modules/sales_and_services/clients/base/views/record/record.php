<?php
$viewdefs['sales_and_services'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:edit_button:click',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              3 => 
              array (
                'type' => 'pdfaction',
                'name' => 'email-pdf',
                'label' => 'LBL_PDF_EMAIL',
                'action' => 'email',
                'acl_action' => 'view',
              ),
              4 => 
              array (
                'type' => 'divider',
              ),
              5 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              6 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'sales_and_services',
                'acl_action' => 'create',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              8 => 
              array (
                'type' => 'divider',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
          ),
        ),
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'width' => 42,
                'height' => 42,
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 'name',
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              3 => 
              array (
                'name' => 'follow',
                'label' => 'LBL_FOLLOW',
                'type' => 'follow',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              4 => 
              array (
                'name' => 'status_c',
                'studio' => 'visible',
                'label' => 'LBL_STATUS',
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'accounts_sales_and_services_1_name',
                'label' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_ACCOUNTS_TITLE',
              ),
              1 => 
              array (
                'name' => 'contacts_sales_and_services_1_name',
                'label' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_CONTACTS_TITLE',
                'initial_filter' => 'filterAccountsTemplate',
                'initial_filter_label' => 'LBL_FILTER_ACCOUNTS_TEMPLATE',
                'filter_relate' => 
                array (
                  'accounts_sales_and_services_1accounts_ida' => 'account_id',
                ),
              ),
              2 => 'assigned_user_name',
              3 => 'team_name',
              4 => 
              array (
                'name' => 'tag',
                'span' => 12,
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'billing_address',
                'type' => 'fieldset',
                'css_class' => 'address',
                'label' => 'LBL_BILLING_ADDRESS',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'billing_address_street_c',
                    'css_class' => 'address_street',
                    'placeholder' => 'LBL_BILLING_ADDRESS_STREET',
                  ),
                  1 => 
                  array (
                    'name' => 'billing_address_city_c',
                    'css_class' => 'address_city',
                    'placeholder' => 'LBL_BILLING_ADDRESS_CITY',
                  ),
                  2 => 
                  array (
                    'name' => 'billing_address_state_c',
                    'css_class' => 'address_state',
                    'placeholder' => 'LBL_BILLING_ADDRESS_STATE',
                  ),
                  3 => 
                  array (
                    'name' => 'billing_address_postalcode_c',
                    'css_class' => 'address_zip',
                    'placeholder' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                  ),
                  4 => 
                  array (
                    'name' => 'billing_address_country_c',
                    'css_class' => 'address_country',
                    'placeholder' => 'LBL_BILLING_ADDRESS_COUNTRY',
                  ),
                ),
              ),
              1 => 
              array (
                'name' => 'shipping_address',
                'type' => 'fieldset',
                'css_class' => 'address',
                'label' => 'LBL_SHIPPING_ADDRESS',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'shipping_address_street_c',
                    'css_class' => 'address_street',
                    'placeholder' => 'LBL_SHIPPING_ADDRESS_STREET',
                  ),
                  1 => 
                  array (
                    'name' => 'shipping_address_city_c',
                    'css_class' => 'address_city',
                    'placeholder' => 'LBL_SHIPPING_ADDRESS_CITY',
                  ),
                  2 => 
                  array (
                    'name' => 'shipping_address_state_c',
                    'css_class' => 'address_state',
                    'placeholder' => 'LBL_SHIPPING_ADDRESS_STATE',
                  ),
                  3 => 
                  array (
                    'name' => 'shipping_address_postalcode_c',
                    'css_class' => 'address_zip',
                    'placeholder' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                  ),
                  4 => 
                  array (
                    'name' => 'shipping_address_country_c',
                    'css_class' => 'address_country',
                    'placeholder' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
                  ),
                  5 => 
                  array (
                    'name' => 'copy',
                    'label' => 'NTC_COPY_BILLING_ADDRESS',
                    'type' => 'copy',
                    'default' => false,
                    'mapping' => 
                    array (
                      'billing_address_street_c' => 'shipping_address_street_c',
                      'billing_address_city_c' => 'shipping_address_city_c',
                      'billing_address_state_c' => 'shipping_address_state_c',
                      'billing_address_postalcode_c' => 'shipping_address_postalcode_c',
                      'billing_address_country_c' => 'shipping_address_country_c',
                    ),
                  ),
                ),
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'po_number_c',
                'label' => 'LBL_PO_NUMBER',
              ),
              1 => 
              array (
                'name' => 'account_terms_c',
                'label' => 'LBL_ACCOUNT_TERMS',
              ),
              2 => 
              array (
                'name' => 'taxable_c',
                'label' => 'LBL_TAXABLE',
              ),
              3 => 
              array (
                'name' => 'description',
              ),
              4 => 
              array (
                'name' => 'payment_status_c',
                'label' => 'LBL_PAYMENT_STATUS',
              ),
              5 => 
              array (
                'name' => 'payment_reference_c',
                'label' => 'LBL_PAYMENT_REFERENCE',
              ),
              6 => 
              array (
                'name' => 'rli_total_c',
                'label' => 'LBL_RLI_TOTAL',
              ),
              7 => 
              array (
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'ss_number',
                'readonly' => true,
                'comment' => 'Visual unique identifier',
                'studio' => 
                array (
                  'quickcreate' => false,
                ),
                'label' => 'LBL_SS_NUMBER',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'svc_type_c',
                'label' => 'LBL_SVC_TYPE',
              ),
              3 => 
              array (
                'name' => 'auto_truck_service_number_c',
                'label' => 'LBL_AUTO_TRUCK_SERVICE_NUMBER',
              ),
              4 => 
              array (
                'name' => 'on_date_c',
                'label' => 'LBL_ON_DATE',
              ),
              5 => 
              array (
                'name' => 'on_time_c',
                'label' => 'LBL_ON_TIME',
              ),
              6 => 
              array (
                'name' => 'notes_print_c',
                'studio' => 'visible',
                'label' => 'LBL_NOTES_PRINT',
              ),
              7 => 
              array (
                'name' => 'notes_internal_c',
                'studio' => 'visible',
                'label' => 'LBL_NOTES_INTERNAL',
              ),
            ),
          ),
          5 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_MODIFIED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_modified',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'modified_by_name',
                  ),
                ),
              ),
              1 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_ENTERED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_entered',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'created_by_name',
                  ),
                ),
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);
