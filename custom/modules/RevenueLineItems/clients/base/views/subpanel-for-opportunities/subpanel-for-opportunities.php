<?php
// created: 2019-06-17 16:45:52
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-opportunities'] = array (
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
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'name' => 'name',
          'link' => true,
          'type' => 'name',
        ),
        1 => 
        array (
          'type' => 'date',
          'default' => true,
          'label' => 'LBL_DATE_CLOSED',
          'enabled' => true,
          'name' => 'date_closed',
        ),
        2 => 
        array (
          'type' => 'currency',
          'default' => true,
          'label' => 'LBL_WORST',
          'enabled' => true,
          'name' => 'worst_case',
        ),
        3 => 
        array (
          'type' => 'currency',
          'default' => true,
          'label' => 'LBL_LIKELY',
          'enabled' => true,
          'name' => 'likely_case',
        ),
        4 => 
        array (
          'type' => 'currency',
          'default' => true,
          'label' => 'LBL_BEST',
          'enabled' => true,
          'name' => 'best_case',
        ),
        5 => 
        array (
          'type' => 'relate',
          'link' => true,
          'default' => true,
          'target_module' => 'Accounts',
          'target_record_key' => 'account_id',
          'label' => 'LBL_ACCOUNT_NAME',
          'enabled' => true,
          'name' => 'account_name',
        ),
        6 => 
        array (
          'type' => 'enum',
          'default' => true,
          'label' => 'LBL_SALES_STAGE',
          'enabled' => true,
          'name' => 'sales_stage',
        ),
        7 => 
        array (
          'type' => 'int',
          'default' => true,
          'label' => 'LBL_PROBABILITY',
          'enabled' => true,
          'name' => 'probability',
        ),
        8 => 
        array (
          'type' => 'enum',
          'default' => true,
          'label' => 'LBL_COMMIT_STAGE_FORECAST',
          'enabled' => true,
          'name' => 'commit_stage',
        ),
        9 => 
        array (
          'type' => 'relate',
          'link' => true,
          'default' => true,
          'target_module' => 'ProductTemplates',
          'target_record_key' => 'product_template_id',
          'label' => 'LBL_PRODUCT',
          'enabled' => true,
          'name' => 'product_template_name',
        ),
        10 => 
        array (
          'type' => 'relate',
          'link' => true,
          'default' => true,
          'target_module' => 'ProductCategories',
          'target_record_key' => 'category_id',
          'label' => 'LBL_CATEGORY_NAME',
          'enabled' => true,
          'name' => 'category_name',
        ),
        11 => 
        array (
          'default' => true,
          'label' => 'LBL_QUANTITY',
          'enabled' => true,
          'name' => 'quantity',
          'type' => 'decimal',
        ),
        12 => 
        array (
          'type' => 'relate',
          'link' => true,
          'default' => true,
          'target_module' => 'Quotes',
          'target_record_key' => 'quote_id',
          'label' => 'LBL_QUOTE_NAME',
          'enabled' => true,
          'name' => 'quote_name',
        ),
        13 => 
        array (
          'link' => true,
          'type' => 'relate',
          'default' => true,
          'target_module' => 'Users',
          'target_record_key' => 'assigned_user_id',
          'label' => 'LBL_ASSIGNED_TO',
          'enabled' => true,
          'name' => 'assigned_user_name',
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);