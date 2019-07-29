<?php
// created: 2019-03-16 12:12:01
$viewdefs['sales_and_services']['base']['view']['subpanel-for-accounts-accounts_sales_and_services_1'] = array (
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
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'profile_no_c',
          'label' => 'LBL_PROFILE_NO',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'on_date_c',
          'label' => 'LBL_ON_DATE',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'on_time_c',
          'label' => 'LBL_ON_TIME',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'svc_days_c',
          'label' => 'LBL_SVC_DAYS',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'status_c',
          'label' => 'LBL_STATUS',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
  'type' => 'subpanel-list',
);