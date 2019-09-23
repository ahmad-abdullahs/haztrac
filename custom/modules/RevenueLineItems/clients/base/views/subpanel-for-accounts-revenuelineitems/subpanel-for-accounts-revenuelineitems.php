<?php
// created: 2019-09-23 13:06:59
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-accounts-revenuelineitems'] = array (
  'type' => 'subpanel-list',
  'favorite' => true,
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'name',
          'link' => true,
          'label' => 'LBL_LIST_NAME',
          'enabled' => true,
          'default' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
            2 => 'is_bundle_product_c',
          ),
          'width' => 'medium',
        ),
        1 => 
        array (
          'name' => 'mft_part_num',
          'label' => 'LBL_MFT_PART_NUM',
          'enabled' => true,
          'default' => true,
          'width' => 'xxsmall',
        ),
        2 => 
        array (
          'name' => 'estimated_quantity_c',
          'label' => 'LBL_ESTIMATED_QUANTITY',
          'enabled' => true,
          'default' => true,
          'width' => 'xsmall',
        ),
        3 => 
        array (
          'name' => 'discount_price',
          'label' => 'LBL_DISCOUNT_PRICE',
          'enabled' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'currency_format' => true,
          'default' => true,
          'width' => 'xxsmall',
        ),
        4 => 
        array (
          'name' => 'pricing_formula',
          'label' => 'LBL_PRICING_FORMULA',
          'enabled' => true,
          'default' => true,
          'width' => 'small',
        ),
        5 => 
        array (
          'name' => 'product_uom_c',
          'label' => 'LBL_UNIT_OF_MEASURE',
          'enabled' => true,
          'default' => true,
          'width' => 'xsmall',
        ),
        6 => 
        array (
          'name' => 'related_rli_total_c',
          'label' => 'LBL_RELATED_RLI_TOTAL',
          'enabled' => true,
          'default' => true,
          'width' => 'xsmall',
        ),
        7 => 
        array (
          'name' => 'product_vendor_c',
          'label' => 'LBL_PRODUCT_VENDOR',
          'enabled' => true,
          'id' => 'V_VENDORS_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
          'width' => 'medium',
        ),
      ),
    ),
  ),
  'selection' => 
  array (
  ),
  'rowactions' => 
  array (
    'css_class' => 'pull-right',
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'rowaction',
        'css_class' => 'btn',
        'tooltip' => 'LBL_PREVIEW',
        'event' => 'list:preview:fire',
        'icon' => 'fa-eye',
        'acl_action' => 'view',
      ),
      1 => 
      array (
        'type' => 'rowaction',
        'name' => 'edit_button',
        'icon' => 'fa-pencil',
        'label' => 'LBL_EDIT_BUTTON',
        'event' => 'list:editrow:fire',
        'acl_action' => 'edit',
      ),
    ),
  ),
);