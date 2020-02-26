<?php
// created: 2020-02-26 05:22:44
$dictionary["contracts_contract_specification_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'contracts_contract_specification_1' => 
    array (
      'lhs_module' => 'Contracts',
      'lhs_table' => 'contracts',
      'lhs_key' => 'id',
      'rhs_module' => 'contract_specification',
      'rhs_table' => 'contract_specification',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'contracts_contract_specification_1_c',
      'join_key_lhs' => 'contracts_contract_specification_1contracts_ida',
      'join_key_rhs' => 'contracts_contract_specification_1contract_specification_idb',
    ),
  ),
  'table' => 'contracts_contract_specification_1_c',
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
    'contracts_contract_specification_1contracts_ida' => 
    array (
      'name' => 'contracts_contract_specification_1contracts_ida',
      'type' => 'id',
    ),
    'contracts_contract_specification_1contract_specification_idb' => 
    array (
      'name' => 'contracts_contract_specification_1contract_specification_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_contracts_contract_specification_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_contracts_contract_specification_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'contracts_contract_specification_1contracts_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_contracts_contract_specification_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'contracts_contract_specification_1contract_specification_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'contracts_contract_specification_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'contracts_contract_specification_1contract_specification_idb',
      ),
    ),
  ),
);