<?php

// created: 2019-08-31 02:38:01
// Subpanel of RevenueLineItems shown on Accounts record view
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-accounts-revenuelineitems'] = array(
    'type' => 'subpanel-list',
    'favorite' => true,
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
                    'type' => 'open-in-drawer',
                    'related_fields' =>
                    array(
                        0 => 'currency_id',
                        1 => 'base_rate',
                        2 => 'is_bundle_product_c',
                        3 => 'sales_and_services_revenuelineitems_1_name',
                        4 => 'rli_as_template_c',
                        5 => 'mft_part_num',
                        6 => 'commentlog'
                    ),
                    'width' => 'medium',
                ),
                1 =>
                array(
                    'name' => 'mft_part_num',
                    'label' => 'LBL_MFT_PART_NUM',
                    'enabled' => true,
                    'default' => true,
                    'width' => 'xxsmall',
                ),
                2 =>
                array(
                    'name' => 'estimated_quantity_c',
                    'label' => 'LBL_ESTIMATED_QUANTITY',
                    'enabled' => true,
                    'default' => true,
                    'width' => 'xsmall',
                ),
                3 =>
                array(
                    'name' => 'discount_price',
                    'label' => 'LBL_DISCOUNT_PRICE',
                    'enabled' => true,
                    'related_fields' =>
                    array(
                        0 => 'currency_id',
                        1 => 'base_rate',
                    ),
                    'currency_format' => true,
                    'default' => true,
                    'width' => 'xxsmall',
                ),
                4 =>
                array(
                    'name' => 'pricing_formula',
                    'label' => 'LBL_PRICING_FORMULA',
                    'enabled' => true,
                    'default' => true,
                    'width' => 'small',
                ),
                5 =>
                array(
                    'name' => 'product_uom_c',
                    'label' => 'LBL_UNIT_OF_MEASURE',
                    'enabled' => true,
                    'default' => true,
                    'width' => 'xsmall',
                ),
                6 =>
                array(
                    'name' => 'bundle_total_c',
                    'label' => 'LBL_BUNDLE_TOTAL',
                    'enabled' => true,
                    'default' => true,
                ),
//                array(
//                    'name' => 'related_rli_total_c',
//                    'label' => 'LBL_RELATED_RLI_TOTAL',
//                    'enabled' => true,
//                    'default' => true,
//                    'width' => 'xsmall',
//                ),
                7 =>
                array(
                    'name' => 'product_vendor_c',
                    'label' => 'LBL_PRODUCT_VENDOR',
                    'enabled' => true,
                    'id' => 'v_vendors_id_c',
                    'link' => true,
                    'sortable' => false,
                    'default' => true,
                    'width' => 'medium',
                    'related_fields' =>
                    array(
                        "v_vendors_id_c",
                    ),
                ),
            ),
        ),
    ),
    'selection' =>
    array(
    ),
    'orderBy' => array(
        'field' => 'account_line_number',
        'direction' => 'asc',
    ),
//    'rowactions' =>
//    array(
//        'css_class' => 'pull-right',
//        'actions' =>
//        array(
//            0 =>
//            array(
//                'type' => 'rowaction',
//                'css_class' => 'btn',
//                'tooltip' => 'LBL_PREVIEW',
//                'event' => 'list:preview:fire',
//                'icon' => 'fa-eye',
//                'acl_action' => 'view',
//            ),
//            1 =>
//            array(
//                'type' => 'rowaction',
//                'name' => 'edit_button',
//                'icon' => 'fa-pencil',
//                'label' => 'LBL_EDIT_BUTTON',
//                'event' => 'list:editrow:fire',
//                'acl_action' => 'edit',
//            ),
//        ),
//    ),
);
