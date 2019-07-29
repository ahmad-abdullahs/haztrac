<?php
 // created: 2019-05-16 00:59:17
$layout_defs["HT_Manifest"]["subpanel_setup"]['ht_manifest_revenuelineitems_1'] = array (
  'order' => 100,
  'module' => 'RevenueLineItems',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_TITLE',
  'get_subpanel_data' => 'ht_manifest_revenuelineitems_1',
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
