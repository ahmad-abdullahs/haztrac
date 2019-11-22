<?php

$dependencies['RevenueLineItems']['set_proper_shipping_name_c_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('shipping_hazardous_materia_c', 'state_regulated_c', 'manifest_required_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'proper_shipping_name_c',
                'label' => 'proper_shipping_name_c_label',
                'value' => 'or(equal($shipping_hazardous_materia_c, true),equal($state_regulated_c, true),equal($manifest_required_c, true))',
            ),
        ),
    ),
);
