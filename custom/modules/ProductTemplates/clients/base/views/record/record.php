<?php

$viewdefs['ProductTemplates'] = array(
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
                                'type' => 'rowaction',
                                'event' => 'button:find_duplicates_button:click',
                                'name' => 'find_duplicates_button',
                                'label' => 'LBL_DUP_MERGE',
                                'acl_action' => 'edit',
                            ),
                            6 =>
                            array(
                                'type' => 'duplicate-button-rowaction',
                                'event' => 'button:duplicate_button:click',
                                'name' => 'duplicate_button',
                                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                                'acl_module' => 'ProductTemplates',
                                'acl_action' => 'create',
                            ),
                            7 =>
                            array(
                                'type' => 'divider',
                            ),
                            8 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:audit_button:click',
                                'name' => 'audit_button',
                                'label' => 'LNK_VIEW_CHANGE_LOG',
                                'acl_action' => 'view',
                            ),
                            9 =>
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
                                'name' => 'favorite',
                                'label' => 'LBL_FAVORITE',
                                'type' => 'favorite',
                                'dismiss_label' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'name',
                                0 =>
                                array(
                                    0 => 'is_bundle_product_c',
                                ),
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
                            0 =>
                            array(
                                'name' => 'is_group_item_c',
                                'label' => 'LBL_IS_GROUP_ITEM',
                            ),
                            1 =>
                            array(
                                'name' => 'bundle_total_c',
                                'label' => 'LBL_BUNDLE_TOTAL',
                            ),
                            2 =>
                            array(
                                'name' => 'type_name',
                                'related_fields' =>
                                array(
                                    0 => 'line_number',
                                    1 => 'mft_part_num',
                                ),
                            ),
                            3 =>
                            array(
                                'name' => 'category_name',
                                'type' => 'relate',
                                'label' => 'LBL_CATEGORY',
                            ),
                            4 =>
                            array(
                                'name' => 'mft_part_num',
                            ),
                            5 =>
                            array(
                                'name' => 'product_code_sku_c',
                                'label' => 'LBL_PRODUCT_CODE_SKU',
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
                            ),
                            2 =>
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
                            3 =>
                            array(
                                'name' => 'product_uom_c',
                                'label' => 'LBL_PRODUCT_UOM',
                            ),
                            4 =>
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
                            5 =>
                            array(
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
                                'name' => 'pricing_formula',
                                'related_fields' =>
                                array(
                                    0 => 'pricing_factor',
                                ),
                            ),
                            9 =>
                            array(
                            ),
                            10 =>
                            array(
                                'name' => 'tax_class',
                            ),
                            11 =>
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
                                'name' => 'vendor_only_c',
                                'label' => 'LBL_VENDOR_ONLY',
                            ),
                            1 =>
                            array(
                                'name' => 'standalone_item_c',
                                'label' => 'LBL_STANDALONE_ITEM',
                            ),
                            2 =>
                            array(
                                'name' => 'product_vendor_c',
                                'studio' => 'visible',
                                'label' => 'LBL_PRODUCT_VENDOR',
                                'related_fields' =>
                                array(
                                    0 => 'v_vendors_id_c',
                                ),
                            ),
                            3 => 'vendor_part_num',
                            4 =>
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
                            5 =>
                            array(
                                'name' => 'date_cost_price',
                            ),
                            6 =>
                            array(
                                'name' => 'cost_pricing_formula',
                                'label' => 'Cost Pricing Formula',
                            ),
                            7 =>
                            array(
                                'name' => 'vendor_product_svc_descrp_c',
                                'studio' => 'visible',
                                'label' => 'LBL_VENDOR_PRODUCT_SVC_DESCRP',
                            ),
                        ),
                    ),
                    4 =>
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
                            ),
                        ),
                    ),
                    5 =>
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
                            ),
                        ),
                    ),
                    6 =>
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
                    7 =>
                    array(
                        'newTab' => true,
                        'panelDefault' => 'collapsed',
                        'name' => 'LBL_RECORDVIEW_PANEL2',
                        'label' => 'LBL_RECORDVIEW_PANEL2',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 => 'qty_in_stock',
                            1 =>
                            array(
                                'name' => 'website',
                                'type' => 'url',
                            ),
                            2 =>
                            array(
                                'name' => 'date_available',
                            ),
                            3 => 'manufacturer_name',
                            4 =>
                            array(
                                'name' => 'status',
                            ),
                            5 =>
                            array(
                            ),
                        ),
                    ),
                    8 =>
                    array(
                        'newTab' => true,
                        'panelDefault' => 'expanded',
                        'name' => 'LBL_RECORDVIEW_PANEL4',
                        'label' => 'LBL_RECORDVIEW_PANEL4',
                        'columns' => 2,
                        'labelsOnTop' => 1,
                        'placeholders' => 1,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'support_name',
                            ),
                            1 => 'support_contact',
                            2 =>
                            array(
                                'name' => 'support_term',
                                'span' => 12,
                            ),
                            3 =>
                            array(
                                'name' => 'support_description',
                                'span' => 12,
                            ),
                            4 =>
                            array(
                                'name' => 'created_by_name',
                                'readonly' => true,
                                'label' => 'LBL_CREATED',
                            ),
                            5 =>
                            array(
                                'name' => 'modified_by_name',
                                'readonly' => true,
                                'label' => 'LBL_MODIFIED',
                            ),
                            6 =>
                            array(
                                'name' => 'date_entered',
                                'comment' => 'Date record created',
                                'studio' =>
                                array(
                                    'portaleditview' => false,
                                ),
                                'readonly' => true,
                                'label' => 'LBL_DATE_ENTERED',
                            ),
                            7 =>
                            array(
                                'name' => 'date_modified',
                                'comment' => 'Date record last modified',
                                'studio' =>
                                array(
                                    'portaleditview' => false,
                                ),
                                'readonly' => true,
                                'label' => 'LBL_DATE_MODIFIED',
                            ),
                            8 =>
                            array(
                                'name' => 'commentlog',
                                'displayParams' =>
                                array(
                                    'type' => 'commentlog',
                                    'fields' =>
                                    array(
                                        0 => 'entry',
                                        1 => 'date_entered',
                                        2 => 'created_by_name',
                                    ),
                                    'max_num' => 100,
                                ),
                                'studio' =>
                                array(
                                    'listview' => false,
                                    'recordview' => true,
                                ),
                                'label' => 'LBL_COMMENTLOG',
                                'span' => 12,
                            ),
                        ),
                    ),
                    9 =>
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
                                'relatedModule' => 'ProductTemplates',
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
                                ),
                                'span' => 12,
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
