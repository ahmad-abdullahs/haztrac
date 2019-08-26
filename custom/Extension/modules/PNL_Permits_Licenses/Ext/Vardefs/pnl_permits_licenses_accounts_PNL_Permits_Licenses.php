<?php
// created: 2019-08-24 21:35:29
$dictionary["PNL_Permits_Licenses"]["fields"]["pnl_permits_licenses_accounts"] = array (
  'name' => 'pnl_permits_licenses_accounts',
  'type' => 'link',
  'relationship' => 'pnl_permits_licenses_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'id_name' => 'pnl_permits_licenses_accountsaccounts_idb',
);
$dictionary["PNL_Permits_Licenses"]["fields"]["pnl_permits_licenses_accounts_name"] = array (
  'name' => 'pnl_permits_licenses_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'pnl_permits_licenses_accountsaccounts_idb',
  'link' => 'pnl_permits_licenses_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["PNL_Permits_Licenses"]["fields"]["pnl_permits_licenses_accountsaccounts_idb"] = array (
  'name' => 'pnl_permits_licenses_accountsaccounts_idb',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_ACCOUNTS_FROM_ACCOUNTS_TITLE_ID',
  'id_name' => 'pnl_permits_licenses_accountsaccounts_idb',
  'link' => 'pnl_permits_licenses_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
