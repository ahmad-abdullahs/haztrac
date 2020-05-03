<?php

$dictionary['ProductTemplate']['fields']['bundle_total_c'] = array(
    'duplicate_merge_dom_value' => 0,
    'calculated' => '1',
    'formula' => 'rollupSum($product_templates_product_templates_1,"discount_price")',
    'enforced' => '1',
    'dependency' => '',
    'required' => false,
    'source' => 'custom_fields',
    'name' => 'bundle_total_c',
    'vname' => 'LBL_BUNDLE_TOTAL',
    'massupdate' => false,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'readonly' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'enable_range_search' => false,
    'type' => 'currency',
    'len' => '26,6',
    'related_fields' =>
    array(
        0 => 'currency_id',
        1 => 'base_rate',
    ),
);
