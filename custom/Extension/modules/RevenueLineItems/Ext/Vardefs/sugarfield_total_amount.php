<?php

// created: 2019-08-26 16:06:10
$dictionary['RevenueLineItem']['fields']['total_amount']['audited'] = false;
$dictionary['RevenueLineItem']['fields']['total_amount']['massupdate'] = false;
$dictionary['RevenueLineItem']['fields']['total_amount']['importable'] = 'false';
$dictionary['RevenueLineItem']['fields']['total_amount']['duplicate_merge'] = 'disabled';
$dictionary['RevenueLineItem']['fields']['total_amount']['duplicate_merge_dom_value'] = 0;
$dictionary['RevenueLineItem']['fields']['total_amount']['merge_filter'] = 'disabled';
$dictionary['RevenueLineItem']['fields']['total_amount']['calculated'] = '1';
$dictionary['RevenueLineItem']['fields']['total_amount']['formula'] = 'multiply($discount_price,ifElse(equal($quantity,0),$estimated_quantity_c,$quantity))';
$dictionary['RevenueLineItem']['fields']['total_amount']['related_fields'] = array(
    0 => 'currency_id',
    1 => 'base_rate',
);
$dictionary['RevenueLineItem']['fields']['total_amount']['enable_range_search'] = false;
