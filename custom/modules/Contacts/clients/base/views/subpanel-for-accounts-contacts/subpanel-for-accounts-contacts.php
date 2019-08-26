<?php
// created: 2019-08-06 12:13:09
$viewdefs['Contacts']['base']['view']['subpanel-for-accounts-contacts'] = array (
  'type' => 'subpanel-list',
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
          'name' => 'name',
          'type' => 'fullname',
          'fields' => 
          array (
            0 => 'salutation',
            1 => 'first_name',
            2 => 'last_name',
          ),
          'link' => true,
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'default' => true,
        ),
        1 => 
        array (
          'name' => 'title',
          'label' => 'LBL_TITLE',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'phone_work',
          'label' => 'LBL_OFFICE_PHONE',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'phone_mobile',
          'label' => 'LBL_MOBILE_PHONE',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'email',
          'label' => 'LBL_LIST_EMAIL',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'role_contact_account',
          'label' => 'LBL_ROLE_CONTACT',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'team_name',
          'label' => 'LBL_TEAMS',
          'enabled' => true,
          'id' => 'TEAM_ID',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
      ),
    ),
  ),
);