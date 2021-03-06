<?php
// created: 2020-08-04 05:15:11
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'competitor_cost_revenuelineitems_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_COMPETITOR_COST_REVENUELINEITEMS_FROM_REVENUELINEITEMS_TITLE',
    'id' => 'COMPETITOR_COST_REVENUELINEITEMSREVENUELINEITEMS_IDA',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'RevenueLineItems',
    'target_record_key' => 'competitor_cost_revenuelineitemsrevenuelineitems_ida',
  ),
  'cost_price_competitor' => 
  array (
    'type' => 'currency',
    'vname' => 'LBL_COST_PRICE',
    'currency_format' => true,
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'width' => 10,
    'default' => true,
  ),
  'product_uom_competitor' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_PRODUCT_UOM',
    'width' => 10,
  ),
  'description_competitor' => 
  array (
    'type' => 'text',
    'vname' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => 10,
    'default' => true,
  ),
);