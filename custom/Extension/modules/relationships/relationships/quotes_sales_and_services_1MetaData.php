<?php
// created: 2019-02-18 04:46:18
$dictionary["quotes_sales_and_services_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'quotes_sales_and_services_1' => 
    array (
      'lhs_module' => 'Quotes',
      'lhs_table' => 'quotes',
      'lhs_key' => 'id',
      'rhs_module' => 'sales_and_services',
      'rhs_table' => 'sales_and_services',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'quotes_sales_and_services_1_c',
      'join_key_lhs' => 'quotes_sales_and_services_1quotes_ida',
      'join_key_rhs' => 'quotes_sales_and_services_1sales_and_services_idb',
    ),
  ),
  'table' => 'quotes_sales_and_services_1_c',
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
    'quotes_sales_and_services_1quotes_ida' => 
    array (
      'name' => 'quotes_sales_and_services_1quotes_ida',
      'type' => 'id',
    ),
    'quotes_sales_and_services_1sales_and_services_idb' => 
    array (
      'name' => 'quotes_sales_and_services_1sales_and_services_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_quotes_sales_and_services_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_quotes_sales_and_services_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'quotes_sales_and_services_1quotes_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_quotes_sales_and_services_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'quotes_sales_and_services_1sales_and_services_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'quotes_sales_and_services_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'quotes_sales_and_services_1sales_and_services_idb',
      ),
    ),
  ),
);