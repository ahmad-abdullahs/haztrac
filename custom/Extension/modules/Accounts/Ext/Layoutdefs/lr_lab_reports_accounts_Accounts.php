<?php
 // created: 2019-04-03 16:02:58
$layout_defs["Accounts"]["subpanel_setup"]['lr_lab_reports_accounts'] = array (
  'order' => 100,
  'module' => 'LR_Lab_Reports',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LR_LAB_REPORTS_ACCOUNTS_FROM_LR_LAB_REPORTS_TITLE',
  'get_subpanel_data' => 'lr_lab_reports_accounts',
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
