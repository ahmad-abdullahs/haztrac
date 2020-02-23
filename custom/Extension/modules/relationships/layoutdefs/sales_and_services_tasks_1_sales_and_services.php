<?php
 // created: 2020-02-23 03:49:26
$layout_defs["sales_and_services"]["subpanel_setup"]['sales_and_services_tasks_1'] = array (
  'order' => 100,
  'module' => 'Tasks',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SALES_AND_SERVICES_TASKS_1_FROM_TASKS_TITLE',
  'get_subpanel_data' => 'sales_and_services_tasks_1',
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
