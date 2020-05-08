<?php
// created: 2020-05-07 22:59:34
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_LIST_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
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
  'manifest_hazmat_handle_code_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_MANIFEST_HAZMAT_HANDLE_CODE',
    'width' => 10,
  ),
  'proper_shipping_name_c' => 
  array (
    'default' => true,
    'type' => 'text',
    'studio' => 'visible',
    'vname' => 'LBL_PROPER_SHIPPING_NAME',
    'sortable' => false,
    'width' => 10,
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