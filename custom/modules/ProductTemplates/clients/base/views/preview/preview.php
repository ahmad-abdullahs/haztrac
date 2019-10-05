<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$viewdefs['ProductTemplates']['base']['view']['preview'] = array(
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
                    array(
                        0 => 'is_bundle_product_c',
                    ),
                ),
                3 =>
                array(
                    'name' => 'product_templates_product_templates_1',
                    'type' => 'relate-collection-preview',
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
                    'name' => 'type_name',
                    'related_fields' =>
                    array(
                        0 => 'line_number',
                        1 => 'mft_part_num',
                    ),
                ),
                1 =>
                array(
                    'name' => 'website',
                    'type' => 'url',
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
                    'name' => 'product_list_name_c',
                    'label' => 'LBL_PRODUCT_LIST_NAME',
                    'span' => 12,
                ),
                5 =>
                array(
                    'name' => 'product_vendor_c',
                    'studio' => 'visible',
                    'label' => 'LBL_PRODUCT_VENDOR',
                ),
                6 => 'vendor_part_num',
                7 =>
                array(
                    'name' => 'product_svc_description_c',
                    'studio' => 'visible',
                    'label' => 'LBL_PRODUCT_SVC_DESCRIPTION',
                ),
                8 =>
                array(
                    'name' => 'vendor_product_svc_descrp_c',
                    'studio' => 'visible',
                    'label' => 'LBL_VENDOR_PRODUCT_SVC_DESCRP',
                ),
                9 =>
                array(
                    'name' => 'description',
                    'span' => 12,
                ),
                10 =>
                array(
                    'name' => 'waste_profile_rqrd_c',
                    'label' => 'LBL_WASTE_PROFILE_RQRD',
                    'span' => 12,
                ),
                11 =>
                array(
                    'name' => 'weight',
                ),
                12 =>
                array(
                    'name' => 'product_uom_c',
                    'label' => 'LBL_PRODUCT_UOM',
                ),
                13 =>
                array(
                    'name' => 'tag',
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
                    'name' => 'tax_class',
                ),
                1 =>
                array(
                    'name' => 'base_rate',
                    'label' => 'LBL_CURRENCY_RATE',
                ),
                2 =>
                array(
                    'name' => 'pricing_factor',
                    'comment' => 'Variable pricing factor depending on pricing_formula',
                    'related_fields' =>
                    array(
                        0 => 'pricing_formula',
                    ),
                    'label' => 'LBL_PRICING_FACTOR',
                    'span' => 12,
                ),
                3 =>
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
                    'currency_field' => 'currency_id',
                    'base_rate_field' => 'base_rate',
                    'enabled' => true,
                    'default' => true,
                ),
                5 =>
                array(
                    'name' => 'pricing_formula',
                    'related_fields' =>
                    array(
                        0 => 'pricing_factor',
                    ),
                ),
                6 =>
                array(
                    'name' => 'discount_usdollar',
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
                    'name' => 'date_cost_price',
                ),
                9 =>
                array(
                    'name' => 'list_usdollar',
                ),
                10 => 'cost_usdollar',
            ),
        ),
        3 =>
        array(
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
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
                    'name' => 'proper_shipping_name_c',
                    'studio' => 'visible',
                    'label' => 'LBL_PROPER_SHIPPING_NAME',
                    'span' => 12,
                ),
                3 =>
                array(
                    'name' => 'waste_state_codes_c',
                    'label' => 'LBL_WASTE_STATE_CODES',
                    'type' => 'enum-same-key-and-value',
                ),
                4 =>
                array(
                    'name' => 'epa_waste_codes_c',
                    'label' => 'LBL_EPA_WASTE_CODES',
                    'type' => 'enum-same-key-and-value',
                ),
            ),
        ),
        4 =>
        array(
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL5',
            'label' => 'LBL_RECORDVIEW_PANEL5',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'shipping_ca_name_c',
                    'studio' => 'visible',
                    'label' => 'LBL_SHIPPING_CA_NAME',
                    'span' => 12,
                ),
            ),
        ),
        5 =>
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
                1 => 'category_name',
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
        6 =>
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
    ),
);
