<?php

$viewdefs['ProductTemplates']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterBundleProducts',
    'name' => 'LBL_FILTER_BUNDLE_PRODUCTS',
    'filter_definition' => array(
        array(
            'is_bundle_product_c' => array(
                '$in' => array(
                    'child',
                    'parent',
                ),
            ),
        ),
    ),
    'editable' => false,
    'is_template' => false,
);
//$viewdefs['ProductTemplates']['base']['filter']['basic']['filters'][] = array(
//    'id' => 'filterBundleProducts',
//    'name' => 'LBL_FILTER_BUNDLE_PRODUCTS',
//    'filter_definition' => array(
//        array(
//            'is_bundle_product_c' => array(
//                '$in' => array(
//                    'child',
//                    'parent',
//                ),
//            ),
//        ),
//    ),
//    'editable' => false,
//    'is_template' => false,
//);
