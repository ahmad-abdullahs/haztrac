<?php
// created: 2019-02-18 04:48:48
$dictionary["contracts_sales_and_services_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'contracts_sales_and_services_1' => 
    array (
      'lhs_module' => 'Contracts',
      'lhs_table' => 'contracts',
      'lhs_key' => 'id',
      'rhs_module' => 'sales_and_services',
      'rhs_table' => 'sales_and_services',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'contracts_sales_and_services_1_c',
      'join_key_lhs' => 'contracts_sales_and_services_1contracts_ida',
      'join_key_rhs' => 'contracts_sales_and_services_1sales_and_services_idb',
    ),
  ),
  'table' => 'contracts_sales_and_services_1_c',
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
    'contracts_sales_and_services_1contracts_ida' => 
    array (
      'name' => 'contracts_sales_and_services_1contracts_ida',
      'type' => 'id',
    ),
    'contracts_sales_and_services_1sales_and_services_idb' => 
    array (
      'name' => 'contracts_sales_and_services_1sales_and_services_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_contracts_sales_and_services_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_contracts_sales_and_services_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'contracts_sales_and_services_1contracts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_contracts_sales_and_services_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'contracts_sales_and_services_1sales_and_services_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'contracts_sales_and_services_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'contracts_sales_and_services_1sales_and_services_idb',
      ),
    ),
  ),
);