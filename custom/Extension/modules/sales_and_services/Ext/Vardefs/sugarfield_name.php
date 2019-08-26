<?php

// created: 2019-08-26 21:03:21
$dictionary['sales_and_services']['fields']['name']['len'] = '255';
$dictionary['sales_and_services']['fields']['name']['audited'] = false;
$dictionary['sales_and_services']['fields']['name']['massupdate'] = false;
$dictionary['sales_and_services']['fields']['name']['unified_search'] = false;
$dictionary['sales_and_services']['fields']['name']['full_text_search'] = array(
    'enabled' => true,
    'boost' => '1.55',
    'searchable' => true,
);
$dictionary['sales_and_services']['fields']['name']['calculated'] = '1';
$dictionary['sales_and_services']['fields']['name']['importable'] = 'false';
$dictionary['sales_and_services']['fields']['name']['duplicate_merge'] = 'disabled';
$dictionary['sales_and_services']['fields']['name']['duplicate_merge_dom_value'] = 0;
$dictionary['sales_and_services']['fields']['name']['merge_filter'] = 'disabled';
$dictionary['sales_and_services']['fields']['name']['formula'] = 'concat($ss_number," ",related($sales_and_services_revenuelineitems_1,"name"))';
$dictionary['sales_and_services']['fields']['name']['enforced'] = true;
$dictionary['sales_and_services']['fields']['name']['required'] = false;