<?php
 // created: 2019-04-29 19:19:52
$layout_defs["HT_Assets_and_Objects"]["subpanel_setup"]['ht_manifest_ht_assets_and_objects'] = array (
  'order' => 100,
  'module' => 'HT_Manifest',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_HT_MANIFEST_HT_ASSETS_AND_OBJECTS_FROM_HT_MANIFEST_TITLE',
  'get_subpanel_data' => 'ht_manifest_ht_assets_and_objects',
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
