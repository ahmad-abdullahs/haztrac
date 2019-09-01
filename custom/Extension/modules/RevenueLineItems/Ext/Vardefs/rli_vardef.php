<?php

$dictionary['RevenueLineItem']['importable'] = true;
$dictionary['RevenueLineItem']['unified_search'] = true;

// Need to review this at later stage...
unset($dictionary['RevenueLineItem']['fields']['discount_price']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_price']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_price']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['discount_rate_percent']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_rate_percent']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_rate_percent']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['discount_amount_usdollar']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_amount_usdollar']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_amount_usdollar']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['discount_amount_usdollar']['readonly']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc']['formula']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc_usdollar']['formula']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc_usdollar']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc_usdollar']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc_usdollar']['readonly']);
unset($dictionary['RevenueLineItem']['fields']['discount_usdollar']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_usdollar']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_usdollar']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['discount_usdollar']['readonly']);


$dictionary["RevenueLineItem"]["fields"]['is_bundle_product_c'] = array(
    'duplicate_merge_dom_value' => 0,
    'labelValue' => 'Is Bundle Product',
    'full_text_search' =>
    array(
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
    ),
    'calculated' => '1',
    'formula' => 'ifElse(greaterThan(count($revenuelineitems_revenuelineitems_1),0),"parent",ifElse(equal(count($revenuelineitems_revenuelineitems_1_right),1),"child",""))',
    'enforced' => '1',
    'dependency' => '',
    'visibility_grid' => '',
    'required' => false,
    'source' => 'custom_fields',
    'name' => 'is_bundle_product_c',
    'vname' => 'LBL_IS_BUNDLE_PRODUCT',
    'type' => 'varchar',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'audited' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'len' => 100,
    'size' => '20',
//      'id' => 'RevenueLineItemsis_bundle_product_c',
    'custom_module' => 'RevenueLineItems',
);

// 'RevenueLineItemsis_bundle_product_c', 'is_bundle_product_c', 'LBL_IS_BUNDLE_PRODUCT', NULL, NULL, 'RevenueLineItems', 'enum', '100', '0', NULL, '2019-08-17 17:51:55', '0', '0', '1', '1', '0', 'false', 'is_bundle_product_list', '', '', NULL

/*'is_bundle_product_c' => 
    array (
      'labelValue' => 'Is Bundle Product',
      'dependency' => '',
      'visibility_grid' => '',
      'required' => false,
      'source' => 'custom_fields',
      'name' => 'is_bundle_product_c',
      'vname' => 'LBL_IS_BUNDLE_PRODUCT',
      'type' => 'enum',
      'massupdate' => true,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'false',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'audited' => false,
      'reportable' => false,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'pii' => false,
      'calculated' => false,
      'len' => 100,
      'size' => '20',
      'options' => 'is_bundle_product_list',
      'default' => NULL,
      'id' => 'RevenueLineItemsis_bundle_product_c',
      'custom_module' => 'RevenueLineItems',
    ),*/