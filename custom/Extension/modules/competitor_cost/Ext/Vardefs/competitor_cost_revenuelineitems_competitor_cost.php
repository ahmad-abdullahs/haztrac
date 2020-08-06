<?php
// created: 2020-07-30 03:45:56
$dictionary["competitor_cost"]["fields"]["competitor_cost_revenuelineitems"] = array (
  'name' => 'competitor_cost_revenuelineitems',
  'type' => 'link',
  'relationship' => 'competitor_cost_revenuelineitems',
  'source' => 'non-db',
  'module' => 'RevenueLineItems',
  'bean_name' => 'RevenueLineItem',
  'side' => 'right',
  'vname' => 'LBL_COMPETITOR_COST_REVENUELINEITEMS_FROM_COMPETITOR_COST_TITLE',
  'id_name' => 'competitor_cost_revenuelineitemsrevenuelineitems_ida',
  'link-type' => 'one',
);
$dictionary["competitor_cost"]["fields"]["competitor_cost_revenuelineitems_name"] = array (
  'name' => 'competitor_cost_revenuelineitems_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_COMPETITOR_COST_REVENUELINEITEMS_FROM_REVENUELINEITEMS_TITLE',
  'save' => true,
  'id_name' => 'competitor_cost_revenuelineitemsrevenuelineitems_ida',
  'link' => 'competitor_cost_revenuelineitems',
  'table' => 'revenue_line_items',
  'module' => 'RevenueLineItems',
  'rname' => 'name',
);
$dictionary["competitor_cost"]["fields"]["competitor_cost_revenuelineitemsrevenuelineitems_ida"] = array (
  'name' => 'competitor_cost_revenuelineitemsrevenuelineitems_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_COMPETITOR_COST_REVENUELINEITEMS_FROM_COMPETITOR_COST_TITLE_ID',
  'id_name' => 'competitor_cost_revenuelineitemsrevenuelineitems_ida',
  'link' => 'competitor_cost_revenuelineitems',
  'table' => 'revenue_line_items',
  'module' => 'RevenueLineItems',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
