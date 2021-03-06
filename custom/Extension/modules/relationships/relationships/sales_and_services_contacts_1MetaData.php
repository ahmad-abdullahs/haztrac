<?php
// created: 2019-02-18 01:01:16
$dictionary["sales_and_services_contacts_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'sales_and_services_contacts_1' => 
    array (
      'lhs_module' => 'sales_and_services',
      'lhs_table' => 'sales_and_services',
      'lhs_key' => 'id',
      'rhs_module' => 'Contacts',
      'rhs_table' => 'contacts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'sales_and_services_contacts_1_c',
      'join_key_lhs' => 'sales_and_services_contacts_1sales_and_services_ida',
      'join_key_rhs' => 'sales_and_services_contacts_1contacts_idb',
    ),
  ),
  'table' => 'sales_and_services_contacts_1_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'sales_and_services_contacts_1sales_and_services_ida' => 
    array (
      'name' => 'sales_and_services_contacts_1sales_and_services_ida',
      'type' => 'id',
    ),
    'sales_and_services_contacts_1contacts_idb' => 
    array (
      'name' => 'sales_and_services_contacts_1contacts_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_sales_and_services_contacts_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_sales_and_services_contacts_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'sales_and_services_contacts_1sales_and_services_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_sales_and_services_contacts_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'sales_and_services_contacts_1contacts_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'sales_and_services_contacts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'sales_and_services_contacts_1sales_and_services_ida',
        1 => 'sales_and_services_contacts_1contacts_idb',
      ),
    ),
  ),
);