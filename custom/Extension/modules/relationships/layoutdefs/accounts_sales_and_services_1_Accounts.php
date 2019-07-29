<?php
 // created: 2019-02-18 04:39:54
$layout_defs["Accounts"]["subpanel_setup"]['accounts_sales_and_services_1'] = array (
  'order' => 100,
  'module' => 'sales_and_services',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
  'get_subpanel_data' => 'accounts_sales_and_services_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
