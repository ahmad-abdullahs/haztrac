<?php
$popupMeta = array (
    'moduleMain' => 'ProductTemplates',
    'varName' => 'ProductTemplate',
    'orderBy' => 'producttemplates.name',
    'whereClauses' => array (
  'name' => 'producttemplates.name',
  'category_name' => 'producttemplates.category_name',
  'product_list_name_c' => 'producttemplates_cstm.product_list_name_c',
),
    'searchInputs' => array (
  0 => 'name',
  1 => 'category_name',
  2 => 'product_list_name_c',
),
    'searchdefs' => array (
  'product_list_name_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_PRODUCT_LIST_NAME',
    'width' => 10,
    'name' => 'product_list_name_c',
  ),
  'name' => 
  array (
    'name' => 'name',
    'width' => 10,
  ),
  'category_name' => 
  array (
    'name' => 'category_name',
    'width' => 10,
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '30',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'TYPE_NAME' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_TYPE',
    'sortable' => true,
    'default' => true,
    'name' => 'type_name',
  ),
  'CATEGORY_NAME' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_CATEGORY',
    'sortable' => true,
    'default' => true,
    'name' => 'category_name',
  ),
  'STATUS' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_STATUS',
    'default' => true,
    'name' => 'status',
  ),
  'QTY_IN_STOCK' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_QTY_IN_STOCK',
    'default' => true,
    'name' => 'qty_in_stock',
  ),
  'COST_PRICE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_COST_PRICE',
    'currency_format' => true,
    'width' => '10',
    'default' => true,
    'name' => 'cost_price',
  ),
  'LIST_PRICE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_LIST_PRICE',
    'currency_format' => true,
    'width' => '10',
    'default' => true,
    'name' => 'list_price',
  ),
  'DISCOUNT_PRICE' => 
  array (
    'type' => 'currency',
    'label' => 'LBL_DISCOUNT_PRICE',
    'currency_format' => true,
    'width' => '10',
    'default' => true,
  ),
),
);
