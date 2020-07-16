<?php
// created: 2020-07-11 22:46:42
$viewdefs['PNL_Permits_Licenses']['base']['view']['subpanel-for-pnl_permits_licenses-pnl_permits_licenses_pnl_permits_licenses_1'] = array (
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
          'label' => 'LBL_NAME',
          'enabled' => true,
          'link' => true,
          'default' => true,
        ),
        1 => 
        array (
          'name' => 'document_name',
          'label' => 'LBL_LIST_DOCUMENT_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
        ),
        2 => 
        array (
          'name' => 'status_id',
          'label' => 'LBL_DOC_STATUS',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'category_id',
          'label' => 'LBL_SF_CATEGORY',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'subcategory_id',
          'label' => 'LBL_SF_SUBCATEGORY',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'active_date',
          'label' => 'LBL_DOC_ACTIVE_DATE',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'exp_date',
          'label' => 'LBL_DOC_EXP_DATE',
          'enabled' => true,
          'default' => true,
        ),
        7 => 
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
  'type' => 'subpanel-list',
);