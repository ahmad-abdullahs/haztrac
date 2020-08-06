<?php

$dictionary["competitor_cost"]["fields"]["product_uom_competitor"] = array(
    'required' => false,
    'name' => 'product_uom_competitor',
    'vname' => 'LBL_PRODUCT_UOM',
    'type' => 'enum',
    'massupdate' => true,
    'no_default' => false,
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'unit_of_measure_c_list',
    'default' => NULL,
);

