<?php
 // created: 2019-04-22 16:51:57
$layout_defs["Accounts"]["subpanel_setup"]['ht_po_accounts'] = array (
  'order' => 100,
  'module' => 'HT_PO',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_HT_PO_ACCOUNTS_FROM_HT_PO_TITLE',
  'get_subpanel_data' => 'ht_po_accounts',
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
