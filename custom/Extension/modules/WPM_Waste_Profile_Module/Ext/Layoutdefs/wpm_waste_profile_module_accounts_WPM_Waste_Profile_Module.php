<?php
 // created: 2019-07-28 15:11:27
$layout_defs["WPM_Waste_Profile_Module"]["subpanel_setup"]['wpm_waste_profile_module_accounts'] = array (
  'order' => 100,
  'module' => 'Accounts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_WPM_WASTE_PROFILE_MODULE_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'get_subpanel_data' => 'wpm_waste_profile_module_accounts',
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
