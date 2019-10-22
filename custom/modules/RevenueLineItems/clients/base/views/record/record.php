<?php
$viewdefs['RevenueLineItems'] = 
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
                'primary' => true,
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
                'type' => 'convert-to-quote',
                'event' => 'button:convert_to_quote:click',
                'name' => 'convert_to_quote_button',
                'label' => 'LBL_CONVERT_TO_QUOTE',
                'acl_module' => 'Quotes',
                'acl_action' => 'create',
              ),
              6 => 
              array (
                'type' => 'divider',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              8 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'RevenueLineItems',
                'acl_action' => 'create',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:historical_summary_button:click',
                'name' => 'historical_summary_button',
                'label' => 'LBL_HISTORICAL_SUMMARY',
                'acl_action' => 'view',
              ),
              10 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              11 => 
              array (
                'type' => 'divider',
              ),
              12 => 
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
                'name' => 'name',
                'label' => 'LBL_MODULE_NAME_SINGULAR',
                'required' => true,
                'related_fields' => 
                array (
                  0 => 'discount_price',
                  1 => 'currency_id',
                  2 => 'base_rate',
                  3 => 'rli_as_template_c',
                  4 => 'mft_part_num',
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
                'type' => 'badge',
                'name' => 'quote_id',
                'event' => 'button:convert_to_quote:click',
                'readonly' => true,
                'tooltip' => 'LBL_CONVERT_RLI_TO_QUOTE',
                'acl_module' => 'RevenueLineItems',
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
                'name' => 'category_name',
                'type' => 'relate',
                'label' => 'LBL_CATEGORY',
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
                'readonly' => true,
              ),
              6 => 
              array (
                'name' => 'product_vendor_c',
                'studio' => 'visible',
                'label' => 'LBL_PRODUCT_VENDOR',
                'related_fields' => 
                array (
                  0 => 'v_vendors_id_c',
                ),
              ),
              7 => 'vendor_part_num',
              8 => 
              array (
                'name' => 'vendor_product_svc_descrp_c',
                'studio' => 'visible',
                'label' => 'LBL_VENDOR_PRODUCT_SVC_DESCRP',
              ),
              9 => 
              array (
                'name' => 'product_svc_description_c',
                'studio' => 'visible',
                'label' => 'LBL_PRODUCT_SVC_DESCRIPTION',
              ),
              10 => 
              array (
                'name' => 'description',
                'span' => 6,
              ),
              11 => 
              array (
                'name' => 'mandatory_print_text_c',
                'studio' => 'visible',
                'label' => 'LBL_MANDATORY_PRINT_TEXT',
                'span' => 6,
              ),
              12 => 
              array (
                'name' => 'additional_info_ack_c',
                'studio' => 'visible',
                'label' => 'LBL_ADDITIONAL_INFO_ACK',
                'span' => 12,
              ),
              13 => 
              array (
                'name' => 'waste_profile_rqrd_c',
                'label' => 'LBL_WASTE_PROFILE_RQRD',
              ),
              14 => 
              array (
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
                'name' => 'discount_price',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'discount_price',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              1 => 
              array (
                'name' => 'product_uom_c',
                'label' => 'LBL_UNIT_OF_MEASURE',
              ),
              2 => 
              array (
                'name' => 'pricing_formula',
                'comment' => 'Pricing formula (ex: Fixed, Markup over Cost)',
                'label' => 'LBL_PRICING_FORMULA',
              ),
              3 => 
              array (
                'name' => 'weight',
              ),
              4 => 
              array (
                'name' => 'cost_usdollar',
                'comment' => 'Cost expressed in USD',
                'studio' => 
                array (
                  'editview' => false,
                  'mobile' => false,
                ),
                'readonly' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_COST_USDOLLAR',
              ),
              5 => 
              array (
                'name' => 'date_cost_price',
              ),
              6 => 
              array (
                'name' => 'discount_usdollar',
                'comment' => 'Discount price expressed in USD',
                'studio' => 
                array (
                  'editview' => false,
                  'mobile' => false,
                ),
                'readonly' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_DISCOUNT_USDOLLAR',
              ),
              7 => 
              array (
                'name' => 'related_rli_total_c',
                'label' => 'LBL_RELATED_RLI_TOTAL',
              ),
              8 => 
              array (
                'name' => 'tax_class',
              ),
              9 => 
              array (
                'name' => 'base_rate',
                'label' => 'LBL_CURRENCY_RATE',
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL5',
            'label' => 'LBL_RECORDVIEW_PANEL5',
            'columns' => 4,
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
                'name' => 'manifest_required_c',
                'label' => 'LBL_MANIFEST_REQUIRED',
              ),
              3 => 
              array (
                'name' => 'waste_profile_c',
                'label' => 'LBL_WASTE_PROFILE',
              ),
            ),
          ),
          4 => 
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
                'name' => 'proper_shipping_name_c',
                'studio' => 'visible',
                'label' => 'LBL_PROPER_SHIPPING_NAME',
                'span' => 12,
              ),
              1 => 
              array (
                'name' => 'waste_state_codes_c',
                'label' => 'LBL_WASTE_STATE_CODES',
                'type' => 'enum-same-key-and-value',
              ),
              2 => 
              array (
                'name' => 'epa_waste_codes_c',
                'label' => 'LBL_EPA_WASTE_CODES',
                'type' => 'enum-same-key-and-value',
              ),
              3 => 
              array (
                'name' => 'erg_no_c',
                'label' => 'LBL_ERG_NO',
              ),
              4 => 
              array (
                'name' => 'manifest_hazmat_handle_code_c',
                'label' => 'LBL_MANIFEST_HAZMAT_HANDLE_CODE',
                'type' => 'enum-same-key-and-value',
              ),
              5 => 
              array (
                'name' => 'manifest_container_type_c',
                'label' => 'LBL_MANIFEST_CONTAINER_TYPE',
                'type' => 'enum-same-key-and-value',
              ),
              6 => 
              array (
                'name' => 'manifest_uom_c',
                'label' => 'LBL_MANIFEST_UOM',
                'type' => 'enum-same-key-and-value',
              ),
            ),
          ),
          5 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL6',
            'label' => 'LBL_RECORDVIEW_PANEL6',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'sales_rep_name_c',
                'studio' => 'visible',
                'label' => 'LBL_SALES_REP_NAME',
              ),
              1 => 
              array (
                'name' => 'commission_broker_account_c',
                'studio' => 'visible',
                'label' => 'LBL_COMMISSION_BROKER_ACCOUNT',
              ),
              2 => 
              array (
                'name' => 'commission_unit_price_c',
                'label' => 'LBL_COMMISSION_UNIT_PRICE',
              ),
              3 => 
              array (
                'name' => 'commission_umo_c',
                'label' => 'LBL_COMMISSION_UMO',
              ),
              4 => 
              array (
                'name' => 'commission_percentage_c',
                'label' => 'LBL_COMMISSION_PERCENTAGE',
              ),
              5 => 
              array (
                'name' => 'commission_formula_c',
                'label' => 'LBL_COMMISSION_FORMULA',
              ),
            ),
          ),
          6 => 
          array (
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'labels' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'opportunity_name',
                'filter_relate' => 
                array (
                  'account_id' => 'account_id',
                ),
              ),
              1 => 
              array (
                'name' => 'account_name',
                'readonly' => true,
              ),
              2 => 
              array (
                'name' => 'estimated_quantity_c',
                'label' => 'LBL_ESTIMATED_QUANTITY',
              ),
              3 => 'quantity',
              4 => 
              array (
                'name' => 'discount_price',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'discount_price',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              5 => 
              array (
                'name' => 'product_uom_c',
                'label' => 'LBL_UNIT_OF_MEASURE',
              ),
              6 => 'sales_stage',
              7 => 'probability',
              8 => 
              array (
                'name' => 'commit_stage',
                'span' => 6,
              ),
              9 => 
              array (
                'name' => 'date_closed',
                'related_fields' => 
                array (
                  0 => 'date_closed_timestamp',
                  1 => 'revenuelineitems_revenuelineitems_1',
                ),
                'span' => 6,
              ),
              10 => 
              array (
                'name' => 'product_template_name',
                'span' => 12,
              ),
              11 => 
              array (
                'name' => 'discount_amount',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'discount_amount',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              12 => 
              array (
                'name' => 'total_amount',
                'type' => 'currency',
                'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
                'readonly' => true,
                'related_fields' => 
                array (
                  0 => 'total_amount',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              13 => 
              array (
                'name' => 'likely_case',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'likely_case',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              14 => 
              array (
                'name' => 'quote_name',
                'label' => 'LBL_ASSOCIATED_QUOTE',
                'related_fields' => 
                array (
                  0 => 'mft_part_num',
                ),
                'readonly' => true,
              ),
              15 => 
              array (
                'name' => 'tag',
                'span' => 6,
              ),
              16 => 
              array (
                'name' => 'sales_and_services_revenuelineitems_1_name',
                'span' => 6,
              ),
              17 => 
              array (
                'name' => 'ht_manifest_revenuelineitems_1_name',
              ),
              18 => 
              array (
                'name' => 'list_price',
                'readonly' => true,
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'list_price',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              19 => 
              array (
                'name' => 'revenuelineitems_revenuelineitems_1_name',
              ),
              20 => 
              array (
                'name' => 'related_rli_total_c',
                'label' => 'LBL_RELATED_RLI_TOTAL',
              ),
              21 => 
              array (
                'name' => 'deal_calc_usdollar',
                'comment' => 'deal_calc_usdollar',
                'studio' => 
                array (
                  'editview' => false,
                  'mobile' => false,
                ),
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_DISCOUNT_TOTAL_USDOLLAR',
              ),
              22 => 
              array (
                'name' => 'discount_amount_usdollar',
                'studio' => 
                array (
                  'editview' => false,
                  'mobile' => false,
                ),
                'label' => 'LBL_DISCOUNT_RATE_USDOLLAR',
              ),
              23 => 
              array (
                'name' => 'deal_calc',
                'comment' => 'deal_calc',
                'customCode' => '{$fields.currency_symbol.value}{$fields.deal_calc.value}&nbsp;',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                  2 => 'discount_select',
                  3 => 'discount_amount',
                  4 => 'discount_price',
                ),
                'label' => 'LBL_DISCOUNT_TOTAL',
              ),
              24 => 
              array (
                'name' => 'discount_rate_percent',
                'label' => 'LBL_DISCOUNT_AS_PERCENT',
              ),
              25 => 
              array (
                'name' => 'rli_type_c',
                'label' => 'LBL_RLI_TYPE',
              ),
              26 => 
              array (
                'name' => 'is_bundle_product_c',
                'label' => 'LBL_IS_BUNDLE_PRODUCT',
                'readonly' => true,
              ),
              27 => 
              array (
                'name' => 'website',
                'type' => 'url',
              ),
              28 => 
              array (
              ),
            ),
          ),
          7 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_RECORD_SHOWMORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'best_case',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'best_case',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              1 => 
              array (
                'name' => 'worst_case',
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'worst_case',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              2 => 'next_step',
              3 => 'product_type',
              4 => 'lead_source',
              5 => 'campaign_name',
              6 => 'assigned_user_name',
              7 => 'team_name',
              8 => 
              array (
                'name' => 'description',
              ),
              9 => 
              array (
                'name' => 'tax_class',
                'span' => 6,
              ),
              10 => 
              array (
                'name' => 'cost_price',
                'readonly' => true,
                'type' => 'currency',
                'related_fields' => 
                array (
                  0 => 'cost_price',
                  1 => 'currency_id',
                  2 => 'base_rate',
                ),
                'convertToBase' => true,
                'showTransactionalAmount' => true,
                'currency_field' => 'currency_id',
                'base_rate_field' => 'base_rate',
              ),
              11 => 
              array (
                'name' => 'discount_usdollar',
                'comment' => 'Discount price expressed in USD',
                'studio' => 
                array (
                  'editview' => false,
                  'mobile' => false,
                ),
                'readonly' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_DISCOUNT_USDOLLAR',
              ),
              12 => 
              array (
                'name' => 'rli_as_template_c',
                'label' => 'LBL_RLI_AS_TEMPLATE',
              ),
              13 => 
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
              14 => 
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
              15 => 
              array (
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
