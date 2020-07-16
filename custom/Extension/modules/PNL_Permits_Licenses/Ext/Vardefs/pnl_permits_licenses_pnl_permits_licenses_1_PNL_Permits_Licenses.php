<?php
// created: 2020-07-11 22:42:18
$dictionary["PNL_Permits_Licenses"]["fields"]["pnl_permits_licenses_pnl_permits_licenses_1"] = array (
  'name' => 'pnl_permits_licenses_pnl_permits_licenses_1',
  'type' => 'link',
  'relationship' => 'pnl_permits_licenses_pnl_permits_licenses_1',
  'source' => 'non-db',
  'module' => 'PNL_Permits_Licenses',
  'bean_name' => 'PNL_Permits_Licenses',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_PNL_PERMITS_LICENSES_1_FROM_PNL_PERMITS_LICENSES_L_TITLE',
  'id_name' => 'pnl_permit6196icenses_idb',
  'link-type' => 'many',
  'side' => 'left',
);
$dictionary["PNL_Permits_Licenses"]["fields"]["pnl_permits_licenses_pnl_permits_licenses_1_right"] = array (
  'name' => 'pnl_permits_licenses_pnl_permits_licenses_1_right',
  'type' => 'link',
  'relationship' => 'pnl_permits_licenses_pnl_permits_licenses_1',
  'source' => 'non-db',
  'module' => 'PNL_Permits_Licenses',
  'bean_name' => 'PNL_Permits_Licenses',
  'side' => 'right',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_PNL_PERMITS_LICENSES_1_FROM_PNL_PERMITS_LICENSES_R_TITLE',
  'id_name' => 'pnl_permitfbdeicenses_ida',
  'link-type' => 'one',
);
$dictionary["PNL_Permits_Licenses"]["fields"]["pnl_permits_licenses_pnl_permits_licenses_1_name"] = array (
  'name' => 'pnl_permits_licenses_pnl_permits_licenses_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_PNL_PERMITS_LICENSES_1_FROM_PNL_PERMITS_LICENSES_L_TITLE',
  'save' => true,
  'id_name' => 'pnl_permitfbdeicenses_ida',
  'link' => 'pnl_permits_licenses_pnl_permits_licenses_1_right',
  'table' => 'pnl_permits_licenses',
  'module' => 'PNL_Permits_Licenses',
  'rname' => 'document_name',
);
$dictionary["PNL_Permits_Licenses"]["fields"]["pnl_permitfbdeicenses_ida"] = array (
  'name' => 'pnl_permitfbdeicenses_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_PNL_PERMITS_LICENSES_1_FROM_PNL_PERMITS_LICENSES_R_TITLE_ID',
  'id_name' => 'pnl_permitfbdeicenses_ida',
  'link' => 'pnl_permits_licenses_pnl_permits_licenses_1_right',
  'table' => 'pnl_permits_licenses',
  'module' => 'PNL_Permits_Licenses',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
