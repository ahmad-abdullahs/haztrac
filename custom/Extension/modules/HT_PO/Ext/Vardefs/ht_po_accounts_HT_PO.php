<?php
// created: 2019-04-22 16:51:57
$dictionary["HT_PO"]["fields"]["ht_po_accounts"] = array (
  'name' => 'ht_po_accounts',
  'type' => 'link',
  'relationship' => 'ht_po_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_HT_PO_ACCOUNTS_FROM_HT_PO_TITLE',
  'id_name' => 'ht_po_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["HT_PO"]["fields"]["ht_po_accounts_name"] = array (
  'name' => 'ht_po_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_HT_PO_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'ht_po_accountsaccounts_ida',
  'link' => 'ht_po_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["HT_PO"]["fields"]["ht_po_accountsaccounts_ida"] = array (
  'name' => 'ht_po_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_HT_PO_ACCOUNTS_FROM_HT_PO_TITLE_ID',
  'id_name' => 'ht_po_accountsaccounts_ida',
  'link' => 'ht_po_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
