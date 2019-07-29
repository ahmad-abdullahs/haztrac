<?php
$viewdefs['ProductTemplates'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'link' => true,
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'mft_part_num',
                'label' => 'LBL_MFT_PART_NUM',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'type_name',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'category_name',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'discount_price',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'discount_usdollar',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'list_price',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'list_usdollar',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'product_list_name_c',
                'label' => 'LBL_PRODUCT_LIST_NAME',
                'enabled' => true,
                'default' => true,
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
              ),
              8 => 
              array (
                'name' => 'status',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'cost_price',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'cost_usdollar',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'qty_in_stock',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
