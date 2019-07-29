<?php

$dictionary["sales_and_services"]["fields"]["notes"] = array (
  'name' => 'notes',
  'type' => 'link',
  'relationship' => 'sales_and_services_notes',
  'module' => 'Notes',
  'bean_name' => 'Note',
  'source' => 'non-db',
  'vname' => 'LBL_NOTES_TITLE',
);

$dictionary["sales_and_services"]["relationships"]["sales_and_services_notes"] = array (
  'lhs_module' => 'sales_and_services',
  'lhs_table' => 'sales_and_services',
  'lhs_key' => 'id',
  'rhs_module' => 'Notes',
  'rhs_table' => 'notes',
  'rhs_key' => 'parent_id',
  'relationship_type' => 'one-to-many',
  'relationship_role_column' => 'parent_type',
  'relationship_role_column_value' => 'sales_and_services',
);