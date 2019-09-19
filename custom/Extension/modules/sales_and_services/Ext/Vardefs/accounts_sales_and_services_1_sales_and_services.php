<?php

// created: 2019-02-18 04:39:54
$dictionary["sales_and_services"]["fields"]["accounts_sales_and_services_1"] = array(
    'name' => 'accounts_sales_and_services_1',
    'type' => 'link',
    'relationship' => 'accounts_sales_and_services_1',
    'source' => 'non-db',
    'module' => 'Accounts',
    'bean_name' => 'Account',
    'side' => 'right',
    'vname' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
    'id_name' => 'accounts_sales_and_services_1accounts_ida',
    'link-type' => 'one',
);
$dictionary["sales_and_services"]["fields"]["accounts_sales_and_services_1_name"] = array(
    'name' => 'accounts_sales_and_services_1_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_ACCOUNTS_TITLE',
    'save' => true,
    'required' => true,
    'id_name' => 'accounts_sales_and_services_1accounts_ida',
    'link' => 'accounts_sales_and_services_1',
    'table' => 'accounts',
    'module' => 'Accounts',
    'rname' => 'name',
    'auto_populate' => true,
    'populate_list' => array(
        'billing_address_street' => 'billing_address_street_c',
        'billing_address_city' => 'billing_address_city_c',
        'billing_address_state' => 'billing_address_state_c',
        'billing_address_postalcode' => 'billing_address_postalcode_c',
        'billing_address_country' => 'billing_address_postalcode_c',
        'shipping_address_street' => 'shipping_address_street_c',
        'shipping_address_city' => 'shipping_address_city_c',
        'shipping_address_state' => 'shipping_address_state_c',
        'shipping_address_postalcode' => 'shipping_address_postalcode_c',
        'shipping_address_country' => 'shipping_address_postalcode_c',
        'account_terms_c' => 'account_terms_c',
        'team_name' => 'team_name',
        'service_instruction_c' => 'instructions_notes_c',
    ),
);
$dictionary["sales_and_services"]["fields"]["accounts_sales_and_services_1accounts_ida"] = array(
    'name' => 'accounts_sales_and_services_1accounts_ida',
    'type' => 'id',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE_ID',
    'id_name' => 'accounts_sales_and_services_1accounts_ida',
    'link' => 'accounts_sales_and_services_1',
    'table' => 'accounts',
    'module' => 'Accounts',
    'rname' => 'id',
    'reportable' => false,
    'side' => 'right',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
);
