<?php

// created: 2019-07-02 05:31:13
$dictionary["LR_Lab_Reports"]["fields"]["accounts_lr_lab_reports_3"] = array(
    'name' => 'accounts_lr_lab_reports_3',
    'type' => 'link',
    'relationship' => 'accounts_lr_lab_reports_3',
    'source' => 'non-db',
    'module' => 'Accounts',
    'bean_name' => 'Account',
    'side' => 'right',
    'vname' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_LR_LAB_REPORTS_TITLE',
    'id_name' => 'accounts_lr_lab_reports_3accounts_ida',
    'link-type' => 'one',
);
$dictionary["LR_Lab_Reports"]["fields"]["accounts_lr_lab_reports_3_name"] = array(
    'name' => 'accounts_lr_lab_reports_3_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_ACCOUNTS_TITLE_CST',
    'save' => true,
    'id_name' => 'accounts_lr_lab_reports_3accounts_ida',
    'link' => 'accounts_lr_lab_reports_3',
    'table' => 'accounts',
    'module' => 'Accounts',
    'rname' => 'name',
    'default' => 'Botavia Energy, LLC',
    'dependency' => '',
    'massupdate' => true,
);
$dictionary["LR_Lab_Reports"]["fields"]["accounts_lr_lab_reports_3accounts_ida"] = array(
    'name' => 'accounts_lr_lab_reports_3accounts_ida',
    'type' => 'id',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_LR_LAB_REPORTS_TITLE_ID',
    'id_name' => 'accounts_lr_lab_reports_3accounts_ida',
    'link' => 'accounts_lr_lab_reports_3',
    'table' => 'accounts',
    'module' => 'Accounts',
    'rname' => 'id',
    'reportable' => false,
    'side' => 'right',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
    'default' => '2161dbfa-9cfb-11e9-a1da-000c29e77cbc',
);
