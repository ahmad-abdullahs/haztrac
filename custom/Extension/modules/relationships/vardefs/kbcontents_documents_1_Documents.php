<?php
// created: 2020-08-18 14:08:08
$dictionary["Document"]["fields"]["kbcontents_documents_1"] = array (
  'name' => 'kbcontents_documents_1',
  'type' => 'link',
  'relationship' => 'kbcontents_documents_1',
  'source' => 'non-db',
  'module' => 'KBContents',
  'bean_name' => 'KBContent',
  'side' => 'right',
  'vname' => 'LBL_KBCONTENTS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'id_name' => 'kbcontents_documents_1kbcontents_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["kbcontents_documents_1_name"] = array (
  'name' => 'kbcontents_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_KBCONTENTS_DOCUMENTS_1_FROM_KBCONTENTS_TITLE',
  'save' => true,
  'id_name' => 'kbcontents_documents_1kbcontents_ida',
  'link' => 'kbcontents_documents_1',
  'table' => 'kbcontents',
  'module' => 'KBContents',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["kbcontents_documents_1kbcontents_ida"] = array (
  'name' => 'kbcontents_documents_1kbcontents_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_KBCONTENTS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 'kbcontents_documents_1kbcontents_ida',
  'link' => 'kbcontents_documents_1',
  'table' => 'kbcontents',
  'module' => 'KBContents',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
