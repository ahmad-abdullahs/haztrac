<?php

$dictionary['sales_and_services']['fields']['actual_rli_quantity_total'] = array(
    'calculated' => 'true',
    'formula' => 'rollupSum($sales_and_services_revenuelineitems_1,"quantity")',
    'enforced' => 'true',
    'dependency' => '',
    'required' => false,
    'name' => 'actual_rli_quantity_total',
    'vname' => 'LBL_ACTUAL_RLI_QUANTITY_TOTAL',
    'type' => 'decimal',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'len' => 18,
    'size' => '20',
    'precision' => 2,
);
