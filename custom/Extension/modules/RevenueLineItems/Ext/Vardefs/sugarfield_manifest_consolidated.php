<?php

$dictionary['RevenueLineItem']['fields']['consolidated_manifest'] = array(
    'dependency' => 'not(equal($is_bundle_product_c,"parent"))',
    'labelValue' => 'Consolidated Manifest',
    'enforced' => '',
    'required' => false,
    'name' => 'consolidated_manifest',
    'vname' => 'LBL_CONSOLIDATED_MANIFEST',
    'type' => 'bool',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'default' => false,
    'calculated' => false,
    'size' => '20',
);
