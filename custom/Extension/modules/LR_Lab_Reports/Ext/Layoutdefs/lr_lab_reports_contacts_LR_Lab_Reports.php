<?php
 // created: 2019-04-03 16:02:58
$layout_defs["LR_Lab_Reports"]["subpanel_setup"]['lr_lab_reports_contacts'] = array (
  'order' => 100,
  'module' => 'Contacts',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LR_LAB_REPORTS_CONTACTS_FROM_CONTACTS_TITLE',
  'get_subpanel_data' => 'lr_lab_reports_contacts',
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
