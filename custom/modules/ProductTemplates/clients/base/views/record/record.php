<?php
$viewdefs['ProductTemplates'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:edit_button:click',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              3 => 
              array (
                'type' => 'pdfaction',
                'name' => 'email-pdf',
                'label' => 'LBL_PDF_EMAIL',
                'action' => 'email',
                'acl_action' => 'view',
              ),
              4 => 
              array (
                'type' => 'divider',
              ),
              5 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              6 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'ProductTemplates',
                'acl_action' => 'create',
              ),
              7 => 
              array (
                'type' => 'divider',
              ),
              8 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
          ),
        ),
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'size' => 'large',
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'dismiss_label' => true,
              ),
              2 => 
              array (
                'name' => 'name',
                0 => 
                array (
                  0 => 'is_bundle_product_c',
                ),
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labels' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 'type_name',
              1 => 
              array (
                'name' => 'website',
                'type' => 'url',
              ),
              2 => 
              array (
                'name' => 'mft_part_num',
              ),
              3 => 
              array (
                'name' => 'product_code_sku_c',
                'label' => 'LBL_PRODUCT_CODE_SKU',
              ),
              4 => 
              array (
                'name' => 'product_list_name_c',
                'label' => 'LBL_PRODUCT_LIST_NAME',
              ),
              5 => 
              array (
                'name' => 'is_bundle_product_c',
                'label' => 'LBL_IS_BUNDLE_PRODUCT',
              ),
              6 => 
              array (
                'name' => 'product_vendor_c',
                'studio' => 'visible',
                'label' => 'LBL_PRODUCT_VENDOR',
              ),
              7 => 'vendor_part_num',
              8 => 
              array (
                'name' => 'additional_info_ack_c',
                'studio' => 'visible',
                'label' => 'LBL_ADDITIONAL_INFO_ACK',
                'span' => 12,
              ),
              9 => 
              array (
                'name' => 'vendor_product_svc_descrp_c',
                'studio' => 'visible',
                'label' => 'LBL_VENDOR_PRODUCT_SVC_DESCRP',
              ),
              10 => 
              array (
                'name' => 'product_svc_description_c',
                'studio' => 'visible',
                'label' => 'LBL_PRODUCT_SVC_DESCRIPTION',
              ),
              11 => 
              array (
                'name' => 'description',
                'span' => 12,
              ),
              12 => 
              array (
                'name' => 'waste_profile_rqrd_c',
                'label' => 'LBL_WASTE_PROFILE_RQRD',
                'span' => 12,
              ),
              13 => 
              array (
                'name' => 'weight',
                'span' => 12,
              ),
              14 => 
              array (
                'name' => 'product_uom_c',
                'label' => 'LBL_PRODUCT_UOM',
              ),
              15 => 
              array (
                'name' => 'tag',
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'tax_class',
              ),
              1 => 
              array (
                'name' => 'base_rate',
                'label' => 'LBL_CURRENCY_RATE',
              ),
              2 => 
              array (
                'name' => 'pricing_factor',
                'comment' => 'Variable pricing factor depending on pricing_formula',
                'related_fields' => 
                array (
                  0 => 'pricing_formula',
                ),
                'label' => 'LBL_PRICING_FACTOR',
              ),
              3 => 
              array (
                'name' => 'pricing_formula',
                'related_fields' => 
                array (
                  0 => 'pricing_factor',
                ),
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
                'name' => 'discount_usdollar',
              ),
              7 => 
              array (
                'name' => 'list_usdollar',
              ),
              8 => 
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
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'date_cost_price',
              ),
              10 => 'cost_usdollar',
              11 => 
              array (
                'name' => 'bundle_total_c',
                'label' => 'LBL_BUNDLE_TOTAL',
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'shipping_hazardous_materia_c',
                'label' => 'LBL_SHIPPING_HAZARDOUS_MATERIA',
              ),
              1 => 
              array (
                'name' => 'state_regulated_c',
                'label' => 'LBL_STATE_REGULATED',
              ),
              2 => 
              array (
                'name' => 'proper_shipping_name_c',
                'studio' => 'visible',
                'label' => 'LBL_PROPER_SHIPPING_NAME',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'waste_state_codes_c',
                'label' => 'LBL_WASTE_STATE_CODES',
                'type' => 'enum-same-key-and-value',
              ),
              4 => 
              array (
                'name' => 'epa_waste_codes_c',
                'label' => 'LBL_EPA_WASTE_CODES',
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => true,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 'qty_in_stock',
              1 => 'category_name',
              2 => 
              array (
                'name' => 'date_available',
              ),
              3 => 'manufacturer_name',
              4 => 
              array (
                'name' => 'status',
              ),
              5 => 
              array (
              ),
            ),
          ),
          5 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL4',
            'label' => 'LBL_RECORDVIEW_PANEL4',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'support_name',
              ),
              1 => 'support_contact',
              2 => 
              array (
                'name' => 'support_term',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'support_description',
                'span' => 12,
              ),
              4 => 
              array (
                'name' => 'created_by_name',
                'readonly' => true,
                'label' => 'LBL_CREATED',
              ),
              5 => 
              array (
                'name' => 'modified_by_name',
                'readonly' => true,
                'label' => 'LBL_MODIFIED',
              ),
              6 => 
              array (
                'name' => 'date_entered',
                'comment' => 'Date record created',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_ENTERED',
              ),
              7 => 
              array (
                'name' => 'date_modified',
                'comment' => 'Date record last modified',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_MODIFIED',
              ),
              8 => 
              array (
                'name' => 'commentlog',
                'displayParams' => 
                array (
                  'type' => 'commentlog',
                  'fields' => 
                  array (
                    0 => 'entry',
                    1 => 'date_entered',
                    2 => 'created_by_name',
                  ),
                  'max_num' => 100,
                ),
                'studio' => 
                array (
                  'listview' => false,
                  'recordview' => true,
                ),
                'label' => 'LBL_COMMENTLOG',
                'span' => 12,
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => true,
        ),
      ),
    ),
  ),
);
