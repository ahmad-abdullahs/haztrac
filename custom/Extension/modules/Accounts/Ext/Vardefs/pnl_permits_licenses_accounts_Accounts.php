<?php
// created: 2019-08-24 21:35:29
$dictionary["Account"]["fields"]["pnl_permits_licenses_accounts"] = array (
  'name' => 'pnl_permits_licenses_accounts',
  'type' => 'link',
  'relationship' => 'pnl_permits_licenses_accounts',
  'source' => 'non-db',
  'module' => 'PNL_Permits_Licenses',
  'bean_name' => false,
  'vname' => 'LBL_PNL_PERMITS_LICENSES_ACCOUNTS_FROM_PNL_PERMITS_LICENSES_TITLE',
  'id_name' => 'pnl_permits_licenses_accountspnl_permits_licenses_ida',
);
$dictionary["Account"]["fields"]["pnl_permits_licenses_accounts_name"] = array (
  'name' => 'pnl_permits_licenses_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_ACCOUNTS_FROM_PNL_PERMITS_LICENSES_TITLE',
  'save' => true,
  'id_name' => 'pnl_permits_licenses_accountspnl_permits_licenses_ida',
  'link' => 'pnl_permits_licenses_accounts',
  'table' => 'pnl_permits_licenses',
  'module' => 'PNL_Permits_Licenses',
  'rname' => 'document_name',
);
$dictionary["Account"]["fields"]["pnl_permits_licenses_accountspnl_permits_licenses_ida"] = array (
  'name' => 'pnl_permits_licenses_accountspnl_permits_licenses_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_ACCOUNTS_FROM_PNL_PERMITS_LICENSES_TITLE_ID',
  'id_name' => 'pnl_permits_licenses_accountspnl_permits_licenses_ida',
  'link' => 'pnl_permits_licenses_accounts',
  'table' => 'pnl_permits_licenses',
  'module' => 'PNL_Permits_Licenses',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'left',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
