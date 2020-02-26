<?php
// created: 2020-02-26 05:22:44
$dictionary["contract_specification"]["fields"]["contracts_contract_specification_1"] = array (
  'name' => 'contracts_contract_specification_1',
  'type' => 'link',
  'relationship' => 'contracts_contract_specification_1',
  'source' => 'non-db',
  'module' => 'Contracts',
  'bean_name' => 'Contract',
  'side' => 'right',
  'vname' => 'LBL_CONTRACTS_CONTRACT_SPECIFICATION_1_FROM_CONTRACT_SPECIFICATION_TITLE',
  'id_name' => 'contracts_contract_specification_1contracts_ida',
  'link-type' => 'one',
);
$dictionary["contract_specification"]["fields"]["contracts_contract_specification_1_name"] = array (
  'name' => 'contracts_contract_specification_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CONTRACTS_CONTRACT_SPECIFICATION_1_FROM_CONTRACTS_TITLE',
  'save' => true,
  'id_name' => 'contracts_contract_specification_1contracts_ida',
  'link' => 'contracts_contract_specification_1',
  'table' => 'contracts',
  'module' => 'Contracts',
  'rname' => 'name',
);
$dictionary["contract_specification"]["fields"]["contracts_contract_specification_1contracts_ida"] = array (
  'name' => 'contracts_contract_specification_1contracts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_CONTRACTS_CONTRACT_SPECIFICATION_1_FROM_CONTRACT_SPECIFICATION_TITLE_ID',
  'id_name' => 'contracts_contract_specification_1contracts_ida',
  'link' => 'contracts_contract_specification_1',
  'table' => 'contracts',
  'module' => 'Contracts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
