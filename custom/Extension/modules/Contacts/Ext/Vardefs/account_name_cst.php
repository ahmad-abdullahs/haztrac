<?php

/*
 * These fields are added to avoid the primary_only restriction in the accounts link.
 * Due to this resriction it was only showing the primary contacts in the selection drawer 
 * when it is pulled for accounts_contact_role_widget field.
 *  */
$dictionary["Contact"]["fields"]["account_name_cst"] = array(
    'name' => 'account_name_cst',
    'rname' => 'name',
    'id_name' => 'account_id_cst',
    'vname' => 'LBL_ACCOUNT_NAME',
    'join_name' => 'accounts',
    'type' => 'relate',
    'link' => 'accounts_cst',
    'table' => 'accounts',
    'isnull' => 'true',
    'module' => 'Accounts',
    'dbType' => 'varchar',
    'len' => '255',
    'source' => 'non-db',
    'unified_search' => true,
    'populate_list' =>
    array(
        'billing_address_street' => 'primary_address_street',
        'billing_address_city' => 'primary_address_city',
        'billing_address_state' => 'primary_address_state',
        'billing_address_postalcode' => 'primary_address_postalcode',
        'billing_address_country' => 'primary_address_country',
        'phone_office' => 'phone_work',
        'team_name' => 'team_name',
    ),
    'populate_confirm_label' => 'TPL_OVERWRITE_POPULATED_DATA_CONFIRM_WITH_MODULE_SINGULAR',
    'importable' => 'true',
    'exportable' => true,
    'export_link_type' => 'one',
);

$dictionary["Contact"]["fields"]["account_id_cst"] = array(
    'name' => 'account_id_cst',
    'rname' => 'id',
    'id_name' => 'account_id_cst',
    'vname' => 'LBL_ACCOUNT_ID',
    'type' => 'relate',
    'table' => 'accounts',
    'isnull' => 'true',
    'module' => 'Accounts',
    'dbType' => 'id',
    'reportable' => false,
    'source' => 'non-db',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
    'link' => 'accounts_cst',
);

$dictionary["Contact"]["fields"]["accounts_cst"] = array(
    'name' => 'accounts_cst',
    'type' => 'link',
    'relationship' => 'accounts_contacts',
    'link_type' => 'one',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNT',
    'duplicate_merge' => 'disabled',
);
