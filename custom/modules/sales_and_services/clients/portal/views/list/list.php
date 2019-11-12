<?php
$viewdefs['sales_and_services'] = 
array (
  'portal' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'related_fields' => 
                array (
                  0 => 'shipping_address_street_c',
                  1 => 'shipping_address_city_c',
                  2 => 'shipping_address_state_c',
                  3 => 'shipping_address_postalcode_c',
                  4 => 'shipping_address_country_c',
                  5 => 'lat_c',
                  6 => 'lon_c',
                ),
              ),
              1 => 
              array (
                'name' => 'ss_number',
                'label' => 'LBL_SS_NUMBER',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'accounts_sales_and_services_1_name',
                'label' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_ACCOUNTS_TITLE',
                'enabled' => true,
                'id' => 'ACCOUNTS_SALES_AND_SERVICES_1ACCOUNTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
                'eye-icon' => false,
              ),
              3 => 
              array (
                'name' => 'status_c',
                'label' => 'LBL_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'on_date_c',
                'label' => 'LBL_ON_DATE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'on_time_c',
                'label' => 'LBL_ON_TIME',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'svc_days_c',
                'label' => 'LBL_SVC_DAYS',
                'enabled' => true,
                'default' => true,
              ),
            ),
          ),
        ),
        'last_state' => 
        array (
          'id' => 'list',
        ),
      ),
    ),
  ),
);
