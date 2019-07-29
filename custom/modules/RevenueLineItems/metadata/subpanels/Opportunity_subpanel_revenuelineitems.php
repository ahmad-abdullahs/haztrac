<?php
// created: 2019-02-26 11:23:09
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_LIST_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'date_closed' => 
  array (
    'type' => 'date',
    'related_fields' => 
    array (
      0 => 'date_closed_timestamp',
    ),
    'vname' => 'LBL_DATE_CLOSED',
    'width' => 10,
    'default' => true,
  ),
  'worst_case' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_WORST',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
  ),
  'likely_case' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_LIKELY',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
  ),
  'best_case' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_BEST',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
  ),
  'account_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_ACCOUNT_NAME',
    'id' => 'ACCOUNT_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Accounts',
    'target_record_key' => 'account_id',
  ),
  'sales_stage' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_SALES_STAGE',
    'width' => 10,
    'default' => true,
  ),
  'probability' => 
  array (
    'type' => 'int',
    'vname' => 'LBL_PROBABILITY',
    'width' => 10,
    'default' => true,
  ),
  'commit_stage' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_COMMIT_STAGE_FORECAST',
    'width' => 10,
  ),
  'product_template_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'editview' => false,
      'detailview' => false,
      'quickcreate' => false,
    ),
    'vname' => 'LBL_PRODUCT',
    'id' => 'PRODUCT_TEMPLATE_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'ProductTemplates',
    'target_record_key' => 'product_template_id',
  ),
  'category_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'editview' => false,
      'detailview' => false,
      'quickcreate' => false,
    ),
    'vname' => 'LBL_CATEGORY_NAME',
    'id' => 'CATEGORY_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'ProductCategories',
    'target_record_key' => 'category_id',
  ),
  'quantity' => 
  array (
    'vname' => 'LBL_QUANTITY',
    'width' => 10,
    'default' => true,
  ),
  'quote_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_QUOTE_NAME',
    'id' => 'QUOTE_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Quotes',
    'target_record_key' => 'quote_id',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'vname' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'assigned_user_id',
  ),
  'discount_usdollar' => 
  array (
    'usage' => 'query_only',
    'sortable' => false,
  ),
  'currency_id' => 
  array (
    'name' => 'currency_id',
    'usage' => 'query_only',
  ),
);