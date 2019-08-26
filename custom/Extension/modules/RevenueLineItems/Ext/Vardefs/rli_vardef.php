<?php

$dictionary['RevenueLineItem']['importable'] = true;
$dictionary['RevenueLineItem']['unified_search'] = true;

// Need to review this at later stage...
unset($dictionary['RevenueLineItem']['fields']['discount_price']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_price']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_price']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['discount_rate_percent']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_rate_percent']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_rate_percent']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['discount_amount_usdollar']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_amount_usdollar']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_amount_usdollar']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['discount_amount_usdollar']['readonly']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc']['formula']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc_usdollar']['formula']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc_usdollar']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc_usdollar']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['deal_calc_usdollar']['readonly']);
unset($dictionary['RevenueLineItem']['fields']['discount_usdollar']['formula']);
unset($dictionary['RevenueLineItem']['fields']['discount_usdollar']['calculated']);
unset($dictionary['RevenueLineItem']['fields']['discount_usdollar']['enforced']);
unset($dictionary['RevenueLineItem']['fields']['discount_usdollar']['readonly']);
