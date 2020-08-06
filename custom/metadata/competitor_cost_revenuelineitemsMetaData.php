<?php
// created: 2020-07-30 03:45:56
$dictionary["competitor_cost_revenuelineitems"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'competitor_cost_revenuelineitems' => 
    array (
      'lhs_module' => 'RevenueLineItems',
      'lhs_table' => 'revenue_line_items',
      'lhs_key' => 'id',
      'rhs_module' => 'competitor_cost',
      'rhs_table' => 'competitor_cost',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'competitor_cost_revenuelineitems_c',
      'join_key_lhs' => 'competitor_cost_revenuelineitemsrevenuelineitems_ida',
      'join_key_rhs' => 'competitor_cost_revenuelineitemscompetitor_cost_idb',
    ),
  ),
  'table' => 'competitor_cost_revenuelineitems_c',
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
    'competitor_cost_revenuelineitemsrevenuelineitems_ida' => 
    array (
      'name' => 'competitor_cost_revenuelineitemsrevenuelineitems_ida',
      'type' => 'id',
    ),
    'competitor_cost_revenuelineitemscompetitor_cost_idb' => 
    array (
      'name' => 'competitor_cost_revenuelineitemscompetitor_cost_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_competitor_cost_revenuelineitems_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_competitor_cost_revenuelineitems_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'competitor_cost_revenuelineitemsrevenuelineitems_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_competitor_cost_revenuelineitems_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'competitor_cost_revenuelineitemscompetitor_cost_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'competitor_cost_revenuelineitems_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'competitor_cost_revenuelineitemscompetitor_cost_idb',
      ),
    ),
  ),
);