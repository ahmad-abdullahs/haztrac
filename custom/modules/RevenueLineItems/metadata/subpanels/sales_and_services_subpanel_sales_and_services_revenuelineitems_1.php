<?php
// created: 2019-11-24 21:06:40
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_LIST_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'waste_profile_relate_c' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'vname' => 'LBL_WASTE_PROFILE_RELATE',
    'id' => 'WPM_WASTE_PROFILE_MODULE_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'WPM_Waste_Profile_Module',
    'target_record_key' => 'wpm_waste_profile_module_id_c',
  ),
  'ht_manifest_revenuelineitems_1_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
    'id' => 'HT_MANIFEST_REVENUELINEITEMS_1HT_MANIFEST_IDA',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'HT_Manifest',
    'target_record_key' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
  ),
  'estimated_quantity_c' => 
  array (
    'default' => true,
    'type' => 'decimal',
    'vname' => 'LBL_ESTIMATED_QUANTITY',
    'width' => 10,
  ),
  'quantity' => 
  array (
    'vname' => 'LBL_QUANTITY',
    'width' => 10,
    'default' => true,
    'sortable' => false,
  ),
  'product_uom_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_PRODUCT_UOM',
    'width' => 10,
  ),
  'discount_price' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_DISCOUNT_PRICE',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
  ),
  'estimated_total_amount' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_ESTIMATED_TOTAL_AMOUNT',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
  ),
  'total_amount' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'vname' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
  ),
  'close_amount_c' => 
  array (
    'type' => 'decimal',
    'vname' => 'LBL_CLOSE_AMOUNT',
    'width' => 10,
    'default' => true,
  ),
  'discount_usdollar' => 
  array (
    'usage' => 'query_only',
    'sortable' => false,
  ),
  'is_bundle_product_c' => 
  array (
    'name' => 'is_bundle_product_c',
    'usage' => 'query_only',
  ),
  'currency_id' => 
  array (
    'name' => 'currency_id',
    'usage' => 'query_only',
  ),
);