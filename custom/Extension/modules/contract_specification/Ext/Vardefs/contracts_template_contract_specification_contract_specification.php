<?php
// created: 2020-04-05 12:57:47
$dictionary["contract_specification"]["fields"]["contracts_template_contract_specification"] = array (
  'name' => 'contracts_template_contract_specification',
  'type' => 'link',
  'relationship' => 'contracts_template_contract_specification',
  'source' => 'non-db',
  'module' => 'Contracts_Template',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_CONTRACTS_TEMPLATE_CONTRACT_SPECIFICATION_FROM_CONTRACT_SPECIFICATION_TITLE',
  'id_name' => 'contracts_template_contract_specificationcontracts_template_ida',
  'link-type' => 'one',
);
$dictionary["contract_specification"]["fields"]["contracts_template_contract_specification_name"] = array (
  'name' => 'contracts_template_contract_specification_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CONTRACTS_TEMPLATE_CONTRACT_SPECIFICATION_FROM_CONTRACTS_TEMPLATE_TITLE',
  'save' => true,
  'id_name' => 'contracts_template_contract_specificationcontracts_template_ida',
  'link' => 'contracts_template_contract_specification',
  'table' => 'contracts_template',
  'module' => 'Contracts_Template',
  'rname' => 'name',
);
$dictionary["contract_specification"]["fields"]["contracts_template_contract_specificationcontracts_template_ida"] = array (
  'name' => 'contracts_template_contract_specificationcontracts_template_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_CONTRACTS_TEMPLATE_CONTRACT_SPECIFICATION_FROM_CONTRACT_SPECIFICATION_TITLE_ID',
  'id_name' => 'contracts_template_contract_specificationcontracts_template_ida',
  'link' => 'contracts_template_contract_specification',
  'table' => 'contracts_template',
  'module' => 'Contracts_Template',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
