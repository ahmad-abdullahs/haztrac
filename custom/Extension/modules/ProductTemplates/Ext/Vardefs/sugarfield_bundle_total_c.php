<?php

// created: 2019-08-26 12:45:37
$dictionary['ProductTemplate']['fields']['bundle_total_c']['duplicate_merge_dom_value'] = 0;
$dictionary['ProductTemplate']['fields']['bundle_total_c']['labelValue'] = 'Bundle Total';
$dictionary['ProductTemplate']['fields']['bundle_total_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['ProductTemplate']['fields']['bundle_total_c']['calculated'] = 'true';
$dictionary['ProductTemplate']['fields']['bundle_total_c']['formula'] = 'rollupSum($product_templates_product_templates_1,"discount_price")';
$dictionary['ProductTemplate']['fields']['bundle_total_c']['enforced'] = 'true';
$dictionary['ProductTemplate']['fields']['bundle_total_c']['dependency'] = '';
