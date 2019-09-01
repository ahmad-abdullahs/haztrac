<?php

// created: 2019-08-28 01:19:07
$dictionary['RevenueLineItem']['fields']['rli_type_c']['duplicate_merge_dom_value'] = 0;
$dictionary['RevenueLineItem']['fields']['rli_type_c']['labelValue'] = 'RLI TYPE';
$dictionary['RevenueLineItem']['fields']['rli_type_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['rli_type_c']['calculated'] = '1';
$dictionary['RevenueLineItem']['fields']['rli_type_c']['formula'] = 'ifElse(greaterThan(count($revenuelineitems_revenuelineitems_1),0),"parent",ifElse(equal(count($revenuelineitems_revenuelineitems_1_right),1),"child",""))';
$dictionary['RevenueLineItem']['fields']['rli_type_c']['enforced'] = '1';
$dictionary['RevenueLineItem']['fields']['rli_type_c']['dependency'] = '';


$dictionary['RevenueLineItem']['fields']['rli_type_c'] = array(
    'duplicate_merge_dom_value' => 0,
    'labelValue' => 'RLI TYPE',
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
    'required' => false,
    'source' => 'custom_fields',
    'name' => 'rli_type_c',
    'vname' => 'LBL_RLI_TYPE',
    'type' => 'varchar',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'len' => 255,
    'size' => '20',
//    'id' => 'RevenueLineItemsrli_type_c',
    'custom_module' => 'RevenueLineItems',
);
