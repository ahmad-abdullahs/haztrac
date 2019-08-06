<?php
 // created: 2015-11-10 09:16:50
$layout_defs["bc_QuoteCategory"]["subpanel_setup"]['bc_quotecategory_bc_quote'] = array (
  'order' => 100,
  'module' => 'bc_Quote',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_BC_QUOTECATEGORY_BC_QUOTE_FROM_BC_QUOTE_TITLE',
  'get_subpanel_data' => 'bc_quotecategory_bc_quote',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
  ),
);
