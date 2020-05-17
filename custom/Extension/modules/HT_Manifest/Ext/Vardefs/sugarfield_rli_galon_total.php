<?php

$dictionary['HT_Manifest']['fields']['rli_galon_total'] = array(
    'name' => 'rli_galon_total',
    'vname' => 'LBL_RLI_GALON_TOTAL',
    'type' => 'decimal',
    'len' => '12',
    'precision' => 2,
    'comment' => 'Rollup of all RevenueLineItems linked to the manifest where product_uom_c is each galon (ea Gal)',
    'formula' => 'rollupConditionalSum($ht_manifest_revenuelineitems_1, "quantity", "product_uom_c", "ea Gal")',
    'calculated' => true,
    'enforced' => true,
);
