<?php
 // created: 2019-06-17 16:45:12
$dictionary['RevenueLineItem']['fields']['total_amount']['audited'] = false;
$dictionary['RevenueLineItem']['fields']['total_amount']['massupdate'] = false;
$dictionary['RevenueLineItem']['fields']['total_amount']['importable'] = 'false';
$dictionary['RevenueLineItem']['fields']['total_amount']['duplicate_merge'] = 'disabled';
$dictionary['RevenueLineItem']['fields']['total_amount']['duplicate_merge_dom_value'] = 0;
$dictionary['RevenueLineItem']['fields']['total_amount']['merge_filter'] = 'disabled';
$dictionary['RevenueLineItem']['fields']['total_amount']['calculated'] = '1';
$dictionary['RevenueLineItem']['fields']['total_amount']['formula'] = 'multiply($charge_c,ifElse(equal($quantity,0),$estimated_quantity_c,$quantity))';
$dictionary['RevenueLineItem']['fields']['total_amount']['related_fields'][0] = 'currency_id';
$dictionary['RevenueLineItem']['fields']['total_amount']['related_fields'][1] = 'base_rate';
$dictionary['RevenueLineItem']['fields']['total_amount']['enable_range_search'] = false;

