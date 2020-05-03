<?php

$viewdefs['RevenueLineItems']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterRevenueLineItems',
    'name' => 'LBL_FILTER_REVENUELINEITEMS',
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

$viewdefs['RevenueLineItems']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterBundleRevenueLineItems',
    'name' => 'LBL_FILTER_BUNDLE_REVENUELINEITEMS',
    'filter_definition' => array(
        array(
            'is_bundle_product_c' => array(
                '$in' => array(),
            ),
        ),
    ),
    'allow_tab' => false,
    'editable' => true,
    'is_template' => true,
);
