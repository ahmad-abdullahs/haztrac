<?php
 // created: 2019-04-29 19:19:52
$layout_defs["HT_Manifest"]["subpanel_setup"]['ht_manifest_v_vendors'] = array (
  'order' => 100,
  'module' => 'V_Vendors',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_HT_MANIFEST_V_VENDORS_FROM_V_VENDORS_TITLE',
  'get_subpanel_data' => 'ht_manifest_v_vendors',
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
