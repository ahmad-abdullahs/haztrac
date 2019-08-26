<?php

$viewdefs['ProductTemplates'] = array(
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
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'name',
                                'link' => true,
                                'enabled' => true,
                                'default' => true,
                                'related_fields' =>
                                array(
                                    0 => 'description',
                                    1 => 'type_id',
                                    2 => 'manufacturer_id',
                                    3 => 'manufacturer_name',
                                    4 => 'manufacturer_link',
                                    5 => 'category_id',
                                    6 => 'category_name',
                                    7 => 'category_link',
                                    8 => 'type_name',
                                    9 => 'type_link',
                                    10 => 'mft_part_num',
                                    11 => 'vendor_part_num',
                                    12 => 'date_cost_price',
                                    13 => 'cost_price',
                                    14 => 'discount_price',
                                    15 => 'list_price',
                                    16 => 'cost_usdollar',
                                    17 => 'discount_usdollar',
                                    18 => 'list_usdollar',
                                    19 => 'tax_class',
                                    20 => 'date_available',
                                    21 => 'website',
                                    22 => 'weight',
                                    23 => 'qty_in_stock',
                                    24 => 'support_name',
                                    25 => 'support_description',
                                    26 => 'support_contact',
                                    27 => 'support_term',
                                    28 => 'pricing_factor',
                                    29 => 'following',
                                    30 => 'my_favorite',
                                    31 => 'tag',
                                    32 => 'locked_fields',
                                    33 => 'assigned_user_id',
                                    34 => 'assigned_user_name',
                                    35 => 'assigned_user_link',
                                    36 => 'currency_id',
                                    37 => 'base_rate',
                                    38 => 'currency_name',
                                    39 => 'currencies',
                                    40 => 'currency_symbol',
                                    41 => 'product_list_name_c',
                                    42 => 'product_uom_c',
                                    43 => 'product_vendor_c',
                                    44 => 'vendor_product_svc_descrp_c',
                                    45 => 'waste_profile_rqrd_c',
                                    46 => 'product_code_sku_c',
                                    47 => 'state_regulated_c',
                                    48 => 'shipping_ca_name_c',
                                    49 => 'shipping_hazardous_materia_c',
                                    50 => 'product_svc_description_c',
                                    51 => 'proper_shipping_name_c',
                                    52 => 'waste_state_codes_c',
                                    53 => 'product_templates_product_templates_1_name',
                                    54 => 'product_templates_product_templates_1_right',
                                    55 => 'product_templates_product_templates_1product_templates_ida',
                                    56 => 'is_bundle_product_c',
                                    57 => 'epa_code_1_c',
                                    58 => 'epa_code_2_c',
                                    59 => 'epa_code_3_c',
                                    60 => 'epa_code_4_c',
                                    61 => 'state_code_2_c',
                                    62 => 'state_code_3_c',
                                    63 => 'v_vendors_id_c',
                                    64 => 'position',
                                    65 => 'product_template_id',
                                    66 => 'product_template_name',
                                    67 => 'likely_case',
                                    68 => 'best_case',
                                    69 => 'worst_case',
                                ),
                            ),
                            1 =>
                            array(
                                'name' => 'mft_part_num',
                                'label' => 'LBL_MFT_PART_NUM',
                                'enabled' => true,
                                'default' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'type_name',
                                'enabled' => true,
                                'default' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'category_name',
                                'enabled' => true,
                                'default' => true,
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
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'product_uom_c',
                                'label' => 'LBL_PRODUCT_UOM',
                                'enabled' => true,
                                'default' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'list_price',
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'list_usdollar',
                                    1 => 'currency_id',
                                    2 => 'base_rate',
                                ),
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => true,
                            ),
                            7 =>
                            array(
                                'name' => 'cost_price',
                                'type' => 'currency',
                                'related_fields' =>
                                array(
                                    0 => 'cost_usdollar',
                                    1 => 'currency_id',
                                    2 => 'base_rate',
                                ),
                                'currency_field' => 'currency_id',
                                'base_rate_field' => 'base_rate',
                                'enabled' => true,
                                'default' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'product_list_name_c',
                                'label' => 'LBL_PRODUCT_LIST_NAME',
                                'enabled' => true,
                                'default' => true,
                            ),
                            9 =>
                            array(
                                'name' => 'product_vendor_c',
                                'label' => 'LBL_PRODUCT_VENDOR',
                                'enabled' => true,
                                'id' => 'V_VENDORS_ID_C',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                                'type' => 'relate',
                            ),
                            10 =>
                            array(
                                'name' => 'date_entered',
                                'label' => 'LBL_DATE_ENTERED',
                                'enabled' => true,
                                'readonly' => true,
                                'default' => true,
                            ),
                            11 =>
                            array(
                                'name' => 'date_modified',
                                'label' => 'LBL_DATE_MODIFIED',
                                'enabled' => true,
                                'readonly' => true,
                                'default' => true,
                            ),
                            12 =>
                            array(
                                'name' => 'status',
                                'enabled' => true,
                                'default' => false,
                            ),
                            13 =>
                            array(
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
