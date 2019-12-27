<?php

$dictionary['sales_and_services']['fields']['billing_address_third_party_name'] = array(
    'name' => 'billing_address_third_party_name',
    'vname' => 'LBL_BILLING_ADDRESS_THIRD_PARTY_NAME',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'billing_address',
    'comment' => 'The state used for billing address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
);

$dictionary['sales_and_services']['fields']['shipping_address_third_party_name'] = array(
    'name' => 'shipping_address_third_party_name',
    'vname' => 'LBL_SHIPPING_ADDRESS_THIRD_PARTY_NAME',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'shipping_address',
    'comment' => 'The state used for shipping address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
);

$dictionary['sales_and_services']['fields']['service_site_address_name'] = array(
    'name' => 'service_site_address_name',
    'vname' => 'LBL_SERVICE_SITE_NAME',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'service_site_address_c',
    'comment' => 'The name used for service site address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
);
