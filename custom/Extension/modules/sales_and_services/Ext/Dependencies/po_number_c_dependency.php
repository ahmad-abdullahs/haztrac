<?php

$dependencies['sales_and_services']['set_po_number_c_required_on_account_po_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('accounts_sales_and_services_1accounts_ida', 'po_required', 'status_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'po_number_c',
                'label' => 'po_number_c_label',
                'value' => 'and(equal($po_required, true),equal($status_c, "Scheduled"))',
            ),
        ),
    ),
);
