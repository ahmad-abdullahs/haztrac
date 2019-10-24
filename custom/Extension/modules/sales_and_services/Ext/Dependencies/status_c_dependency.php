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
