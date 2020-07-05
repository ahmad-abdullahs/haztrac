<?php

$dictionary['sales_and_services']['fields']['primary_rli_uom'] = array(
    'calculated' => 'true',
    'formula' => 'relatedValueIfExistOnTrue($sales_and_services_revenuelineitems_1, "product_uom_c", "primary_rli")',
    'enforced' => 'true',
    'dependency' => '',
    'required' => false,
    'name' => 'primary_rli_uom',
    'vname' => 'LBL_PRIMARY_RLI_UOM',
    'type' => 'enum',
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'unit_of_measure_c_list',
);
