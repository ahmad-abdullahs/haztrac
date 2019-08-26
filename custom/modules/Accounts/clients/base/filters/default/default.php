<?php
// created: 2019-08-10 11:28:59
$viewdefs['Accounts']['base']['filter']['default'] = array (
  'default_filter' => 'all_records',
  'fields' => 
  array (
    'name' => 
    array (
    ),
    'account_type' => 
    array (
    ),
    'industry' => 
    array (
    ),
    'annual_revenue' => 
    array (
    ),
    'address_street' => 
    array (
      'dbFields' => 
      array (
        0 => 'billing_address_street',
        1 => 'shipping_address_street',
      ),
      'vname' => 'LBL_STREET',
      'type' => 'text',
    ),
    'address_city' => 
    array (
      'dbFields' => 
      array (
        0 => 'billing_address_city',
        1 => 'shipping_address_city',
      ),
      'vname' => 'LBL_CITY',
      'type' => 'text',
    ),
    'address_state' => 
    array (
      'dbFields' => 
      array (
        0 => 'billing_address_state',
        1 => 'shipping_address_state',
      ),
      'vname' => 'LBL_STATE',
      'type' => 'text',
    ),
    'address_postalcode' => 
    array (
      'dbFields' => 
      array (
        0 => 'billing_address_postalcode',
        1 => 'shipping_address_postalcode',
      ),
      'vname' => 'LBL_POSTAL_CODE',
      'type' => 'text',
    ),
    'address_country' => 
    array (
      'dbFields' => 
      array (
        0 => 'billing_address_country',
        1 => 'shipping_address_country',
      ),
      'vname' => 'LBL_COUNTRY',
      'type' => 'text',
    ),
    'rating' => 
    array (
    ),
    'phone_office' => 
    array (
    ),
    'ownership' => 
    array (
    ),
    'employees' => 
    array (
    ),
    'sic_code' => 
    array (
    ),
    'ticker_symbol' => 
    array (
    ),
    'date_entered' => 
    array (
    ),
    'date_modified' => 
    array (
    ),
    'tag' => 
    array (
    ),
    '$owner' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_CURRENT_USER_FILTER',
    ),
    'assigned_user_name' => 
    array (
    ),
    '$favorite' => 
    array (
      'predefined_filter' => true,
      'vname' => 'LBL_FAVORITES_FILTER',
    ),
  ),
);