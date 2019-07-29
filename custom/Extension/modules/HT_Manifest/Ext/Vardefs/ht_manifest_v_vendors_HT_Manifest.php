<?php
// created: 2019-04-29 19:19:52
$dictionary["HT_Manifest"]["fields"]["ht_manifest_v_vendors"] = array (
  'name' => 'ht_manifest_v_vendors',
  'type' => 'link',
  'relationship' => 'ht_manifest_v_vendors',
  'source' => 'non-db',
  'module' => 'V_Vendors',
  'bean_name' => 'V_Vendors',
  'vname' => 'LBL_HT_MANIFEST_V_VENDORS_FROM_V_VENDORS_TITLE',
  'id_name' => 'ht_manifest_v_vendorsv_vendors_idb',
  'side' => 'right',
  'link-type' => 'one',
);
$dictionary["HT_Manifest"]["fields"]["ht_manifest_v_vendors_name"] = array (
  'name' => 'ht_manifest_v_vendors_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_HT_MANIFEST_V_VENDORS_FROM_V_VENDORS_TITLE',
  'save' => true,
  'id_name' => 'ht_manifest_v_vendorsht_manifest_ida',
  'link' => 'ht_manifest_v_vendors',
  'table' => 'v_vendors',
  'module' => 'V_Vendors',
  'rname' => 'name',
);
$dictionary["HT_Manifest"]["fields"]["ht_manifest_v_vendorsht_manifest_ida"] = array (
  'name' => 'ht_manifest_v_vendorsht_manifest_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_HT_MANIFEST_V_VENDORS_FROM_V_VENDORS_TITLE_ID',
  'id_name' => 'ht_manifest_v_vendorsht_manifest_ida',
  'link' => 'ht_manifest_v_vendors',
  'table' => 'v_vendors',
  'module' => 'V_Vendors',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);