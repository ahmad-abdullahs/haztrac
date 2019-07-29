<?php
// created: 2019-05-21 01:04:21
$dictionary["LR_Lab_Reports"]["fields"]["ht_manifest_lr_lab_reports_1"] = array (
  'name' => 'ht_manifest_lr_lab_reports_1',
  'type' => 'link',
  'relationship' => 'ht_manifest_lr_lab_reports_1',
  'source' => 'non-db',
  'module' => 'HT_Manifest',
  'bean_name' => 'HT_Manifest',
  'side' => 'right',
  'vname' => 'LBL_HT_MANIFEST_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE',
  'id_name' => 'ht_manifest_lr_lab_reports_1ht_manifest_ida',
  'link-type' => 'one',
);
$dictionary["LR_Lab_Reports"]["fields"]["ht_manifest_lr_lab_reports_1_name"] = array (
  'name' => 'ht_manifest_lr_lab_reports_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_HT_MANIFEST_LR_LAB_REPORTS_1_FROM_HT_MANIFEST_TITLE',
  'save' => true,
  'id_name' => 'ht_manifest_lr_lab_reports_1ht_manifest_ida',
  'link' => 'ht_manifest_lr_lab_reports_1',
  'table' => 'ht_manifest',
  'module' => 'HT_Manifest',
  'rname' => 'name',
);
$dictionary["LR_Lab_Reports"]["fields"]["ht_manifest_lr_lab_reports_1ht_manifest_ida"] = array (
  'name' => 'ht_manifest_lr_lab_reports_1ht_manifest_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_HT_MANIFEST_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE_ID',
  'id_name' => 'ht_manifest_lr_lab_reports_1ht_manifest_ida',
  'link' => 'ht_manifest_lr_lab_reports_1',
  'table' => 'ht_manifest',
  'module' => 'HT_Manifest',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
