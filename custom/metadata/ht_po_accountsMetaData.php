<?php
// created: 2019-04-22 16:51:57
$dictionary["ht_po_accounts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'ht_po_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'HT_PO',
      'rhs_table' => 'ht_po',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'ht_po_accounts_c',
      'join_key_lhs' => 'ht_po_accountsaccounts_ida',
      'join_key_rhs' => 'ht_po_accountsht_po_idb',
    ),
  ),
  'table' => 'ht_po_accounts_c',
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
    'ht_po_accountsaccounts_ida' => 
    array (
      'name' => 'ht_po_accountsaccounts_ida',
      'type' => 'id',
    ),
    'ht_po_accountsht_po_idb' => 
    array (
      'name' => 'ht_po_accountsht_po_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_ht_po_accounts_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_ht_po_accounts_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_po_accountsaccounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_ht_po_accounts_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'ht_po_accountsht_po_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'ht_po_accounts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'ht_po_accountsht_po_idb',
      ),
    ),
  ),
);