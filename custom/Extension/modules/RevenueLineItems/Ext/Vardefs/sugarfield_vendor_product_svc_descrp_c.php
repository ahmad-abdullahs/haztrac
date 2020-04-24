<?php

// created: 2020-04-24 22:37:34
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['labelValue'] = 'Vendor Product Description (Buy)';
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['enforced'] = '';
$dictionary['RevenueLineItem']['fields']['vendor_product_svc_descrp_c']['dependency'] = 'not(equal($is_bundle_product_c,"parent"))';
