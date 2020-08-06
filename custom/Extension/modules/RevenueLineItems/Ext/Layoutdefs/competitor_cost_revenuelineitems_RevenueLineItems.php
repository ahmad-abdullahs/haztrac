<?php
 // created: 2020-07-30 03:45:56
$layout_defs["RevenueLineItems"]["subpanel_setup"]['competitor_cost_revenuelineitems'] = array (
  'order' => 100,
  'module' => 'competitor_cost',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_COMPETITOR_COST_REVENUELINEITEMS_FROM_COMPETITOR_COST_TITLE',
  'get_subpanel_data' => 'competitor_cost_revenuelineitems',
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
