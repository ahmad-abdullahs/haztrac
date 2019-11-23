<?php
 // created: 2019-11-23 17:29:37
$layout_defs["WPM_Waste_Profile_Module"]["subpanel_setup"]['waste_composition_wpm_waste_profile_module'] = array (
  'order' => 100,
  'module' => 'waste_composition',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_WASTE_COMPOSITION_WPM_WASTE_PROFILE_MODULE_FROM_WASTE_COMPOSITION_TITLE',
  'get_subpanel_data' => 'waste_composition_wpm_waste_profile_module',
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
