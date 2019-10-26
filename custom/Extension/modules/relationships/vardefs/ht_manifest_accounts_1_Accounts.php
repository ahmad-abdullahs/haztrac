<?php
// created: 2019-10-26 01:18:46
$dictionary["Account"]["fields"]["ht_manifest_accounts_1"] = array (
  'name' => 'ht_manifest_accounts_1',
  'type' => 'link',
  'relationship' => 'ht_manifest_accounts_1',
  'source' => 'non-db',
  'module' => 'HT_Manifest',
  'bean_name' => 'HT_Manifest',
  'side' => 'right',
  'vname' => 'LBL_HT_MANIFEST_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'ht_manifest_accounts_1ht_manifest_ida',
  'link-type' => 'one',
);
$dictionary["Account"]["fields"]["ht_manifest_accounts_1_name"] = array (
  'name' => 'ht_manifest_accounts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_HT_MANIFEST_ACCOUNTS_1_FROM_HT_MANIFEST_TITLE',
  'save' => true,
  'id_name' => 'ht_manifest_accounts_1ht_manifest_ida',
  'link' => 'ht_manifest_accounts_1',
  'table' => 'ht_manifest',
  'module' => 'HT_Manifest',
  'rname' => 'name',
);
$dictionary["Account"]["fields"]["ht_manifest_accounts_1ht_manifest_ida"] = array (
  'name' => 'ht_manifest_accounts_1ht_manifest_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_HT_MANIFEST_ACCOUNTS_1_FROM_ACCOUNTS_TITLE_ID',
  'id_name' => 'ht_manifest_accounts_1ht_manifest_ida',
  'link' => 'ht_manifest_accounts_1',
  'table' => 'ht_manifest',
  'module' => 'HT_Manifest',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
