<?php
// created: 2020-07-31 05:01:49
$dictionary["competitor_cost"]["fields"]["accounts_competitor_cost_1"] = array (
  'name' => 'accounts_competitor_cost_1',
  'type' => 'link',
  'relationship' => 'accounts_competitor_cost_1',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_COMPETITOR_COST_1_FROM_COMPETITOR_COST_TITLE',
  'id_name' => 'accounts_competitor_cost_1accounts_ida',
  'link-type' => 'one',
);
$dictionary["competitor_cost"]["fields"]["accounts_competitor_cost_1_name"] = array (
  'name' => 'accounts_competitor_cost_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_COMPETITOR_COST_1_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_competitor_cost_1accounts_ida',
  'link' => 'accounts_competitor_cost_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["competitor_cost"]["fields"]["accounts_competitor_cost_1accounts_ida"] = array (
  'name' => 'accounts_competitor_cost_1accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_COMPETITOR_COST_1_FROM_COMPETITOR_COST_TITLE_ID',
  'id_name' => 'accounts_competitor_cost_1accounts_ida',
  'link' => 'accounts_competitor_cost_1',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
