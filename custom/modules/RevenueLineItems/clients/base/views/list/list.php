<?php

$viewdefs['RevenueLineItems'] = array(
    'base' =>
    array(
        'view' =>
        array(
            'list' =>
            array(
                'panels' =>
                array(
                    0 =>
                    array(
                        'name' => 'panel_header',
                        'label' => 'LBL_PANEL_1',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'name',
                                'link' => true,
                                'label' => 'LBL_LIST_NAME',
                                'enabled' => true,
                                'default' => true,
                                'related_fields' =>
                                array(
                                    'rli_as_template_c',
                                    'quantity',
                                    'discount_amount',
                                    'total_amount',
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
                                    "product_svc_description_c",
                                    "proper_shipping_name_c",
                                    "waste_state_codes_c",
                                    "product_templates_product_templates_1_name",
                                    "product_templates_product_templates_1_right",
                                    "product_templates_product_templates_1product_templates_ida",
                                    "is_bundle_product_c",
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
                            1 =>
                            array(
                                'name' => 'opportunity_name',
                                'enabled' => true,
                                'default' => true,
                                'sortable' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'account_name',
                                'readonly' => true,
                                'enabled' => true,
                                'default' => true,
                                'sortable' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'sales_stage',
                                'enabled' => true,
                                'default' => true,
                            ),
                            4 =>
                            array(
                                'name' => 'sales_and_services_revenuelineitems_1_name',
                                'label' => 'LBL_SALES_AND_SERVICES_REVENUELINEITEMS_1_FROM_SALES_AND_SERVICES_TITLE',
                                'enabled' => true,
                                'id' => 'SALES_AND_SERVICES_REVENUELINEITEMS_1SALES_AND_SERVICES_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'probability',
                                'enabled' => true,
                                'default' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'date_closed',
                                'enabled' => true,
                                'default' => true,
                            ),
                            7 =>
                            array(
                                'name' => 'commit_stage',
                                'enabled' => true,
                                'default' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'product_template_name',
                                'enabled' => true,
                                'default' => true,
                            ),
                            9 =>
                            array(
                                'name' => 'category_name',
                                'enabled' => true,
                                'default' => true,
                            ),
                            10 =>
                            array(
                                'name' => 'quantity',
                                'enabled' => true,
                                'default' => true,
                            ),
                            11 =>
                            array(
                                'name' => 'worst_case',
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'currency_id',
                                    1 => 'base_rate',
                                    2 => 'total_amount',
                                    3 => 'quantity',
                                    4 => 'discount_amount',
                                    5 => 'discount_price',
                                    6 => 'is_bundle_product_c',
                                    7 => 'rli_as_template_c',
                                ),
                                'convertToBase' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => true,
                            ),
                            12 =>
                            array(
                                'name' => 'likely_case',
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'currency_id',
                                    1 => 'base_rate',
                                    2 => 'total_amount',
                                    3 => 'quantity',
                                    4 => 'discount_amount',
                                    5 => 'discount_price',
                                ),
                                'convertToBase' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => true,
                            ),
                            13 =>
                            array(
                                'name' => 'best_case',
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'currency_id',
                                    1 => 'base_rate',
                                    2 => 'total_amount',
                                    3 => 'quantity',
                                    4 => 'discount_amount',
                                    5 => 'discount_price',
                                ),
                                'convertToBase' => true,
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => true,
                            ),
                            14 =>
                            array(
                                'name' => 'quote_name',
                                'label' => 'LBL_ASSOCIATED_QUOTE',
                                'related_fields' =>
                                array(
                                    0 => 'quote_id',
                                ),
                                'readonly' => true,
                                'enabled' => true,
                                'default' => true,
                            ),
                            15 =>
                            array(
                                'name' => 'rli_as_template_c',
                                'label' => 'LBL_RLI_AS_TEMPLATE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            16 =>
                            array(
                                'name' => 'assigned_user_name',
                                'enabled' => true,
                                'default' => true,
                            ),
                            17 =>
                            array(
                                'name' => 'date_modified',
                                'enabled' => true,
                                'default' => true,
                            ),
                            18 =>
                            array(
                                'name' => 'date_entered',
                                'enabled' => true,
                                'default' => true,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
