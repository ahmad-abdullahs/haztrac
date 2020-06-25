<?php

$dictionary['RevenueLineItem']['fields']['product_code_sku_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['product_list_name_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['vendor_part_num']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['product_svc_description_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['mandatory_print_text_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['additional_info_ack_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['waste_profile_rqrd_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['discount_price']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['product_uom_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['pricing_formula']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['weight']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['cost_usdollar']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['date_cost_price']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['discount_usdollar']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['tax_class']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['base_rate']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['shipping_hazardous_materia_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['consolidated_manifest']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['state_regulated_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['proper_shipping_name_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['erg_no_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['waste_state_codes_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['epa_waste_codes_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['manifest_hazmat_handle_code_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['manifest_container_type_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['manifest_uom_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['manifest_required_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['waste_profile_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['estimated_quantity_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['quantity']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['estimated_total_amount']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['close_amount_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['total_amount']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['hide_price_from_paperwork_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['cost_price']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['list_price']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['customer_certificates']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['transporter_certificates']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['consignee_certificates']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['shipper_certificates']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['ht_manifest_revenuelineitems_1_name']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['waste_profile_relate_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['manifest_additional_info_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['worst_case']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['likely_case']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['best_case']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['probability']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['sales_stage']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
$dictionary['RevenueLineItem']['fields']['date_closed']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
// Bit different
$dictionary['RevenueLineItem']['fields']['bundle_total_c']['dependency'] = 'equal($is_bundle_product_c,"parent")';
$dictionary['RevenueLineItem']['fields']['related_rli_total_c']['dependency'] = 'equal($is_bundle_product_c,"parent")';
