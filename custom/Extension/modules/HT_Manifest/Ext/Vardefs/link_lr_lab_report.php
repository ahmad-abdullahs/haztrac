<?php

$dictionary["HT_Manifest"]["fields"]["link_lr_lab_report_name"] = array(
    'labelValue' => 'Lab Report (Link Only)',
    'source' => 'non-db',
    'name' => 'link_lr_lab_report_name',
    'vname' => 'LBL_LINK_LR_LAB_REPORT_NAME',
    'type' => 'relate',
    'len' => 255,
    'size' => '20',
    'id_name' => 'link_lr_lab_report_id',
    'module' => 'LR_Lab_Reports',
    'rname' => 'name',
    'quicksearch' => 'enabled',
    'studio' => 'visible',
);

$dictionary["HT_Manifest"]["fields"]["link_lr_lab_report_id"] = array(
    'required' => false,
    'source' => 'db',
    'name' => 'link_lr_lab_report_id',
    'vname' => 'LBL_LINK_LR_LAB_REPORT_ID',
    'type' => 'id',
    'len' => 36,
    'size' => '20',
    'studio' => 'false',
);
