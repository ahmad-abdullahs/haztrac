<?php

$viewdefs['sales_and_services']['base']['layout']['create-preview'] = array(
    'components' => array(
        array(
            'view' => 'product-catalog',
            'context' => array(
                'module' => 'sales_and_services',
            ),
        ),
        array(
            'view' => array(
                'type' => 'related-account-revenuelineitems',
            ),
            'context' => array(
                'module' => 'RevenueLineItems',
            ),
            'width' => 12,
        ),
    ),
);
