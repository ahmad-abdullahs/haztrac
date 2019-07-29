<?php
$viewdefs['HT_SS_Quotes']['base']['view']['record'] = array (
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
          'type' => 'convert-to-opportunity',
          'event' => 'button:convert_to_opportunity:click',
          'name' => 'convert_to_opportunity_button',
          'label' => 'LBL_QUOTE_TO_OPPORTUNITY_LABEL',
          'acl_module' => 'Opportunities',
          'acl_action' => 'create',
        ),
        6 => 
        array (
          'type' => 'divider',
        ),
        7 => 
        array (
          'type' => 'rowaction',
          'event' => 'button:duplicate_button:click',
          'name' => 'duplicate_button',
          'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
          'acl_module' => 'HT_SS_Quotes',
          'acl_action' => 'create',
        ),
        8 => 
        array (
          'type' => 'rowaction',
          'event' => 'button:historical_summary_button:click',
          'name' => 'historical_summary_button',
          'label' => 'LBL_HISTORICAL_SUMMARY',
          'acl_action' => 'view',
        ),
        9 => 
        array (
          'type' => 'rowaction',
          'event' => 'button:audit_button:click',
          'name' => 'audit_button',
          'label' => 'LNK_VIEW_CHANGE_LOG',
          'acl_action' => 'view',
        ),
        10 => 
        array (
          'type' => 'divider',
        ),
        11 => 
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
      'label' => 'LBL_PANEL_HEADER',
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
          'name' => 'name',
          'events' => 
          array (
            'keyup' => 'update:quote',
          ),
          'related_fields' => 
          array (
            0 => 
            array (
              'name' => 'bundles',
              'fields' => 
              array (
                0 => 'id',
                1 => 'bundle_stage',
                2 => 'currency_id',
                3 => 'base_rate',
                4 => 'currencies',
                5 => 'name',
                6 => 'deal_tot',
                7 => 'deal_tot_usdollar',
                8 => 'deal_tot_discount_percentage',
                9 => 'new_sub',
                10 => 'new_sub_usdollar',
                11 => 'position',
                12 => 'related_records',
                13 => 'shipping',
                14 => 'shipping_usdollar',
                15 => 'subtotal',
                16 => 'subtotal_usdollar',
                17 => 'tax',
                18 => 'tax_usdollar',
                19 => 'taxrate_id',
                20 => 'team_count',
                21 => 'team_count_link',
                22 => 'team_name',
                23 => 'taxable_subtotal',
                24 => 'total',
                25 => 'total_usdollar',
                26 => 'default_group',
                27 => 
                array (
                  'name' => 'ht_product_bundle_items',
                  'fields' => 
                  array (
                    0 => 'name',
                    1 => 'quote_id',
                    2 => 'description',
                    3 => 'quantity',
                    4 => 'ht_sales_service_catalog_name',
                    5 => 'ht_sales_service_catalog_id',
                    6 => 'deal_calc',
                    7 => 'mft_part_num',
                    8 => 'discount_price',
                    9 => 'discount_amount',
                    10 => 'tax',
                    11 => 'tax_class',
                    12 => 'subtotal',
                    13 => 'position',
                    14 => 'currency_id',
                    15 => 'base_rate',
                    16 => 'discount_select',
                    17 => 'total_amount',
                  ),
                  'max_num' => -1,
                ),
              ),
              'max_num' => -1,
              'order_by' => 'position:asc',
            ),
          ),
        ),
        2 => 
        array (
          'name' => 'favorite',
          'label' => 'LBL_FAVORITE',
          'type' => 'favorite',
          'dismiss_label' => true,
        ),
        3 => 
        array (
          'name' => 'follow',
          'label' => 'LBL_FOLLOW',
          'type' => 'follow',
          'readonly' => true,
          'dismiss_label' => true,
        ),
        4 => 
        array (
          'name' => 'converted',
          'label' => 'LBL_CONVERTED',
          'type' => 'badge',
          'readonly' => true,
          'dismiss_label' => true,
          'related_fields' => 
          array (
            0 => 'opportunity_id',
          ),
          'badge_compare' => 
          array (
            'comparison' => 'notEmpty',
          ),
          'badge_label_map' => 
          array (
            'false' => 'LBL_NOT_CONVERTED',
            'true' => 'LBL_CONVERTED',
          ),
          'css_class_map' => 
          array (
            'false' => '',
            'true' => 'label-success',
          ),
        ),
      ),
    ),
    1 => 
    array (
      'name' => 'panel_body',
      'label' => 'LBL_RECORD_BODY',
      'columns' => 2,
      'labelsOnTop' => true,
      'placeholders' => true,
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'tag',
          'span' => 12,
        ),
        1 => 'quote_num',
        2 => 
        array (
          'name' => 'opportunity_name',
          'related_fields' => 
          array (
            0 => 'subtotal',
            1 => 'discount',
            2 => 'new_sub',
            3 => 'tax',
            4 => 'shipping',
          ),
        ),
        3 => 'purchase_order_num',
        4 => 'quote_stage',
        5 => 'payment_terms',
        6 => 'date_quote_expected_closed',
        7 => 'billing_account_name',
        8 => 'shipping_account_name',
        9 => 'billing_contact_name',
        10 => 'shipping_contact_name',
        11 => 
        array (
          'name' => 'taxrate_name',
          'type' => 'taxrate',
          'initial_filter' => 'active_taxrates',
          'filter_populate' => 
          array (
            'module' => 
            array (
              0 => 'TaxRates',
            ),
          ),
          'populate_list' => 
          array (
            'id' => 'taxrate_id',
            'value' => 'taxrate_value',
          ),
        ),
        12 => 'show_line_nums',
        13 => 'original_po_date',
        14 => 'date_quote_closed',
        15 => 'date_order_shipped',
        16 => 
        array (
          'name' => 'shipper_name',
          'initial_filter' => 'active_shippers',
          'filter_populate' => 
          array (
            'module' => 
            array (
              0 => 'Shippers',
            ),
          ),
        ),
        17 => 'order_stage',
      ),
    ),
    2 => 
    array (
      'name' => 'panel_setting_body',
      'label' => 'LBL_QUOTESETTINGS',
      'panelDefault' => 'collapsed',
      'columns' => 2,
      'labelsOnTop' => true,
      'placeholders' => true,
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'currency_id',
          'type' => 'currency-type-dropdown',
          'label' => 'LBL_CURRENCY',
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'currency_field' => 'currency_id',
          'base_rate_field' => 'base_rate',
          'span' => 12,
        ),
      ),
    ),
    3 => 
    array (
      'name' => 'panel_hidden',
      'label' => 'LBL_RECORD_SHOWMORE',
      'panelDefault' => 'collapsed',
      'columns' => 2,
      'labelsOnTop' => true,
      'placeholders' => true,
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'description',
          'span' => 12,
        ),
        1 => 
        array (
          'name' => 'team_name',
          'span' => 12,
        ),
        2 => 'assigned_user_name',
        3 => 
        array (
          'name' => 'date_entered_by',
          'readonly' => true,
          'type' => 'fieldset',
          'inline' => true,
          'label' => 'LBL_DATE_ENTERED',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'date_entered',
            ),
            1 => 
            array (
              'type' => 'label',
              'default_value' => 'LBL_BY',
            ),
            2 => 
            array (
              'name' => 'created_by_name',
            ),
          ),
        ),
        4 => 
        array (
          'name' => 'date_modified_by',
          'readonly' => true,
          'type' => 'fieldset',
          'inline' => true,
          'label' => 'LBL_DATE_MODIFIED',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'date_modified',
            ),
            1 => 
            array (
              'type' => 'label',
              'default_value' => 'LBL_BY',
            ),
            2 => 
            array (
              'name' => 'modified_by_name',
            ),
          ),
        ),
        5 => 
        array (
        ),
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '2',
  ),
);
