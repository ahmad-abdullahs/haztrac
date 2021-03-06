<?php

$viewdefs['RevenueLineItems'] = array(
    'base' =>
    array(
        'view' =>
        array(
            'record' =>
            array(
                'buttons' =>
                array(
                    0 =>
                    array(
                        'type' => 'button',
                        'name' => 'cancel_button',
                        'label' => 'LBL_CANCEL_BUTTON_LABEL',
                        'css_class' => 'btn-invisible btn-link',
                        'showOn' => 'edit',
                        'events' =>
                        array(
                            'click' => 'button:cancel_button:click',
                        ),
                    ),
                    1 =>
                    array(
                        'type' => 'rowaction',
                        'event' => 'button:save_button:click',
                        'name' => 'save_button',
                        'label' => 'LBL_SAVE_BUTTON_LABEL',
                        'css_class' => 'btn btn-primary',
                        'showOn' => 'edit',
                        'acl_action' => 'edit',
                    ),
                    2 =>
                    array(
                        'type' => 'button',
                        'name' => 'close_drawer_button',
                        'label' => 'LBL_CLOSE_DRAWER_BUTTON_LABEL',
                        'css_class' => 'btn-invisible btn-link',
                        'showOn' => 'view',
                        'events' =>
                        array(
                            'click' => 'button:close_drawer_button:click',
                        ),
                    ),
                    3 =>
                    array(
                        'type' => 'actiondropdown',
                        'name' => 'main_dropdown',
                        'primary' => true,
                        'showOn' => 'view',
                        'buttons' =>
                        array(
                            0 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:edit_button:click',
                                'name' => 'edit_button',
                                'label' => 'LBL_EDIT_BUTTON_LABEL',
                                'primary' => true,
                                'acl_action' => 'edit',
                            ),
                            1 =>
                            array(
                                'type' => 'shareaction',
                                'name' => 'share',
                                'label' => 'LBL_RECORD_SHARE_BUTTON',
                                'acl_action' => 'view',
                            ),
                            2 =>
                            array(
                                'type' => 'pdfaction',
                                'name' => 'download-pdf',
                                'label' => 'LBL_PDF_VIEW',
                                'action' => 'download',
                                'acl_action' => 'view',
                            ),
                            3 =>
                            array(
                                'type' => 'pdfaction',
                                'name' => 'email-pdf',
                                'label' => 'LBL_PDF_EMAIL',
                                'action' => 'email',
                                'acl_action' => 'view',
                            ),
                            4 =>
                            array(
                                'type' => 'divider',
                            ),
                            5 =>
                            array(
                                'type' => 'convert-to-quote',
                                'event' => 'button:convert_to_quote:click',
                                'name' => 'convert_to_quote_button',
                                'label' => 'LBL_CONVERT_TO_QUOTE',
                                'acl_module' => 'Quotes',
                                'acl_action' => 'create',
                            ),
                            6 =>
                            array(
                                'type' => 'divider',
                            ),
                            7 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:find_duplicates_button:click',
                                'name' => 'find_duplicates_button',
                                'label' => 'LBL_DUP_MERGE',
                                'acl_action' => 'edit',
                            ),
                            8 =>
                            array(
                                'type' => 'duplicate-button-rowaction',
                                'event' => 'button:duplicate_button:click',
                                'name' => 'duplicate_button',
                                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                                'acl_module' => 'RevenueLineItems',
                                'acl_action' => 'create',
                            ),
                            9 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:historical_summary_button:click',
                                'name' => 'historical_summary_button',
                                'label' => 'LBL_HISTORICAL_SUMMARY',
                                'acl_action' => 'view',
                            ),
                            10 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:audit_button:click',
                                'name' => 'audit_button',
                                'label' => 'LNK_VIEW_CHANGE_LOG',
                                'acl_action' => 'view',
                            ),
                            11 =>
                            array(
                                'type' => 'divider',
                            ),
                            12 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:delete_button:click',
                                'name' => 'delete_button',
                                'label' => 'LBL_DELETE_BUTTON_LABEL',
                                'acl_action' => 'delete',
                            ),
                        ),
                    ),
                    4 =>
                    array(
                        'name' => 'sidebar_toggle',
                        'type' => 'sidebartoggle',
                    ),
                ),
                'panels' =>
                array(
                    0 =>
                    array(
                        'name' => 'panel_header',
                        'header' => true,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'picture',
                                'type' => 'avatar',
                                'size' => 'large',
                                'dismiss_label' => true,
                                'readonly' => true,
                            ),
                            1 =>
                            array(
                                'name' => 'name',
                                'label' => 'LBL_MODULE_NAME_SINGULAR',
                                'required' => true,
                                'related_fields' =>
                                array(
                                    0 => 'discount_price',
                                    1 => 'currency_id',
                                    2 => 'base_rate',
                                    3 => 'rli_as_template_c',
                                    4 => 'mft_part_num',
                                    5 => 'commentlog',
                                ),
                            ),
                            2 =>
                            array(
                                'name' => 'favorite',
                                'label' => 'LBL_FAVORITE',
                                'type' => 'favorite',
                                'dismiss_label' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'follow',
                                'label' => 'LBL_FOLLOW',
                                'type' => 'follow',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                            4 =>
                            array(
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
                    array(
                        'name' => 'panel_body',
                        'label' => 'LBL_RECORD_BODY',
                        'columns' => 2,
                        'labels' => true,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 => 'type_name',
                            1 =>
                            array(
                                'name' => 'category_name',
                                'type' => 'relate',
                                'label' => 'LBL_CATEGORY',
                            ),
                            2 =>
                            array(
                                'name' => 'mft_part_num',
                            ),
                            3 =>
                            array(
                                'name' => 'product_code_sku_c',
                                'label' => 'LBL_PRODUCT_CODE_SKU',
                            ),
                            4 =>
                            array(
                                'name' => 'bundle_total_c',
                                'label' => 'LBL_BUNDLE_TOTAL',
                            ),
                            5 =>
                            array(
                                'name' => 'related_rli_total_c',
                                'label' => 'LBL_RELATED_RLI_TOTAL',
                            ),
                            6 =>
                            array(
                                'name' => 'product_list_name_c',
                                'label' => 'LBL_PRODUCT_LIST_NAME',
                            ),
                            7 =>
                            array(
                            ),
                            8 =>
                            array(
                                'name' => 'product_svc_description_c',
                                'studio' => 'visible',
                                'label' => 'LBL_PRODUCT_SVC_DESCRIPTION',
                            ),
                            9 =>
                            array(
                                'name' => 'mandatory_print_text_c',
                                'studio' => 'visible',
                                'label' => 'LBL_MANDATORY_PRINT_TEXT',
                            ),
                            10 =>
                            array(
                                'name' => 'description',
                                'span' => 12,
                            ),
                            11 =>
                            array(
                                'name' => 'additional_info_ack_c',
                                'studio' => 'visible',
                                'label' => 'LBL_ADDITIONAL_INFO_ACK',
                                'span' => 12,
                            ),
                        ),
                    ),
                    2 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL3',
                        'label' => 'LBL_RECORDVIEW_PANEL3',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'hide_price_from_paperwork_c',
                                'label' => 'LBL_HIDE_PRICE_FROM_PAPERWORK',
                            ),
                            1 =>
                            array(
                                'name' => 'fed_percentage',
                                'label' => 'LBL_FED_PERCENTAGE',
                                'format' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'estimated_quantity_c',
                                'label' => 'LBL_ESTIMATED_QUANTITY',
                            ),
                            3 =>
                            array(
                                'name' => 'list_price',
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'list_usdollar',
                                    1 => 'currency_id',
                                    2 => 'base_rate',
                                ),
                                'convertToBase' => true,
                                'showTransactionalAmount' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                            ),
                            4 =>
                            array(
                                'name' => 'discount_price',
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'discount_usdollar',
                                    1 => 'currency_id',
                                    2 => 'base_rate',
                                ),
                                'convertToBase' => true,
                                'showTransactionalAmount' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                            ),
                            5 =>
                            array(
                                'name' => 'product_uom_c',
                                'label' => 'LBL_UNIT_OF_MEASURE',
                            ),
                            6 =>
                            array(
                                'name' => 'list_pricing_formula',
                                'label' => 'List Pricing Formula',
                            ),
                            7 =>
                            array(
                                'name' => 'weight',
                            ),
                            8 =>
                            array(
                                'name' => 'tax_class',
                            ),
                            9 =>
                            array(
                                'name' => 'base_rate',
                                'label' => 'LBL_CURRENCY_RATE',
                            ),
                        ),
                    ),
                    3 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL7',
                        'label' => 'LBL_RECORDVIEW_PANEL7',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'product_vendor_c',
                                'studio' => 'visible',
                                'label' => 'LBL_PRODUCT_VENDOR',
                                'related_fields' =>
                                array(
                                    0 => 'v_vendors_id_c',
                                ),
                            ),
                            1 => 'vendor_part_num',
                            2 =>
                            array(
                                'name' => 'cost_price',
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'cost_usdollar',
                                    1 => 'currency_id',
                                    2 => 'base_rate',
                                ),
                                'convertToBase' => true,
                                'showTransactionalAmount' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                            ),
                            3 =>
                            array(
                                'name' => 'date_cost_price',
                            ),
                            4 =>
                            array(
                                'name' => 'cost_pricing_formula',
                                'label' => 'Cost Pricing Formula',
                            ),
                            5 =>
                            array(
                                'name' => 'vendor_product_svc_descrp_c',
                                'type' => 'magnifier-text',
                                'studio' => 'visible',
                                'showButton' => true,
                                'label' => 'LBL_VENDOR_PRODUCT_SVC_DESCRP',
                            ),
                        ),
                    ),
                    4 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL11',
                        'label' => 'LBL_RECORDVIEW_PANEL11',
                        'columns' => 1,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            array(
                                'name' => 'subpanel_competitor_costs',
                                'readonly' => true,
                                'dismiss_label' => true,
                                'type' => 'subpanel-competitor-costs',
                                'linkField' => 'competitor_cost_revenuelineitems',
                                'relatedModule' => 'competitor_cost',
                                'subpanelCreateView' => 'subpanel-create',
                                'span' => 12,
                                'columns' => array(
                                    array(
                                        'name' => 'accounts_competitor_cost_1_name',
                                        'label' => 'LBL_ACCOUNTS_COMPETITOR_COST_1_FROM_ACCOUNTS_TITLE',
                                        'type' => 'filtered-relate',
                                        'required' => true,
                                    ),
                                    array(
                                        'name' => 'product_uom_competitor',
                                        'label' => 'LBL_PRODUCT_UOM',
                                        'type' => 'enum',
                                    ),
                                    array(
                                        'name' => 'cost_price_competitor',
                                        'label' => 'LBL_COST_PRICE',
                                        'type' => 'currency',
                                        'required' => true,
                                    ),
                                    array(
                                        'name' => 'description_competitor',
                                        'label' => 'LBL_DESCRIPTION',
                                    ),
                                ),
                                'relatedFields' => array(
                                ),
                                'fieldMapping' => array(
                                    'name' => 'name',
                                    'competitor_cost_revenuelineitemsrevenuelineitems_ida' => 'id',
                                ),
                                'primary_field' => false,
                                'name_field' => 'name'
                            ),
                        ),
                    ),
                    5 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL9',
                        'label' => 'LBL_RECORDVIEW_PANEL9',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'customer_certificates',
                                'label' => 'LBL_CUSTOMER_CERTIFICATES',
                            ),
                            1 =>
                            array(
                                'name' => 'transporter_certificates',
                                'label' => 'LBL_TRANSPORTER_CERTIFICATES',
                            ),
                            2 =>
                            array(
                                'name' => 'consignee_certificates',
                                'label' => 'LBL_CONSIGNEE_CERTIFICATES',
                            ),
                            3 =>
                            array(
                                'name' => 'shipper_certificates',
                                'label' => 'LBL_SHIPPER_CERTIFICATES',
                            ),
                        ),
                    ),
                    6 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL5',
                        'label' => 'LBL_RECORDVIEW_PANEL5',
                        'columns' => 4,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'shipping_hazardous_materia_c',
                                'label' => 'LBL_SHIPPING_HAZARDOUS_MATERIA',
                            ),
                            1 =>
                            array(
                                'name' => 'state_regulated_c',
                                'label' => 'LBL_STATE_REGULATED',
                            ),
                            2 =>
                            array(
                                'name' => 'manifest_required_c',
                                'label' => 'LBL_MANIFEST_REQUIRED',
                            ),
                            3 =>
                            array(
                                'name' => 'waste_profile_c',
                                'label' => 'LBL_WASTE_PROFILE',
                                'type' => 'dep-checkbox',
                            ),
                            4 =>
                            array(
                                'name' => 'consolidated_manifest',
                                'label' => 'LBL_CONSOLIDATED_MANIFEST',
                            ),
                            5 =>
                            array(
                            ),
                            6 =>
                            array(
                            ),
                            7 =>
                            array(
                                'name' => 'waste_profile_relate_c',
                                'label' => 'LBL_WASTE_PROFILE_RELATE',
                                'initial_filter' => 'filterByGenerator',
                                'initial_filter_label' => 'LBL_FILTER_BY_GENERATOR',
                                'filter_relate' =>
                                array(
                                    'account_id' => 'accounts_wpm_waste_profile_module_2accounts_ida',
                                ),
                            ),
                        ),
                    ),
                    7 =>
                    array(
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL1',
                        'label' => 'LBL_RECORDVIEW_PANEL1',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'proper_shipping_name_c',
                                'studio' => 'visible',
                                'label' => 'LBL_PROPER_SHIPPING_NAME',
                                'span' => 12,
                            ),
                            1 =>
                            array(
                                'name' => 'waste_state_codes_c',
                                'label' => 'LBL_WASTE_STATE_CODES',
                                'type' => 'enum-same-key-and-value',
                            ),
                            2 =>
                            array(
                                'name' => 'epa_waste_codes_c',
                                'label' => 'LBL_EPA_WASTE_CODES',
                                'type' => 'enum-same-key-and-value',
                            ),
                            3 =>
                            array(
                                'name' => 'erg_no_c',
                                'label' => 'LBL_ERG_NO',
                            ),
                            4 =>
                            array(
                                'name' => 'manifest_hazmat_handle_code_c',
                                'label' => 'LBL_MANIFEST_HAZMAT_HANDLE_CODE',
                                'type' => 'enum-same-key-and-value',
                            ),
                            5 =>
                            array(
                                'name' => 'manifest_container_type_c',
                                'label' => 'LBL_MANIFEST_CONTAINER_TYPE',
                                'type' => 'enum-same-key-and-value',
                            ),
                            6 =>
                            array(
                                'name' => 'manifest_uom_c',
                                'label' => 'LBL_MANIFEST_UOM',
                                'type' => 'enum-same-key-and-value',
                            ),
                            7 =>
                            array(
                                'name' => 'manifest_additional_info_c',
                                'label' => 'LBL_MANIFEST_ADDITIONAL_INFO',
                            ),
                            8 =>
                            array(
                            ),
                        ),
                    ),
                    8 =>
                    array(
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL6',
                        'label' => 'LBL_RECORDVIEW_PANEL6',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'sales_rep',
                                'type' => 'sales_rep',
                                'dismiss_label' => true,
                                'related_fields' =>
                                array(
                                    0 => 'sales_rep',
                                ),
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'sales_rep_type',
                                        'short_name' => 'sales_rep_type',
                                        'css_class' => 'sales_rep_type',
                                        'label' => 'LBL_SALES_REP_TYPE',
                                        'type' => 'enum',
                                        'options' => 'sales_rep_type_list',
                                        'span' => 2,
                                    ),
                                    1 =>
                                    array(
                                        'name' => 'sales_rep_name',
                                        'short_name' => 'sales_rep_name',
                                        'css_class' => 'sales_rep_name',
                                        'label' => 'LBL_SALES_REP',
                                        'rname' => 'name',
                                        'type' => 'relate',
                                        'id_name' => 'sales_rep_name_id',
                                        'module' => 'Accounts',
                                        'link' => true,
                                        'span' => 2,
                                        'sortable' => false,
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'sales_rep_comission_type',
                                        'short_name' => 'sales_rep_comission_type',
                                        'css_class' => 'sales_rep_comission_type',
                                        'label' => 'LBL_COMMISSION_TYPE',
                                        'type' => 'enum',
                                        'options' => 'comission_type_list',
                                        'span' => 2,
                                    ),
                                    3 =>
                                    array(
                                        'name' => 'sales_rep_comission_value',
                                        'short_name' => 'sales_rep_comission_value',
                                        'css_class' => 'sales_rep_comission_value',
                                        'label' => 'LBL_COMMISSION_VALUE',
                                        'type' => 'float',
                                        'len' => '8',
                                        'size' => '20',
                                        'precision' => 2,
                                        'span' => 1,
                                    ),
                                    4 =>
                                    array(
                                        'name' => 'sales_rep_comission_subtype',
                                        'short_name' => 'sales_rep_comission_subtype',
                                        'css_class' => 'sales_rep_comission_subtype',
                                        'label' => 'LBL_COMMISSION_SUBTYPE',
                                        'type' => 'enum',
                                        'options' => 'comission_subtype_percentage_list',
                                        'span' => 1,
                                    ),
                                    5 =>
                                    array(
                                        'name' => 'sales_rep_comission_subtype_uom',
                                        'short_name' => 'sales_rep_comission_subtype_uom',
                                        'css_class' => 'sales_rep_comission_subtype_uom',
                                        'label' => 'LBL_COMMISSION_SUBTYPE_UOM',
                                        'type' => 'enum',
                                        'options' => 'unit_of_measure_c_list',
                                        'span' => 2,
                                    ),
                                    6 =>
                                    array(
                                        'name' => 'sales_rep_comission_text',
                                        'short_name' => 'sales_rep_comission_text',
                                        'css_class' => 'sales_rep_comission_text',
                                        'label' => 'LBL_COMMISSION_TEXT',
                                        'type' => 'text',
                                        'span' => 1,
                                    ),
                                ),
                                'span' => 12,
                            ),
                            1 =>
                            array(
                            ),
                            2 =>
                            array(
                            ),
                        ),
                    ),
                    9 =>
                    array(
                        'name' => 'LBL_RECORDVIEW_PANEL2',
                        'label' => 'LBL_RECORDVIEW_PANEL2',
                        'columns' => 2,
                        'labels' => true,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'opportunity_name',
                                'filter_relate' =>
                                array(
                                    'account_id' => 'account_id',
                                ),
                            ),
                            1 =>
                            array(
                                'name' => 'account_name',
                                'readonly' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'quantity',
                                'span' => 12,
                            ),
                            3 => 'sales_stage',
                            4 =>
                            array(
                                'name' => 'date_closed',
                                'related_fields' =>
                                array(
                                    0 => 'date_closed_timestamp',
                                    1 => 'revenuelineitems_revenuelineitems_1',
                                ),
                            ),
                            5 =>
                            array(
                                'name' => 'product_template_name',
                                'span' => 12,
                            ),
                            6 =>
                            array(
                                'name' => 'quote_name',
                                'label' => 'LBL_ASSOCIATED_QUOTE',
                                'related_fields' =>
                                array(
                                    0 => 'mft_part_num',
                                ),
                                'readonly' => true,
                            ),
                            7 =>
                            array(
                                'name' => 'total_amount',
                                'type' => 'currency',
                                'label' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
                                'readonly' => true,
                                'related_fields' =>
                                array(
                                    0 => 'total_amount',
                                    1 => 'currency_id',
                                    2 => 'base_rate',
                                ),
                                'convertToBase' => true,
                                'showTransactionalAmount' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                            ),
                            8 =>
                            array(
                                'name' => 'tag',
                                'span' => 6,
                            ),
                            9 =>
                            array(
                                'name' => 'sales_and_services_revenuelineitems_1_name',
                                'span' => 6,
                            ),
                            10 =>
                            array(
                                'name' => 'ht_manifest_revenuelineitems_1_name',
                            ),
                            11 =>
                            array(
                                'name' => 'website',
                                'type' => 'url',
                            ),
                            12 =>
                            array(
                                'name' => 'revenuelineitems_revenuelineitems_1_name',
                            ),
                            13 =>
                            array(
                            ),
                            14 =>
                            array(
                                'name' => 'rli_type_c',
                                'label' => 'LBL_RLI_TYPE',
                            ),
                            15 =>
                            array(
                                'name' => 'is_bundle_product_c',
                                'label' => 'LBL_IS_BUNDLE_PRODUCT',
                                'readonly' => true,
                            ),
                        ),
                    ),
                    10 =>
                    array(
                        'name' => 'panel_hidden',
                        'label' => 'LBL_RECORD_SHOWMORE',
                        'hide' => true,
                        'columns' => 2,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'rli_as_template_c',
                                'label' => 'LBL_RLI_AS_TEMPLATE',
                            ),
                            1 => 'product_type',
                            2 => 'lead_source',
                            3 => 'campaign_name',
                            4 => 'assigned_user_name',
                            5 =>
                            array(
                                'name' => 'team_name',
                            ),
                            6 =>
                            array(
                            ),
                            7 =>
                            array(
                                'name' => 'tax_class',
                            ),
                            8 =>
                            array(
                                'name' => 'date_entered_by',
                                'readonly' => true,
                                'type' => 'fieldset',
                                'inline' => true,
                                'label' => 'LBL_DATE_ENTERED',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'date_entered',
                                    ),
                                    1 =>
                                    array(
                                        'type' => 'label',
                                        'default_value' => 'LBL_BY',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'created_by_name',
                                    ),
                                ),
                            ),
                            9 =>
                            array(
                                'name' => 'date_modified_by',
                                'readonly' => true,
                                'type' => 'fieldset',
                                'inline' => true,
                                'label' => 'LBL_DATE_MODIFIED',
                                'fields' =>
                                array(
                                    0 =>
                                    array(
                                        'name' => 'date_modified',
                                    ),
                                    1 =>
                                    array(
                                        'type' => 'label',
                                        'default_value' => 'LBL_BY',
                                    ),
                                    2 =>
                                    array(
                                        'name' => 'modified_by_name',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    11 =>
                    array(
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL8',
                        'label' => 'LBL_RECORDVIEW_PANEL8',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'audit',
                                'label' => 'Audit',
                                'type' => 'audit-list-field',
                                'relatedModule' => 'RevenueLineItems',
                                'readonly' => true,
                                'columns' =>
                                array(
                                    0 =>
                                    array(
                                        'type' => 'field-name',
                                        'name' => 'field_name',
                                        'label' => 'Field',
                                        'sortable' => true,
                                        'width' => '15%',
                                    ),
                                    1 =>
                                    array(
                                        'type' => 'base',
                                        'name' => 'before',
                                        'label' => 'Old Value',
                                        'sortable' => false,
                                        'width' => '29%',
                                    ),
                                    2 =>
                                    array(
                                        'type' => 'base',
                                        'name' => 'after',
                                        'label' => 'New Value',
                                        'sortable' => false,
                                        'width' => '29%',
                                    ),
                                    3 =>
                                    array(
                                        'type' => 'base',
                                        'name' => 'created_by_username',
                                        'label' => 'Changed By',
                                        'sortable' => true,
                                        'width' => '5%',
                                    ),
                                    4 =>
                                    array(
                                        'type' => 'source',
                                        'name' => 'source',
                                        'label' => 'Source',
                                        'sortable' => false,
                                        'width' => '7%',
                                        'module' => 'Users',
                                        'link' => true,
                                    ),
                                    5 =>
                                    array(
                                        'type' => 'datetimecombo',
                                        'name' => 'date_created',
                                        'label' => 'Change Date',
                                        'options' => 'date_range_search_dom',
                                        'sortable' => true,
                                        'width' => '15%',
                                    ),
                                ),
                                'relatedFields' =>
                                array(
                                ),
                                'allowedFieldList' =>
                                array(
                                    0 => 'discount_price',
                                    1 => 'list_price',
                                    2 => 'cost_price',
                                    3 => 'product_list_name_c',
                                    4 => 'sales_rep',
                                    5 => 'date_cost_price',
                                    6 => 'cost_pricing_formula',
                                    7 => 'product_vendor_c',
                                ),
                                'span' => 12,
                            ),
                        ),
                    ),
                    12 =>
                    array(
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL10',
                        'label' => 'LBL_RECORDVIEW_PANEL10',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                            ),
                            1 =>
                            array(
                            ),
                        ),
                    ),
                ),
                'templateMeta' =>
                array(
                    'useTabs' => true,
                ),
            ),
        ),
    ),
);
