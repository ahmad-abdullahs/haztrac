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
