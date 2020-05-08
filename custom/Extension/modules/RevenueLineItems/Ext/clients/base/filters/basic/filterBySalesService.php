<?php

//$viewdefs['RevenueLineItems']['base']['filter']['basic']['filters'][] = array(
//    'id' => 'filterBySalesService',
//    'name' => 'LBL_FILTER_BY_SALES_SERVICES',
//    'filter_definition' => array(
//        array(
//            'sales_and_services_revenuelineitems_1sales_and_services_ida' => array(
//                '$in' => array(),
//            ),
//        )
//    ),
//    'editable' => true,
//    'is_template' => true,
//);

$viewdefs['RevenueLineItems']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterRLIByAccountOnManifest',
    'name' => 'LBL_FILTER_RLI_BY_ACCOUNT_ON_MANIFEST',
    'filter_definition' => array(
        array(
            'account_id' => array(
                '$in' => array(),
            ),
        ),
        array(
            'manifest_required_c' => array(
                '$equals' => '',
            ),
        ),
         array(
            'is_bundle_product_c' => array(
                '$not_in' => array(),
            ),
        ),
    ),
    'editable' => true,
    'is_template' => true,
);
