<?php

// created: 2020-05-07 22:59:34
$viewdefs['RevenueLineItems']['base']['view']['subpanel-for-ht_manifest-ht_manifest_revenuelineitems_1'] = array(
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
                    'default' => true,
                    'label' => 'LBL_LIST_NAME',
                    'enabled' => true,
                    'name' => 'name',
                    'link' => true,
                    'type' => 'name',
                    'related_fields' =>
                    array(
                        0 => 'commentlog',
                    ),
                ),
                1 =>
                array(
                    'type' => 'relate',
                    'link' => true,
                    'default' => true,
                    'target_module' => 'HT_Manifest',
                    'target_record_key' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
                    'label' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
                    'enabled' => true,
                    'name' => 'ht_manifest_revenuelineitems_1_name',
                ),
                2 =>
                array(
                    'default' => true,
                    'label' => 'LBL_QUANTITY',
                    'enabled' => true,
                    'name' => 'quantity',
                    'type' => 'decimal',
                ),
                3 =>
                array(
                    'type' => 'enum',
                    'default' => true,
                    'label' => 'LBL_UNIT_OF_MEASURE',
                    'enabled' => true,
                    'name' => 'product_uom_c',
                ),
                4 =>
                array(
                    'name' => 'manifest_hazmat_handle_code_c',
                    'label' => 'LBL_MANIFEST_HAZMAT_HANDLE_CODE',
                    'enabled' => true,
                    'default' => true,
                ),
//        5 => 
//        array (
//          'name' => 'proper_shipping_name_c',
//          'label' => 'LBL_PROPER_SHIPPING_NAME',
//          'enabled' => true,
//          'sortable' => false,
//          'default' => true,
//        ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
