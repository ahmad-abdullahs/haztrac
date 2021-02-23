<?php
// created: 2021-02-10 13:00:43
$dictionary["HT_Manifest"]["fields"]["accounts_ht_manifest_2"] = array (
  'name' => 'accounts_ht_manifest_2',
  'type' => 'link',
  'relationship' => 'accounts_ht_manifest_2',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_HT_MANIFEST_2_FROM_HT_MANIFEST_TITLE',
  'id_name' => 'accounts_ht_manifest_2accounts_ida',
  'link-type' => 'one',
);
$dictionary["HT_Manifest"]["fields"]["accounts_ht_manifest_2_name"] = array (
  'name' => 'accounts_ht_manifest_2_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_HT_MANIFEST_2_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_ht_manifest_2accounts_ida',
  'link' => 'accounts_ht_manifest_2',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["HT_Manifest"]["fields"]["accounts_ht_manifest_2accounts_ida"] = array (
  'name' => 'accounts_ht_manifest_2accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_HT_MANIFEST_2_FROM_HT_MANIFEST_TITLE_ID',
  'id_name' => 'accounts_ht_manifest_2accounts_ida',
  'link' => 'accounts_ht_manifest_2',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
