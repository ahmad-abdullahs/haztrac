<?php

$dependencies['Accounts']['shipping_address_plus_code_cb_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('shipping_address_plus_code_cb'),
    'onload' => true,
    'actions' => array(
//        array(
//            'name' => 'SetRequired',
//            'params' => array(
//                'target' => 'shipping_address_plus_code_val',
//                'label' => 'shipping_address_plus_code_val_label',
//                'value' => 'equal($shipping_address_plus_code_cb, true)',
//            ),
//        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'shipping_address_lat',
                'label' => 'shipping_address_lat_label',
                'value' => 'equal($shipping_address_plus_code_cb, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'shipping_address_lon',
                'label' => 'shipping_address_lon_label',
                'value' => 'equal($shipping_address_plus_code_cb, true)',
            ),
        ),
    ),
);
