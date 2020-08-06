<?php

$dictionary["RevenueLineItem"]["fields"]["list_pricing_formula"] = array(
    'name' => 'list_pricing_formula',
    'label' => 'List Pricing Formula',
    'vname' => 'LBL_LIST_PRICING_FORMULA',
    'type' => 'varchar',
    'len' => '255',
    'dependency' => 'not(equal($is_bundle_product_c,"parent"))',
);

$dictionary["RevenueLineItem"]["fields"]["cost_pricing_formula"] = array(
    'name' => 'cost_pricing_formula',
    'label' => 'Cost Pricing Formula',
    'vname' => 'LBL_COST_PRICING_FORMULA',
    'type' => 'varchar',
    'len' => '255',
    'audited' => true,
    'dependency' => 'not(equal($is_bundle_product_c,"parent"))',
);
