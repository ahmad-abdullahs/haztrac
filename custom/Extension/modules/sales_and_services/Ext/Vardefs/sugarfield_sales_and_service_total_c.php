<?php

// created: 2019-08-26 18:37:30
$dictionary['sales_and_services']['fields']['sales_and_service_total_c']['duplicate_merge_dom_value'] = 0;
$dictionary['sales_and_services']['fields']['sales_and_service_total_c']['labelValue'] = 'Sales Total';
$dictionary['sales_and_services']['fields']['sales_and_service_total_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['sales_and_services']['fields']['sales_and_service_total_c']['calculated'] = '1';
$dictionary['sales_and_services']['fields']['sales_and_service_total_c']['formula'] = 'rollupSum($sales_and_services_revenuelineitems_1,"total_amount")';
$dictionary['sales_and_services']['fields']['sales_and_service_total_c']['enforced'] = '1';
$dictionary['sales_and_services']['fields']['sales_and_service_total_c']['dependency'] = '';

//$dictionary['sales_and_services']["fields"]["auto_inc_sale_and_service_num"] = array(
//    'required' => true,
//    'name' => 'auto_inc_sale_and_service_num',
//    'vname' => 'LBL_AUTO_INC_SALE_AND_SERVICE_NUM',
//    'type' => 'int',
//    'massupdate' => 0,
//    'comments' => '',
//    'help' => '',
//    'importable' => 'true',
//    'duplicate_merge' => 'disabled',
//    'duplicate_merge_dom_value' => '0',
//    'audited' => false,
//    'reportable' => true,
//    'calculated' => false,
//    'auto_increment' => true,
//);
//
//$dictionary['sales_and_services']["indices"]["auto_inc_sale_and_service_num"] = array(
//    'name' => 'auto_inc_sale_and_service_num',
//    'type' => 'unique',
//    'fields' => array(
//        'auto_inc_sale_and_service_num'
//    ),
//);
