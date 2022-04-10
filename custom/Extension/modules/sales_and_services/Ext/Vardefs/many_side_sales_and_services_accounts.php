<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dictionary["sales_and_services"]["fields"]["destination_ship_to_c"] = array(
    'labelValue' => 'Ship To / TSDF',
    'required' => false,
    'source' => 'non-db',
    'name' => 'destination_ship_to_c',
    'vname' => 'LBL_DESTINATION_SHIP_TO',
    'type' => 'relate',
    'link' => 'sales_and_services_accounts_tsdf',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 255,
    'size' => '20',
    'id_name' => 'account_id1_c',
    'module' => 'Accounts',
    'rname' => 'name',
    'studio' => 'visible',
);

$dictionary["sales_and_services"]["fields"]["account_id1_c"] = array(
    'required' => false,
    'name' => 'account_id1_c',
    'vname' => 'LBL_DESTINATION_SHIP_TO_ACCOUNT_ID',
    'type' => 'id',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => true,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 36,
    'size' => '20',
    'table' => 'accounts',
    'isnull' => 'true',
    'module' => 'Accounts',
    'dbType' => 'id',
);

$dictionary["sales_and_services"]["fields"]["sales_and_services_accounts_tsdf"] = array(
    'name' => 'sales_and_services_accounts_tsdf',
    'type' => 'link',
    'relationship' => 'sales_and_services_accounts_tsdf',
    'module' => 'Accounts',
    'bean_name' => 'Account',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS',
);

$dictionary["sales_and_services"]["relationships"]["sales_and_services_accounts_tsdf"] = array(
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'sales_and_services',
    'rhs_table' => 'sales_and_services',
    'rhs_key' => 'account_id1_c',
    'relationship_type' => 'one-to-many',
);
