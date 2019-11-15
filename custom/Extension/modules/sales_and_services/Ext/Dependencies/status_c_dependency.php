<?php

$dependencies['sales_and_services']['set_on_date_and_time_required_on_status_scheduled'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('status_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'on_date_c',
                'label' => 'on_date_c_label',
                'value' => 'equal($status_c, "Scheduled")',
            ),
        ),
    ),
);

$dependencies['sales_and_services']['set_status_c_to_complete_when_complete_date_c_and_payment_status_c_is_not_empty'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('payment_status_c', 'complete_date_c'),
    'onload' => false,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'status_c',
                'label' => 'status_c_label',
                'value' => 'ifElse(not(equal($payment_status_c,"")),ifElse(not(equal($complete_date_c,"")),"Complete",$status_c),$status_c)',
            ),
        ),
    ),
);
