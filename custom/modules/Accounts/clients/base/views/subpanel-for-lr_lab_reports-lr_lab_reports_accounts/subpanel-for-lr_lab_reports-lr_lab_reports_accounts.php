<?php
// created: 2019-06-21 11:07:39
$viewdefs['Accounts']['base']['view']['subpanel-for-lr_lab_reports-lr_lab_reports_accounts'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_CITY',
          'enabled' => true,
          'name' => 'billing_address_city',
        ),
        2 => 
        array (
          'type' => 'varchar',
          'default' => true,
          'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
          'enabled' => true,
          'name' => 'billing_address_country',
        ),
        3 => 
        array (
          'default' => true,
          'label' => 'LBL_LIST_PHONE',
          'enabled' => true,
          'name' => 'phone_office',
        ),
        4 => 
        array (
          'name' => 'role_assigned',
          'label' => 'LBL_ROLE',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);