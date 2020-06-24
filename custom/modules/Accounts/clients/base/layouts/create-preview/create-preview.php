<?php

$viewdefs['Accounts']['base']['layout']['create-preview'] = array(
    'components' => array(
        array(
            'view' => 'product-catalog',
            'context' => array(
//                'module' => 'Quotes',
                'module' => 'sales_and_services',
            ),
        ),
        array(
            'view' => array(
                'type' => 'rcrapublic-epa-create',
            ),
            'context' => array(
                'module' => 'Accounts',
            ),
        ),
    ),
);
