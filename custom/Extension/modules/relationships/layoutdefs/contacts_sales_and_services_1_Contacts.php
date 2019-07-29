<?php
 // created: 2019-02-18 04:43:23
$layout_defs["Contacts"]["subpanel_setup"]['contacts_sales_and_services_1'] = array (
  'order' => 100,
  'module' => 'sales_and_services',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
  'get_subpanel_data' => 'contacts_sales_and_services_1',
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
