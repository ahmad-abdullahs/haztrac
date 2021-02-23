<?php
 // created: 2021-02-10 13:00:43
$layout_defs["Accounts"]["subpanel_setup"]['accounts_ht_manifest_2'] = array (
  'order' => 100,
  'module' => 'HT_Manifest',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_HT_MANIFEST_2_FROM_HT_MANIFEST_TITLE',
  'get_subpanel_data' => 'accounts_ht_manifest_2',
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
