<?php
$popupMeta = array (
    'moduleMain' => 'RevenueLineItems',
    'varName' => 'RLI',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'revenue_line_items.name',
  'account_name' => 'accounts.name',
  'opportunity_name' => 'opportunities.name',
),
    'searchInputs' => array (
  0 => 'name',
  1 => 'account_name',
  2 => 'opportunity_name',
),
    'searchdefs' => array (
  0 => 'name',
  1 => 
  array (
    'name' => 'account_name',
    'displayParams' => 
    array (
      'hideButtons' => 'true',
      'size' => 30,
      'class' => 'sqsEnabled sqsNoAutofill',
    ),
  ),
  2 => 
  array (
    'name' => 'opportunity_name',
    'displayParams' => 
    array (
      'hideButtons' => 'true',
      'size' => 30,
      'class' => 'sqsEnabled sqsNoAutofill',
    ),
  ),
  3 => 
  array (
    'name' => 'assigned_user_id',
    'type' => 'enum',
    'label' => 'LBL_ASSIGNED_TO',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'ACCOUNT_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'id' => 'ACCOUNT_ID',
    'module' => 'Accounts',
    'link' => true,
    'default' => true,
    'name' => 'account_name',
  ),
  'HT_MANIFEST_REVENUELINEITEMS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
    'id' => 'HT_MANIFEST_REVENUELINEITEMS_1HT_MANIFEST_IDA',
    'width' => 10,
    'default' => true,
    'name' => 'ht_manifest_revenuelineitems_1_name',
  ),
  'SALES_AND_SERVICES_REVENUELINEITEMS_1_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_SALES_AND_SERVICES_REVENUELINEITEMS_1_FROM_SALES_AND_SERVICES_TITLE',
    'id' => 'SALES_AND_SERVICES_REVENUELINEITEMS_1SALES_AND_SERVICES_IDA',
    'width' => 10,
    'default' => true,
  ),
  'ESTIMATED_QUANTITY_C' => 
  array (
    'type' => 'decimal',
    'default' => true,
    'label' => 'LBL_ESTIMATED_QUANTITY',
    'width' => 10,
    'name' => 'estimated_quantity_c',
  ),
  'QUANTITY' => 
  array (
    'type' => 'decimal',
    'default' => true,
    'label' => 'LBL_QUANTITY',
    'width' => 10,
    'name' => 'quantity',
  ),
  'UNIT_OF_MEASURE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_UNIT_OF_MEASURE',
    'width' => 10,
    'name' => 'product_uom_c',
  ),
  'DISCOUNT_PRICE' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'label' => 'LBL_DISCOUNT_PRICE',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
    'name' => 'discount_price',
  ),
  'TOTAL_AMOUNT' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
    'name' => 'total_amount',
  ),
  'RELATED_RLI_TOTAL_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_RELATED_RLI_TOTAL',
    'width' => 10,
    'default' => true,
    'name' => 'related_rli_total_c',
  ),
  'IS_BUNDLE_PRODUCT_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_IS_BUNDLE_PRODUCT',
    'width' => 10,
    'name' => 'is_bundle_product_c',
  ),
  'RLI_TYPE_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_RLI_TYPE',
    'width' => 10,
    'default' => true,
    'name' => 'rli_type_c',
  ),
),
);
