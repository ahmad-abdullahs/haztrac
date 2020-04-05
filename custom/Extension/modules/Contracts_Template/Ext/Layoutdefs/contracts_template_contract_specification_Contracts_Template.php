<?php
 // created: 2020-04-05 12:57:47
$layout_defs["Contracts_Template"]["subpanel_setup"]['contracts_template_contract_specification'] = array (
  'order' => 100,
  'module' => 'contract_specification',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_CONTRACTS_TEMPLATE_CONTRACT_SPECIFICATION_FROM_CONTRACT_SPECIFICATION_TITLE',
  'get_subpanel_data' => 'contracts_template_contract_specification',
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
