<?php
// created: 2021-11-30 19:49:33
$dictionary["Document"]["fields"]["sales_and_services_documents_1"] = array (
  'name' => 'sales_and_services_documents_1',
  'type' => 'link',
  'relationship' => 'sales_and_services_documents_1',
  'source' => 'non-db',
  'module' => 'sales_and_services',
  'bean_name' => 'sales_and_services',
  'side' => 'right',
  'vname' => 'LBL_SALES_AND_SERVICES_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'id_name' => 'sales_and_services_documents_1sales_and_services_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["sales_and_services_documents_1_name"] = array (
  'name' => 'sales_and_services_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_SALES_AND_SERVICES_DOCUMENTS_1_FROM_SALES_AND_SERVICES_TITLE',
  'save' => true,
  'id_name' => 'sales_and_services_documents_1sales_and_services_ida',
  'link' => 'sales_and_services_documents_1',
  'table' => 'sales_and_services',
  'module' => 'sales_and_services',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["sales_and_services_documents_1sales_and_services_ida"] = array (
  'name' => 'sales_and_services_documents_1sales_and_services_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_SALES_AND_SERVICES_DOCUMENTS_1_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 'sales_and_services_documents_1sales_and_services_ida',
  'link' => 'sales_and_services_documents_1',
  'table' => 'sales_and_services',
  'module' => 'sales_and_services',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
