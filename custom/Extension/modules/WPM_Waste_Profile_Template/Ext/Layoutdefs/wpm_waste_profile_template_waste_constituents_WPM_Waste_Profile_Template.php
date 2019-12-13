<?php
 // created: 2019-12-12 19:42:36
$layout_defs["WPM_Waste_Profile_Template"]["subpanel_setup"]['wpm_waste_profile_template_waste_constituents'] = array (
  'order' => 100,
  'module' => 'waste_constituents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_WASTE_CONSTITUENTS_FROM_WASTE_CONSTITUENTS_TITLE',
  'get_subpanel_data' => 'wpm_waste_profile_template_waste_constituents',
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
