<?php
// created: 2019-06-03 20:24:59
$dictionary["HT_Manifest"]["fields"]["accounts_ht_manifest_1"] = array (
  'name' => 'accounts_ht_manifest_1',
  'type' => 'link',
  'relationship' => 'accounts_ht_manifest_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_HT_MANIFEST_TITLE',
  'id_name' => 'accounts_ht_manifest_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["HT_Manifest"]["fields"]["accounts_ht_manifest_1_name"] = array (
  'name' => 'accounts_ht_manifest_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_ht_manifest_1accounts_ida',
  'link' => 'accounts_ht_manifest_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["HT_Manifest"]["fields"]["accounts_ht_manifest_1accounts_ida"] = array (
  'name' => 'accounts_ht_manifest_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_HT_MANIFEST_TITLE_ID',
  'id_name' => 'accounts_ht_manifest_1accounts_ida',
  'link' => 'accounts_ht_manifest_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
