<?php
// created: 2020-08-18 14:07:27
$dictionary["Document"]["fields"]["producttemplates_documents_1"] = array (
  'name' => 'producttemplates_documents_1',
  'type' => 'link',
  'relationship' => 'producttemplates_documents_1',
  'source' => 'non-db',
  'module' => 'ProductTemplates',
  'bean_name' => 'ProductTemplate',
  'side' => 'right',
  'vname' => 'LBL_PRODUCTTEMPLATES_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'id_name' => 'producttemplates_documents_1producttemplates_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["producttemplates_documents_1_name"] = array (
  'name' => 'producttemplates_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_PRODUCTTEMPLATES_DOCUMENTS_1_FROM_PRODUCTTEMPLATES_TITLE',
  'save' => true,
  'id_name' => 'producttemplates_documents_1producttemplates_ida',
  'link' => 'producttemplates_documents_1',
  'table' => 'product_templates',
  'module' => 'ProductTemplates',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["producttemplates_documents_1producttemplates_ida"] = array (
  'name' => 'producttemplates_documents_1producttemplates_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_PRODUCTTEMPLATES_DOCUMENTS_1_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 'producttemplates_documents_1producttemplates_ida',
  'link' => 'producttemplates_documents_1',
  'table' => 'product_templates',
  'module' => 'ProductTemplates',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
