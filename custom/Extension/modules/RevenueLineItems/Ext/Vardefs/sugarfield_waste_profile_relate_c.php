<?php

// created: 2020-01-26 16:24:29
$dictionary['RevenueLineItem']['fields']['waste_profile_relate_c']['labelValue'] = 'Waste Profile';
$dictionary['RevenueLineItem']['fields']['waste_profile_relate_c']['dependency'] = 'equal($waste_profile_c,true)';
$dictionary['RevenueLineItem']['fields']['waste_profile_relate_c']['initial_filter'] = 'filterByGenerator';
$dictionary['RevenueLineItem']['fields']['waste_profile_relate_c']['initial_filter_label'] = 'LBL_FILTER_BY_GENERATOR';
$dictionary['RevenueLineItem']['fields']['waste_profile_relate_c']['filter_relate'] = array(
    'account_id' => 'accounts_wpm_waste_profile_module_2accounts_ida'
);
