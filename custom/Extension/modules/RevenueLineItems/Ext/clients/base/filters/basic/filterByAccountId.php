<?php

$viewdefs['RevenueLineItems']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterByAccountId',
    'name' => 'LBL_FILTER_BY_ACCOUNT_ID',
    'filter_definition' => array(
        array(
            'account_id' => ''
        ),
    ),
    'editable' => true,
    'is_template' => true,
);

$viewdefs['RevenueLineItems']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterByAccountIdAndBundle',
    'name' => 'LBL_FILTER_BY_ACCOUNT_ID_AND_BUNDLE',
    'filter_definition' => array(
        array(
            'account_id' => ''
        ),
        array(
            'is_bundle_product_c' => array(
                '$not_in' => array(
                    'parent'
                )
            )
        ),
    ),
    'editable' => true,
    'is_template' => true,
);

$viewdefs['RevenueLineItems']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterByBundle',
    'name' => 'LBL_FILTER_BY_BUNDLE',
    'filter_definition' => array(
        array(
            'is_bundle_product_c' => array(
                '$not_in' => array(
                    'parent'
                )
            )
        ),
    ),
    'editable' => true,
    'is_template' => true,
);
