<?php
// created: 2019-02-18 04:39:54
$dictionary["sales_and_services"]["fields"]["accounts_sales_and_services_1"] = array (
  'name' => 'accounts_sales_and_services_1',
  'type' => 'link',
  'relationship' => 'accounts_sales_and_services_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
  'id_name' => 'accounts_sales_and_services_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["sales_and_services"]["fields"]["accounts_sales_and_services_1_name"] = array (
  'name' => 'accounts_sales_and_services_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_sales_and_services_1accounts_ida',
  'link' => 'accounts_sales_and_services_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["sales_and_services"]["fields"]["accounts_sales_and_services_1accounts_ida"] = array (
  'name' => 'accounts_sales_and_services_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE_ID',
  'id_name' => 'accounts_sales_and_services_1accounts_ida',
  'link' => 'accounts_sales_and_services_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
