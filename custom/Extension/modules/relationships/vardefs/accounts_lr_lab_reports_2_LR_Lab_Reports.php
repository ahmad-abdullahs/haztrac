<?php
// created: 2019-07-02 05:31:13
$dictionary["LR_Lab_Reports"]["fields"]["accounts_lr_lab_reports_2"] = array (
  'name' => 'accounts_lr_lab_reports_2',
  'type' => 'link',
  'relationship' => 'accounts_lr_lab_reports_2',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_2_FROM_LR_LAB_REPORTS_TITLE',
  'id_name' => 'accounts_lr_lab_reports_2accounts_ida',
  'link-type' => 'one',
);
$dictionary["LR_Lab_Reports"]["fields"]["accounts_lr_lab_reports_2_name"] = array (
  'name' => 'accounts_lr_lab_reports_2_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_2_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'accounts_lr_lab_reports_2accounts_ida',
  'link' => 'accounts_lr_lab_reports_2',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["LR_Lab_Reports"]["fields"]["accounts_lr_lab_reports_2accounts_ida"] = array (
  'name' => 'accounts_lr_lab_reports_2accounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_2_FROM_LR_LAB_REPORTS_TITLE_ID',
  'id_name' => 'accounts_lr_lab_reports_2accounts_ida',
  'link' => 'accounts_lr_lab_reports_2',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
