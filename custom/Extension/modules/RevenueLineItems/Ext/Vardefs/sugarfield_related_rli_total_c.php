<?php

$dictionary['RevenueLineItem']['fields']['related_rli_total_c'] = array(
    'duplicate_merge_dom_value' => 0,
    'labelValue' => 'Bundle Forecast Total',
    'calculated' => '1',
    'formula' => 'rollupSum($revenuelineitems_revenuelineitems_1,"total_amount")',
    'enforced' => '1',
    'dependency' => '',
    'required' => false,
    'source' => 'custom_fields',
    'name' => 'related_rli_total_c',
    'vname' => 'LBL_RELATED_RLI_TOTAL',
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
