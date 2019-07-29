<?php
// created: 2019-02-18 04:48:48
$dictionary["sales_and_services"]["fields"]["contracts_sales_and_services_1"] = array (
  'name' => 'contracts_sales_and_services_1',
  'type' => 'link',
  'relationship' => 'contracts_sales_and_services_1',
  'source' => 'non-db',
  'module' => 'Contracts',
  'bean_name' => 'Contract',
  'side' => 'right',
  'vname' => 'LBL_CONTRACTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
  'id_name' => 'contracts_sales_and_services_1contracts_ida',
  'link-type' => 'one',
);
$dictionary["sales_and_services"]["fields"]["contracts_sales_and_services_1_name"] = array (
  'name' => 'contracts_sales_and_services_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CONTRACTS_SALES_AND_SERVICES_1_FROM_CONTRACTS_TITLE',
  'save' => true,
  'id_name' => 'contracts_sales_and_services_1contracts_ida',
  'link' => 'contracts_sales_and_services_1',
  'table' => 'contracts',
  'module' => 'Contracts',
  'rname' => 'name',
);
$dictionary["sales_and_services"]["fields"]["contracts_sales_and_services_1contracts_ida"] = array (
  'name' => 'contracts_sales_and_services_1contracts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_CONTRACTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE_ID',
  'id_name' => 'contracts_sales_and_services_1contracts_ida',
  'link' => 'contracts_sales_and_services_1',
  'table' => 'contracts',
  'module' => 'Contracts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
