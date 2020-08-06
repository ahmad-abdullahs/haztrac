<?php
 // created: 2020-07-31 05:01:49
$layout_defs["Accounts"]["subpanel_setup"]['accounts_competitor_cost_1'] = array (
  'order' => 100,
  'module' => 'competitor_cost',
  'subpanel_name' => 'Create',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ACCOUNTS_COMPETITOR_COST_1_FROM_COMPETITOR_COST_TITLE',
  'get_subpanel_data' => 'accounts_competitor_cost_1',
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
