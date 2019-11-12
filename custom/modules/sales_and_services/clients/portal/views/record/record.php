<?php
$viewdefs['sales_and_services'] = 
array (
  'portal' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
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
            'header' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'label' => 'LBL_RECORD_HEADER',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'size' => 'large',
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'name',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'status_c',
                'label' => 'LBL_STATUS',
              ),
              4 => 
              array (
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
                'type' => 'relate-autopopulate-team-related',
              ),
              1 => 
              array (
                'name' => 'status_c',
                'label' => 'LBL_STATUS',
              ),
              2 => 
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
              3 => 
              array (
                'name' => 'po_number_c',
                'label' => 'LBL_PO_NUMBER',
                'initial_filter' => 'filterByAccountId',
                'initial_filter_label' => 'LBL_FILTER_BY_ACCOUNT_ID',
                'link' => false,
                'eye-icon' => false,
                'filter_relate' => 
                array (
                  'accounts_sales_and_services_1accounts_ida' => 'account_id_c',
                ),
              ),
              4 => 
              array (
                'name' => 'account_terms_c',
                'label' => 'LBL_ACCOUNT_TERMS',
              ),
              5 => 
              array (
                'name' => 'destination_ship_to_c',
                'studio' => 'visible',
                'label' => 'LBL_DESTINATION_SHIP_TO',
                'link' => false,
                'eye-icon' => false,
              ),
              6 => 
              array (
                'name' => 'on_date_c',
                'label' => 'LBL_ON_DATE',
              ),
              7 => 
              array (
                'name' => 'on_time_c',
                'label' => 'LBL_ON_TIME',
              ),
              8 => 
              array (
                'name' => 'instructions_notes_c',
                'studio' => 'visible',
                'label' => 'LBL_INSTRUCTIONS_NOTES',
              ),
              9 => 
              array (
                'name' => 'transporter_carrier_c',
                'studio' => 'visible',
                'label' => 'LBL_TRANSPORTER_CARRIER',
                'link' => false,
                'eye-icon' => false,
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
