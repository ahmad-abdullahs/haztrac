<?php
// created: 2020-04-05 12:57:47
$dictionary["contracts_template_contract_specification"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'contracts_template_contract_specification' => 
    array (
      'lhs_module' => 'Contracts_Template',
      'lhs_table' => 'contracts_template',
      'lhs_key' => 'id',
      'rhs_module' => 'contract_specification',
      'rhs_table' => 'contract_specification',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'contracts_template_contract_specification_c',
      'join_key_lhs' => 'contracts_template_contract_specificationcontracts_template_ida',
      'join_key_rhs' => 'contracts_e240ication_idb',
    ),
  ),
  'table' => 'contracts_template_contract_specification_c',
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
    'contracts_template_contract_specificationcontracts_template_ida' => 
    array (
      'name' => 'contracts_template_contract_specificationcontracts_template_ida',
      'type' => 'id',
    ),
    'contracts_e240ication_idb' => 
    array (
      'name' => 'contracts_e240ication_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_contracts_template_contract_specification_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_contracts_template_contract_specification_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'contracts_template_contract_specificationcontracts_template_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_contracts_template_contract_specification_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'contracts_e240ication_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'contracts_template_contract_specification_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'contracts_e240ication_idb',
      ),
    ),
  ),
);