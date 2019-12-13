<?php
 // created: 2019-12-12 19:42:36
$layout_defs["WPM_Waste_Profile_Template"]["subpanel_setup"]['wpm_waste_profile_template_lr_lab_reports'] = array (
  'order' => 100,
  'module' => 'LR_Lab_Reports',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_LR_LAB_REPORTS_FROM_LR_LAB_REPORTS_TITLE',
  'get_subpanel_data' => 'wpm_waste_profile_template_lr_lab_reports',
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
