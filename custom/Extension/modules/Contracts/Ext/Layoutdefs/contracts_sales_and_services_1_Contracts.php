<?php
 // created: 2019-02-18 04:48:48
$layout_defs["Contracts"]["subpanel_setup"]['contracts_sales_and_services_1'] = array (
  'order' => 100,
  'module' => 'sales_and_services',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CONTRACTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
  'get_subpanel_data' => 'contracts_sales_and_services_1',
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
