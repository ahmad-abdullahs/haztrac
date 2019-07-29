<?php
// created: 2019-04-19 17:07:34
$dictionary["Contact"]["fields"]["v_vendors_contacts"] = array (
  'name' => 'v_vendors_contacts',
  'type' => 'link',
  'relationship' => 'v_vendors_contacts',
  'source' => 'non-db',
  'module' => 'V_Vendors',
  'bean_name' => 'V_Vendors',
  'side' => 'right',
  'vname' => 'LBL_V_VENDORS_CONTACTS_FROM_CONTACTS_TITLE',
  'id_name' => 'v_vendors_contactsv_vendors_ida',
  'link-type' => 'one',
);
$dictionary["Contact"]["fields"]["v_vendors_contacts_name"] = array (
  'name' => 'v_vendors_contacts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_V_VENDORS_CONTACTS_FROM_V_VENDORS_TITLE',
  'save' => true,
  'id_name' => 'v_vendors_contactsv_vendors_ida',
  'link' => 'v_vendors_contacts',
  'table' => 'v_vendors',
  'module' => 'V_Vendors',
  'rname' => 'name',
);
$dictionary["Contact"]["fields"]["v_vendors_contactsv_vendors_ida"] = array (
  'name' => 'v_vendors_contactsv_vendors_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_V_VENDORS_CONTACTS_FROM_CONTACTS_TITLE_ID',
  'id_name' => 'v_vendors_contactsv_vendors_ida',
  'link' => 'v_vendors_contacts',
  'table' => 'v_vendors',
  'module' => 'V_Vendors',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
