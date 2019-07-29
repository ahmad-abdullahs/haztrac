<?php
 // created: 2019-02-18 01:00:22
$layout_defs["Accounts"]["subpanel_setup"]['sales_and_services_accounts_1'] = array (
  'order' => 100,
  'module' => 'sales_and_services',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SALES_AND_SERVICES_ACCOUNTS_1_FROM_SALES_AND_SERVICES_TITLE',
  'get_subpanel_data' => 'sales_and_services_accounts_1',
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
