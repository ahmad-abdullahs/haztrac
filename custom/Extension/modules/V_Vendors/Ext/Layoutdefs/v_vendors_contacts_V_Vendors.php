<?php
 // created: 2019-04-19 17:07:34
$layout_defs["V_Vendors"]["subpanel_setup"]['v_vendors_contacts'] = array (
  'order' => 100,
  'module' => 'Contacts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_V_VENDORS_CONTACTS_FROM_CONTACTS_TITLE',
  'get_subpanel_data' => 'v_vendors_contacts',
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
