<?php
 // created: 2021-11-04 19:37:40
$layout_defs["LR_Lab_Reports"]["subpanel_setup"]['lr_lab_reports_cases_1'] = array (
  'order' => 100,
  'module' => 'Cases',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LR_LAB_REPORTS_CASES_1_FROM_CASES_TITLE',
  'get_subpanel_data' => 'lr_lab_reports_cases_1',
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
