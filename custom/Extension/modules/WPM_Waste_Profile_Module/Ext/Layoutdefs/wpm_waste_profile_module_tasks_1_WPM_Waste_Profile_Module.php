<?php
 // created: 2020-02-07 04:03:33
$layout_defs["WPM_Waste_Profile_Module"]["subpanel_setup"]['wpm_waste_profile_module_tasks_1'] = array (
  'order' => 100,
  'module' => 'Tasks',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_WPM_WASTE_PROFILE_MODULE_TASKS_1_FROM_TASKS_TITLE',
  'get_subpanel_data' => 'wpm_waste_profile_module_tasks_1',
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
