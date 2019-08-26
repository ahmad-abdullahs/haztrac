<?php

// created: 2019-08-26 21:22:00
$dictionary['RevenueLineItem']['fields']['related_rli_total_c']['duplicate_merge_dom_value'] = 0;
$dictionary['RevenueLineItem']['fields']['related_rli_total_c']['labelValue'] = 'Related RLI Total';
$dictionary['RevenueLineItem']['fields']['related_rli_total_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['RevenueLineItem']['fields']['related_rli_total_c']['calculated'] = '1';
$dictionary['RevenueLineItem']['fields']['related_rli_total_c']['formula'] = 'rollupSum($revenuelineitems_revenuelineitems_1,"total_amount")';
$dictionary['RevenueLineItem']['fields']['related_rli_total_c']['enforced'] = '1';
$dictionary['RevenueLineItem']['fields']['related_rli_total_c']['dependency'] = '';
