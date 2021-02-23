<?php
// created: 2021-02-10 13:00:42
$dictionary["accounts_ht_manifest_2"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'accounts_ht_manifest_2' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'HT_Manifest',
      'rhs_table' => 'ht_manifest',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'accounts_ht_manifest_2_c',
      'join_key_lhs' => 'accounts_ht_manifest_2accounts_ida',
      'join_key_rhs' => 'accounts_ht_manifest_2ht_manifest_idb',
    ),
  ),
  'table' => 'accounts_ht_manifest_2_c',
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
    'accounts_ht_manifest_2accounts_ida' => 
    array (
      'name' => 'accounts_ht_manifest_2accounts_ida',
      'type' => 'id',
    ),
    'accounts_ht_manifest_2ht_manifest_idb' => 
    array (
      'name' => 'accounts_ht_manifest_2ht_manifest_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_accounts_ht_manifest_2_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_accounts_ht_manifest_2_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_ht_manifest_2accounts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_accounts_ht_manifest_2_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'accounts_ht_manifest_2ht_manifest_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'accounts_ht_manifest_2_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'accounts_ht_manifest_2ht_manifest_idb',
      ),
    ),
  ),
);