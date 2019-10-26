<?php

// created: 2019-10-26 01:18:46
$dictionary["ht_manifest_accounts_1"] = array(
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' =>
    array(
        'ht_manifest_accounts_1' =>
        array(
            'lhs_module' => 'HT_Manifest',
            'lhs_table' => 'ht_manifest',
            'lhs_key' => 'id',
            'rhs_module' => 'Accounts',
            'rhs_table' => 'accounts',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'ht_manifest_accounts_1_c',
            'join_key_lhs' => 'ht_manifest_accounts_1ht_manifest_ida',
            'join_key_rhs' => 'ht_manifest_accounts_1accounts_idb',
        ),
    ),
    'table' => 'ht_manifest_accounts_1_c',
    'fields' =>
    array(
        'id' =>
        array(
            'name' => 'id',
            'type' => 'id',
        ),
        'date_modified' =>
        array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' =>
        array(
            'name' => 'deleted',
            'type' => 'bool',
            'default' => 0,
        ),
        'ht_manifest_accounts_1ht_manifest_ida' =>
        array(
            'name' => 'ht_manifest_accounts_1ht_manifest_ida',
            'type' => 'id',
        ),
        'ht_manifest_accounts_1accounts_idb' =>
        array(
            'name' => 'ht_manifest_accounts_1accounts_idb',
            'type' => 'id',
        ),
        'transfer_date' =>
        array(
            'name' => 'transfer_date',
            'type' => 'date',
        ),
    ),
    'indices' =>
    array(
        0 =>
        array(
            'name' => 'idx_ht_manifest_accounts_1_pk',
            'type' => 'primary',
            'fields' =>
            array(
                0 => 'id',
            ),
        ),
        1 =>
        array(
            'name' => 'idx_ht_manifest_accounts_1_ida1_deleted',
            'type' => 'index',
            'fields' =>
            array(
                0 => 'ht_manifest_accounts_1ht_manifest_ida',
                1 => 'deleted',
            ),
        ),
        2 =>
        array(
            'name' => 'idx_ht_manifest_accounts_1_idb2_deleted',
            'type' => 'index',
            'fields' =>
            array(
                0 => 'ht_manifest_accounts_1accounts_idb',
                1 => 'deleted',
            ),
        ),
        3 =>
        array(
            'name' => 'ht_manifest_accounts_1_alt',
            'type' => 'alternate_key',
            'fields' =>
            array(
                0 => 'ht_manifest_accounts_1accounts_idb',
            ),
        ),
    ),
);
