<?php

$dictionary['RevenueLineItem']['fields']['estimated_total_list'] = array(
    'name' => 'estimated_total_list',
    'formula' => 'multiply($estimated_quantity_c,$list_price)',
    'calculated' => '1',
    'enforced' => true,
    'vname' => 'LBL_ESTIMATED_TOTAL_LIST',
    'reportable' => false,
    'type' => 'currency',
    'related_fields' =>
    array(
        0 => 'currency_id',
        1 => 'base_rate',
    ),
    'audited' => false,
    'massupdate' => false,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'merge_filter' => 'disabled',
    'enable_range_search' => false,
    'dependency' => 'not(equal($is_bundle_product_c,"parent"))',
);
