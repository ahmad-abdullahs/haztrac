<?php

$dictionary['RevenueLineItem']['importable'] = true;
$dictionary['RevenueLineItem']['unified_search'] = true;

// Need to review this at later stage...
unset($dictionary['RevenueLineItem']['fields']['discount_price']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_price']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_price']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['cost_price']['formula']);
unset($dictionary['RevenueLineItem']['fields']['cost_price']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['cost_price']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['list_price']['formula']);
unset($dictionary['RevenueLineItem']['fields']['list_price']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['list_price']['enforced']);
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
unset($dictionary['RevenueLineItem']['fields']['cost_usdollar']['formula']);
unset($dictionary['RevenueLineItem']['fields']['cost_usdollar']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['cost_usdollar']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['cost_usdollar']['readonly']);
unset($dictionary['RevenueLineItem']['fields']['list_usdollar']['formula']);
unset($dictionary['RevenueLineItem']['fields']['list_usdollar']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['list_usdollar']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['list_usdollar']['readonly']);


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
//    'formula' => 'ifElse(greaterThan(count($revenuelineitems_revenuelineitems_1),0),"parent",ifElse(equal(count($revenuelineitems_revenuelineitems_1_right),1),"child",""))',
    'formula' => 'ifElse(greaterThan(count($revenuelineitems_revenuelineitems_1),0),"parent",'
    . 'ifElse(or('
    . 'equal(count($revenuelineitems_revenuelineitems_1_right),1)'
    . ','
    . 'not(equal($revenuelineitems_revenuelineitems_1revenuelineitems_ida,""))'
//    . ','
//    . 'not(equal($revenuelineitems_revenuelineitems_1_right,""))'
    . '),"child",""))',
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

$dictionary['RevenueLineItem']['fields']['createBundleLogic'] = array(
    'name' => 'createBundleLogic',
    'vname' => 'LBL_CREATE_BUNDLE_LOGIC',
    'type' => 'varchar',
    'source' => 'non-db',
    'studio' => false,
);

$dictionary['RevenueLineItem']['fields']['executeBundleLogic'] = array(
    'name' => 'executeBundleLogic',
    'vname' => 'LBL_EXECUTE_BUNDLE_LOGIC',
    'type' => 'varchar',
    'source' => 'non-db',
    'studio' => false,
);

$dictionary['RevenueLineItem']['fields']['executeGroupLogic'] = array(
    'name' => 'executeGroupLogic',
    'vname' => 'LBL_EXECUTE_GROUP_LOGIC',
    'type' => 'varchar',
    'source' => 'non-db',
    'studio' => false,
);
