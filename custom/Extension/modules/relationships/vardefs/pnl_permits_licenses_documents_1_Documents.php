<?php
// created: 2021-02-19 15:37:56
$dictionary["Document"]["fields"]["pnl_permits_licenses_documents_1"] = array (
  'name' => 'pnl_permits_licenses_documents_1',
  'type' => 'link',
  'relationship' => 'pnl_permits_licenses_documents_1',
  'source' => 'non-db',
  'module' => 'PNL_Permits_Licenses',
  'bean_name' => 'PNL_Permits_Licenses',
  'side' => 'right',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'id_name' => 'pnl_permits_licenses_documents_1pnl_permits_licenses_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["pnl_permits_licenses_documents_1_name"] = array (
  'name' => 'pnl_permits_licenses_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_DOCUMENTS_1_FROM_PNL_PERMITS_LICENSES_TITLE',
  'save' => true,
  'id_name' => 'pnl_permits_licenses_documents_1pnl_permits_licenses_ida',
  'link' => 'pnl_permits_licenses_documents_1',
  'table' => 'pnl_permits_licenses',
  'module' => 'PNL_Permits_Licenses',
  'rname' => 'document_name',
);
$dictionary["Document"]["fields"]["pnl_permits_licenses_documents_1pnl_permits_licenses_ida"] = array (
  'name' => 'pnl_permits_licenses_documents_1pnl_permits_licenses_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PNL_PERMITS_LICENSES_DOCUMENTS_1_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 'pnl_permits_licenses_documents_1pnl_permits_licenses_ida',
  'link' => 'pnl_permits_licenses_documents_1',
  'table' => 'pnl_permits_licenses',
  'module' => 'PNL_Permits_Licenses',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
