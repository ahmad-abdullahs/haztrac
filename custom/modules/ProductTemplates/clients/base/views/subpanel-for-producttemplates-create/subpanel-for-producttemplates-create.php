<?php

// This list is used on the Product Catalog record view for bundle creation...
$viewdefs['ProductTemplates']['base']['view']['subpanel-for-producttemplates-create'] = array(
    'rowactions' => array(
        'actions' => array(
            array(
                'type' => 'rowaction',
                'css_class' => 'btn deleteBtn',
                'icon' => 'fa-minus',
                'event' => 'list:deleterow:fire',
            ),
            array(
                'type' => 'rowaction',
                'css_class' => 'btn addBtn',
                'icon' => 'fa-plus',
                'event' => 'list:addrow:fire',
            ),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                array(
                    'name' => 'row_holder',
                    'label' => '',
                    'enabled' => true,
                    'sortable' => false,
                    'default' => true,
                    'type' => 'non-html-field',
                    'width' => '24',
                ),
                array(
                    'name' => 'name',
                    'link' => true,
                    'enabled' => true,
                    'default' => true,
                    'type' => 'open-in-drawer',
                    'related_fields' =>
                    array(
                        "line_number",
                        "description",
                        "type_id",
                        "manufacturer_id",
                        "manufacturer_name",
                        "manufacturer_link",
                        "category_id",
                        "category_name",
                        "category_link",
                        "type_name",
                        "type_link",
                        "mft_part_num",
                        "vendor_part_num",
                        "date_cost_price",
                        "cost_price",
                        "discount_price",
                        "list_price",
                        "cost_usdollar",
                        "discount_usdollar",
                        "list_usdollar",
                        "tax_class",
                        "date_available",
                        "website",
                        "weight",
                        "qty_in_stock",
                        "support_name",
                        "support_description",
                        "support_contact",
                        "support_term",
                        "pricing_factor",
                        "following",
                        "my_favorite",
                        "tag",
                        "locked_fields",
                        "assigned_user_id",
                        "assigned_user_name",
                        "assigned_user_link",
                        "currency_id",
                        "base_rate",
                        "currency_name",
                        "currencies",
                        "currency_symbol",
                        "product_list_name_c",
                        "product_uom_c",
                        "product_vendor_c",
                        "vendor_product_svc_descrp_c",
                        "waste_profile_rqrd_c",
                        "product_code_sku_c",
                        "state_regulated_c",
                        "shipping_ca_name_c",
                        "shipping_hazardous_materia_c",
                        "consolidated_manifest",
                        "product_svc_description_c",
                        "proper_shipping_name_c",
                        "waste_state_codes_c",
                        "product_templates_product_templates_1_name",
                        "product_templates_product_templates_1_right",
                        "product_templates_product_templates_1product_templates_ida",
                        "is_bundle_product_c",
                        "is_group_item_c",
                        "epa_code_1_c",
                        "epa_code_2_c",
                        "epa_code_3_c",
                        "epa_code_4_c",
                        "state_code_2_c",
                        "state_code_3_c",
                        "v_vendors_id_c",
                        "position",
                        "product_template_id",
                        "product_template_name",
                        "likely_case",
                        "best_case",
                        "worst_case",
                        "status",
                        "pricing_formula",
                        "mft_part_num",
                    ),
                ),
                array(
                    'name' => 'mft_part_num',
                    'label' => 'LBL_MFT_PART_NUM',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'type_name',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'discount_price',
                    'type' => 'currency',
                    'related_fields' =>
                    array(
                        0 => 'discount_usdollar',
                        1 => 'currency_id',
                        2 => 'base_rate',
                    ),
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'product_uom_c',
                    'label' => 'LBL_PRODUCT_UOM',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'product_vendor_c',
                    'label' => 'LBL_PRODUCT_VENDOR',
                    'enabled' => true,
                    'type' => 'relate',
                    'id' => 'V_VENDORS_ID_C',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                    'related_fields' =>
                    array(
                        "v_vendors_id_c",
                    ),
                ),
            ),
        ),
    ),
);
