<?php

$dictionary['RevenueLineItem']['fields']['date_cost_price'] = array(
    'name' => 'date_cost_price',
    'vname' => 'LBL_DATE_COST_PRICE',
    'type' => 'date',
    'massupdate' => false,
    'comment' => 'Starting date cost price is valid',
    'dependency' => 'not(equal($is_bundle_product_c,"parent"))',
    'audited' => true,
);

$dictionary['RevenueLineItem']['fields']['product_code_sku_c']['labelValue'] = 'Product Code \\ SKU';
$dictionary['RevenueLineItem']['fields']['product_code_sku_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['product_code_sku_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['product_code_sku_c']['dependency'] = '';


$dictionary['RevenueLineItem']['fields']['product_list_name_c']['labelValue'] = 'Product List Name';
$dictionary['RevenueLineItem']['fields']['product_list_name_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['product_list_name_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['product_list_name_c']['audited'] = true;

$dictionary['RevenueLineItem']['fields']['product_vendor_c']['labelValue'] = 'Product Vendor / TSDF';
$dictionary['RevenueLineItem']['fields']['product_vendor_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['labelValue'] = 'vendor product svc descrp';
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['product_svc_description_c']['labelValue'] = 'Product / Service Description';
$dictionary['RevenueLineItem']['fields']['product_svc_description_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['product_svc_description_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['product_svc_description_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['waste_profile_rqrd_c']['labelValue'] = 'Waste Profile Required (Y)';
$dictionary['RevenueLineItem']['fields']['waste_profile_rqrd_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['waste_profile_rqrd_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['product_uom_c']['labelValue'] = 'Product UOM';
//$dictionary['RevenueLineItem']['fields']['product_uom_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['product_uom_c']['visibility_grid'] = '';
$dictionary['RevenueLineItem']['fields']['shipping_hazardous_materia_c']['labelValue'] = 'Hazardous Material (Y)';
$dictionary['RevenueLineItem']['fields']['shipping_hazardous_materia_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['shipping_hazardous_materia_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['state_regulated_c']['labelValue'] = 'State Regulated (Y)';
$dictionary['RevenueLineItem']['fields']['state_regulated_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['state_regulated_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['waste_state_codes_c']['labelValue'] = 'State Waste Codes';
$dictionary['RevenueLineItem']['fields']['waste_state_codes_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['waste_state_codes_c']['visibility_grid'] = '';
$dictionary['RevenueLineItem']['fields']['epa_waste_codes_c']['labelValue'] = 'EPA Waste Codes';
$dictionary['RevenueLineItem']['fields']['epa_waste_codes_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['epa_waste_codes_c']['visibility_grid'] = '';
$dictionary['RevenueLineItem']['fields']['shipping_ca_name_c']['labelValue'] = 'CA Shipping Name';
$dictionary['RevenueLineItem']['fields']['shipping_ca_name_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['shipping_ca_name_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['shipping_ca_name_c']['dependency'] = '';
$dictionary['RevenueLineItem']['fields']['additional_info_ack_c']['labelValue'] = 'Additional Info / Acknowledgement ';
$dictionary['RevenueLineItem']['fields']['additional_info_ack_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['additional_info_ack_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['additional_info_ack_c']['dependency'] = '';

//$dictionary['RevenueLineItem']['fields']['cost_price'] = array(
//    'name' => 'cost_price',
//    'vname' => 'LBL_COST_PRICE',
//    'type' => 'currency',
//    'required' => true,
//    'len' => 26,
//    'comment' => 'Product cost ("Cost" in Quote)',
//    'importable' => 'required',
//    'related_fields' =>
//    array(
//        0 => 'currency_id',
//        1 => 'base_rate',
//    ),
//    'convertToBase' => true,
//    'showTransactionalAmount' => true,
//    'default' => 0.0,
//    'audited' => false,
//    'massupdate' => false,
//    'comments' => 'Product cost ("Cost" in Quote)',
//    'duplicate_merge' => 'enabled',
//    'duplicate_merge_dom_value' => '1',
//    'merge_filter' => 'disabled',
//    'unified_search' => false,
//    'calculated' => false,
//    'enable_range_search' => false,
//);
//$dictionary['RevenueLineItem']['fields']['discount_price'] = array(
//    'name' => 'discount_price',
//    'vname' => 'LBL_DISCOUNT_PRICE',
//    'required' => true,
//    'type' => 'currency',
//    'len' => 26,
//    'comment' => 'Discounted price ("Unit Price" in Quote)',
//    'importable' => 'required',
//    'related_fields' =>
//    array(
//        0 => 'currency_id',
//        1 => 'base_rate',
//    ),
//    'convertToBase' => true,
//    'showTransactionalAmount' => true,
//    'default' => 0.0,
//    'audited' => false,
//    'massupdate' => false,
//    'comments' => 'Discounted price ("Unit Price" in Quote)',
//    'duplicate_merge' => 'enabled',
//    'duplicate_merge_dom_value' => '1',
//    'merge_filter' => 'disabled',
//    'unified_search' => false,
//    'calculated' => false,
//    'enable_range_search' => false,
//);
//$dictionary['RevenueLineItem']['fields']['list_price'] = array(
//    'name' => 'list_price',
//    'vname' => 'LBL_LIST_PRICE',
//    'required' => true,
//    'type' => 'currency',
//    'len' => 26,
//    'importable' => 'required',
//    'comment' => 'List price of product ("List" in Quote)',
//    'related_fields' =>
//    array(
//        0 => 'currency_id',
//        1 => 'base_rate',
//    ),
//    'convertToBase' => true,
//    'showTransactionalAmount' => true,
//    'default' => 0.0,
//    'audited' => false,
//    'massupdate' => false,
//    'comments' => 'List price of product ("List" in Quote)',
//    'duplicate_merge' => 'enabled',
//    'duplicate_merge_dom_value' => '1',
//    'merge_filter' => 'disabled',
//    'unified_search' => false,
//    'calculated' => false,
//    'enable_range_search' => false,
//);
//$dictionary['RevenueLineItem']['fields']['cost_usdollar'] = array(
//    'name' => 'cost_usdollar',
//    'vname' => 'LBL_COST_USDOLLAR',
//    'type' => 'currency',
//    'currency_id' => '-99',
//    'len' => '26,6',
//    'comment' => 'Cost expressed in USD',
//    'studio' =>
//    array(
//        'mobile' => false,
//    ),
//    'readonly' => true,
//    'is_base_currency' => true,
//    'related_fields' =>
//    array(
//        0 => 'currency_id',
//        1 => 'base_rate',
//    ),
//    'formula' => 'ifElse(isNumeric($cost_price), currencyDivide($cost_price, $base_rate), "")',
//    'calculated' => true,
//    'enforced' => true,
//);
//$dictionary['RevenueLineItem']['fields']['discount_usdollar'] = array(
//    'name' => 'discount_usdollar',
//    'vname' => 'LBL_DISCOUNT_USDOLLAR',
//    'type' => 'currency',
//    'currency_id' => '-99',
//    'len' => '26,6',
//    'comment' => 'Discount price expressed in USD',
//    'studio' =>
//    array(
//        'mobile' => false,
//    ),
//    'readonly' => true,
//    'is_base_currency' => true,
//    'related_fields' =>
//    array(
//        0 => 'currency_id',
//        1 => 'base_rate',
//    ),
//    'formula' => 'ifElse(isNumeric($discount_price), currencyDivide($discount_price, $base_rate), "")',
//    'calculated' => true,
//    'enforced' => true,
//);
//$dictionary['RevenueLineItem']['fields']['list_usdollar'] = array(
//    'name' => 'list_usdollar',
//    'vname' => 'LBL_LIST_USDOLLAR',
//    'type' => 'currency',
//    'currency_id' => '-99',
//    'len' => '26,6',
//    'comment' => 'List price expressed in USD',
//    'studio' =>
//    array(
//        'mobile' => false,
//    ),
//    'readonly' => true,
//    'is_base_currency' => true,
//    'related_fields' =>
//    array(
//        0 => 'currency_id',
//        1 => 'base_rate',
//    ),
//    'formula' => 'ifElse(isNumeric($list_price), currencyDivide($list_price, $base_rate), "")',
//    'calculated' => true,
//    'enforced' => true,
//);
//
//$dictionary['RevenueLineItem']['fields']['pricing_formula'] = array(
//    'name' => 'pricing_formula',
//    'vname' => 'LBL_PRICING_FORMULA',
//    'type' => 'pricing-formula',
//    'dbType' => 'enum',
//    'options' => 'pricing_formula_dom',
//    'len' => 100,
//    'comment' => 'Pricing formula (ex: Fixed, Markup over Cost)',
//    'studio' =>
//    array(
//        'field' =>
//        array(
//            'options' => false,
//        ),
//    ),
//    'related_fields' =>
//    array(
//        0 => 'pricing_factor',
//    ),
//);
//
//$dictionary['RevenueLineItem']['fields']['pricing_factor'] = array(
//    'name' => 'pricing_factor',
//    'vname' => 'LBL_PRICING_FACTOR',
//    'type' => 'decimal',
//    'len' => '8',
//    'precision' => '2',
//    'comment' => 'Variable pricing factor depending on pricing_formula',
//    'related_fields' =>
//    array(
//        0 => 'pricing_formula',
//    ),
//);
