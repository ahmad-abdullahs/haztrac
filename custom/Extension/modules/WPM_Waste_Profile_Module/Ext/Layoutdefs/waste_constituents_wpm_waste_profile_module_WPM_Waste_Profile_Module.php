<?php
 // created: 2019-12-06 19:08:42
$layout_defs["WPM_Waste_Profile_Module"]["subpanel_setup"]['waste_constituents_wpm_waste_profile_module'] = array (
  'order' => 100,
  'module' => 'waste_constituents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_WASTE_CONSTITUENTS_WPM_WASTE_PROFILE_MODULE_FROM_WASTE_CONSTITUENTS_TITLE',
  'get_subpanel_data' => 'waste_constituents_wpm_waste_profile_module',
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
