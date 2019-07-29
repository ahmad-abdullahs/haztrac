<?php
 $viewdefs['sales_and_services']['base']['layout']['create-preview'] = array(
    'components' => array(
        array(
            'view' => 'product-catalog',
            'context' => array(
                'module' => 'Quotes',
            ),
        ),
        array(
            'view' => array(
                'type' => 'related-sales-and-services',
            ),
            'context' => array(
                'module' => 'sales_and_services',
            ),
            'width' => 12,
        ),
    ),
);