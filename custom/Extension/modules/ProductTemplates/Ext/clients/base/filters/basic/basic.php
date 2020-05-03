<?php

$viewdefs['ProductTemplates']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterProducts',
    'name' => 'LBL_FILTER_PRODUCTS',
    'filter_definition' => array(
        array(
            'is_bundle_product_c' => array(
                '$not_in' => array(),
            ),
        ),
    ),
    'allow_tab' => false,
    'editable' => true,
    'is_template' => true,
);

$viewdefs['ProductTemplates']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterBundleProducts',
    'name' => 'LBL_FILTER_BUNDLE_PRODUCTS',
    'filter_definition' => array(
        array(
            'is_bundle_product_c' => array(
                '$in' => array(),
            ),
        ),
        array(
            'is_group_item_c' => array(
                '$equals' => '',
            ),
        ),
    ),
    'allow_tab' => false,
    'editable' => true,
    'is_template' => true,
);

$viewdefs['ProductTemplates']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterGroupProducts',
    'name' => 'LBL_FILTER_GROUP_PRODUCTS',
    'filter_definition' => array(
        array(
            'is_bundle_product_c' => array(
                '$in' => array(),
            ),
        ),
        array(
            'is_group_item_c' => array(
                '$equals' => '',
            ),
        ),
    ),
    'allow_tab' => false,
    'editable' => true,
    'is_template' => true,
);

//$viewdefs['ProductTemplates']['base']['filter']['basic']['filters'][] = array(
//    'id' => 'filterBundleProducts',
//    'name' => 'LBL_FILTER_BUNDLE_PRODUCTS',
//    'filter_definition' => array(
//        array(
//            'is_bundle_product_c' => array(
//                '$in' => array(
//                    'parent',
//                ),
//            ),
//        ),
//    ),
//    'editable' => false,
//    'is_template' => false,
//);

//$viewdefs['ProductTemplates']['base']['filter']['basic']['filters'][] = array(
//    'id' => 'filterChildProducts',
//    'name' => 'LBL_FILTER_CHILD_PRODUCTS',
//    'filter_definition' => array(
//        array(
//            'is_bundle_product_c' => array(
//                '$in' => array(
//                    'child',
//                ),
//            ),
//        ),
//    ),
//    'editable' => false,
//    'is_template' => false,
//);

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
