<?php
// created: 2019-02-18 04:43:23
$dictionary["sales_and_services"]["fields"]["contacts_sales_and_services_1"] = array (
  'name' => 'contacts_sales_and_services_1',
  'type' => 'link',
  'relationship' => 'contacts_sales_and_services_1',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'side' => 'right',
  'vname' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
  'id_name' => 'contacts_sales_and_services_1contacts_ida',
  'link-type' => 'one',
);
$dictionary["sales_and_services"]["fields"]["contacts_sales_and_services_1_name"] = array (
  'name' => 'contacts_sales_and_services_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_CONTACTS_TITLE',
  'save' => true,
  'id_name' => 'contacts_sales_and_services_1contacts_ida',
  'link' => 'contacts_sales_and_services_1',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["sales_and_services"]["fields"]["contacts_sales_and_services_1contacts_ida"] = array (
  'name' => 'contacts_sales_and_services_1contacts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE_ID',
  'id_name' => 'contacts_sales_and_services_1contacts_ida',
  'link' => 'contacts_sales_and_services_1',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
