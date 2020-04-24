<?php

$dictionary['Account']['fields']['shipping_address_plus_code_cb'] = array(
    'name' => 'shipping_address_plus_code_cb',
    'vname' => 'LBL_ADD_PLUS_CODE',
    'label' => 'LBL_ADD_PLUS_CODE',
    'text' => 'LBL_ADD_PLUS_CODE',
    'type' => 'bool',
    'default' => '0',
);

$dictionary['Account']['fields']['shipping_address_plus_code_val'] = array(
    'name' => 'shipping_address_plus_code_val',
    'vname' => 'LBL_PLUS_CODE_VAL',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'shipping_address',
    'comment' => 'The name used for service site address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
);

$dictionary['Account']['fields']['shipping_address_lat'] = array(
    'name' => 'shipping_address_lat',
    'vname' => 'LBL_LAT',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'shipping_address',
);

$dictionary['Account']['fields']['shipping_address_lon'] = array(
    'name' => 'shipping_address_lon',
    'vname' => 'LBL_LON',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'shipping_address',
);
