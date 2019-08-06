<?php
// created: 2015-11-10 09:16:50
$dictionary["bc_quotecategory_bc_quote"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'bc_quotecategory_bc_quote' => 
    array (
      'lhs_module' => 'bc_QuoteCategory',
      'lhs_table' => 'bc_quotecategory',
      'lhs_key' => 'id',
      'rhs_module' => 'bc_Quote',
      'rhs_table' => 'bc_quote',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'bc_quotecategory_bc_quote_c',
      'join_key_lhs' => 'bc_quotecategory_bc_quotebc_quotecategory_ida',
      'join_key_rhs' => 'bc_quotecategory_bc_quotebc_quote_idb',
    ),
  ),
  'table' => 'bc_quotecategory_bc_quote_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
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
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    'bc_quotecategory_bc_quotebc_quotecategory_ida' => 
    array (
      'name' => 'bc_quotecategory_bc_quotebc_quotecategory_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    'bc_quotecategory_bc_quotebc_quote_idb' => 
    array (
      'name' => 'bc_quotecategory_bc_quotebc_quote_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'bc_quotecategory_bc_quotespk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'bc_quotecategory_bc_quote_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'bc_quotecategory_bc_quotebc_quotecategory_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'bc_quotecategory_bc_quote_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'bc_quotecategory_bc_quotebc_quote_idb',
      ),
    ),
  ),
);