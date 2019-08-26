<?php
// created: 2019-08-24 21:35:29
$dictionary["pnl_permits_licenses_accounts"] = array (
  'true_relationship_type' => 'one-to-one',
  'relationships' => 
  array (
    'pnl_permits_licenses_accounts' => 
    array (
      'lhs_module' => 'PNL_Permits_Licenses',
      'lhs_table' => 'pnl_permits_licenses',
      'lhs_key' => 'id',
      'rhs_module' => 'Accounts',
      'rhs_table' => 'accounts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'pnl_permits_licenses_accounts_c',
      'join_key_lhs' => 'pnl_permits_licenses_accountspnl_permits_licenses_ida',
      'join_key_rhs' => 'pnl_permits_licenses_accountsaccounts_idb',
    ),
  ),
  'table' => 'pnl_permits_licenses_accounts_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'pnl_permits_licenses_accountspnl_permits_licenses_ida' => 
    array (
      'name' => 'pnl_permits_licenses_accountspnl_permits_licenses_ida',
      'type' => 'id',
    ),
    'pnl_permits_licenses_accountsaccounts_idb' => 
    array (
      'name' => 'pnl_permits_licenses_accountsaccounts_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_pnl_permits_licenses_accounts_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_pnl_permits_licenses_accounts_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'pnl_permits_licenses_accountspnl_permits_licenses_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_pnl_permits_licenses_accounts_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'pnl_permits_licenses_accountsaccounts_idb',
        1 => 'deleted',
      ),
    ),
  ),
);