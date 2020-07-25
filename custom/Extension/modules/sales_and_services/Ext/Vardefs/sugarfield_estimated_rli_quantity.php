<?php

$dictionary['sales_and_services']['fields']['estimated_rli_quantity'] = array(
    'duplicate_merge_dom_value' => 0,
    'labelValue' => 'Forecasted Quantity',
    'calculated' => 'true',
    'formula' => 'rollupSum($sales_and_services_revenuelineitems_1,"estimated_quantity_c")',
    'enforced' => 'true',
    'dependency' => '',
    'required' => false,
    'name' => 'estimated_rli_quantity',
    'vname' => 'LBL_ESTIMATED_RLI_QUANTITY',
    'type' => 'decimal',
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
    'len' => 18,
    'size' => '20',
    'enable_range_search' => false,
    'precision' => 2,
);
