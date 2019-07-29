<?php
// created: 2019-04-19 17:07:34
$dictionary["v_vendors_contacts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'v_vendors_contacts' => 
    array (
      'lhs_module' => 'V_Vendors',
      'lhs_table' => 'v_vendors',
      'lhs_key' => 'id',
      'rhs_module' => 'Contacts',
      'rhs_table' => 'contacts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'v_vendors_contacts_c',
      'join_key_lhs' => 'v_vendors_contactsv_vendors_ida',
      'join_key_rhs' => 'v_vendors_contactscontacts_idb',
    ),
  ),
  'table' => 'v_vendors_contacts_c',
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
    'v_vendors_contactsv_vendors_ida' => 
    array (
      'name' => 'v_vendors_contactsv_vendors_ida',
      'type' => 'id',
    ),
    'v_vendors_contactscontacts_idb' => 
    array (
      'name' => 'v_vendors_contactscontacts_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_v_vendors_contacts_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_v_vendors_contacts_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'v_vendors_contactsv_vendors_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_v_vendors_contacts_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'v_vendors_contactscontacts_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'v_vendors_contacts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'v_vendors_contactscontacts_idb',
      ),
    ),
  ),
);