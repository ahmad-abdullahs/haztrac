<?php

$dependencies['Accounts']['set_name_as_billing_and_shipping_address_third_party_name'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => false,
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'billing_address_third_party_name',
                'label' => 'billing_address_third_party_name_label',
                'value' => '$name',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'shipping_address_third_party_name',
                'label' => 'shipping_address_third_party_name_label',
                'value' => '$name',
            ),
        ),
    ),
);
