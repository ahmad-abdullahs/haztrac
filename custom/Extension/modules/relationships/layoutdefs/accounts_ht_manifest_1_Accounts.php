<?php
 // created: 2019-06-03 20:24:59
$layout_defs["Accounts"]["subpanel_setup"]['accounts_ht_manifest_1'] = array (
  'order' => 100,
  'module' => 'HT_Manifest',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_HT_MANIFEST_TITLE',
  'get_subpanel_data' => 'accounts_ht_manifest_1',
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
