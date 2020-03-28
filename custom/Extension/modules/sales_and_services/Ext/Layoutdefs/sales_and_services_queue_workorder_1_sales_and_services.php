<?php
 // created: 2020-03-28 03:12:02
$layout_defs["sales_and_services"]["subpanel_setup"]['sales_and_services_queue_workorder_1'] = array (
  'order' => 100,
  'module' => 'queue_workorder',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SALES_AND_SERVICES_QUEUE_WORKORDER_1_FROM_QUEUE_WORKORDER_TITLE',
  'get_subpanel_data' => 'sales_and_services_queue_workorder_1',
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
