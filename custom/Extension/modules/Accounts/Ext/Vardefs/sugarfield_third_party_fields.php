<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dictionary['Account']['fields']['billing_address_third_party_name'] = array(
    'name' => 'billing_address_third_party_name',
    'vname' => 'LBL_BILLING_ADDRESS_THIRD_PARTY_NAME',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'billing_address',
    'comment' => 'The state used for billing address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
);

$dictionary['Account']['fields']['shipping_address_third_party_name'] = array(
    'name' => 'shipping_address_third_party_name',
    'vname' => 'LBL_SHIPPING_ADDRESS_THIRD_PARTY_NAME',
    'type' => 'varchar',
    'len' => '100',
    'group' => 'shipping_address',
    'comment' => 'The state used for shipping address',
    'merge_filter' => 'enabled',
    'duplicate_on_record_copy' => 'always',
);
