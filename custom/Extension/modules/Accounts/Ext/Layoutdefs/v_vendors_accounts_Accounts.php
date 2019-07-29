<?php
 // created: 2019-04-19 17:07:34
$layout_defs["Accounts"]["subpanel_setup"]['v_vendors_accounts'] = array (
  'order' => 100,
  'module' => 'V_Vendors',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_V_VENDORS_ACCOUNTS_FROM_V_VENDORS_TITLE',
  'get_subpanel_data' => 'v_vendors_accounts',
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
