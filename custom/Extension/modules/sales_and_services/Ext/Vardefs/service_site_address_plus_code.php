<?php

$dictionary['sales_and_services']['fields']['service_site_address_plus_code_cb'] = array(
    'name' => 'service_site_address_plus_code_cb',
    'vname' => 'LBL_ADD_PLUS_CODE',
    'label' => 'LBL_ADD_PLUS_CODE',
    'text' => 'LBL_ADD_PLUS_CODE',
    'type' => 'bool',
    'default' => '0',
);

$dictionary['sales_and_services']['fields']['service_site_address_plus_code_val'] = array(
    'name' => 'service_site_address_plus_code_val',
    'vname' => 'LBL_PLUS_CODE_VAL',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'service_site_address',
    'comment' => 'The name used for service site address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
);

$dictionary['sales_and_services']['fields']['service_site_address_lat'] = array(
    'name' => 'service_site_address_lat',
    'vname' => 'LBL_LAT',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'service_site_address',
);

$dictionary['sales_and_services']['fields']['service_site_address_lon'] = array(
    'name' => 'service_site_address_lon',
    'vname' => 'LBL_LON',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'service_site_address',
);
