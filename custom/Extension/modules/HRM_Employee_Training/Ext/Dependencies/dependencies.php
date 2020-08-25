<?php

$dependencies['HRM_Employee_Training']['set_frequency_c_to_empty_when_renewal_refresher_c_is_not_checked'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('renewal_refresher_c'),
    'onload' => false,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'frequency_c',
                'label' => 'frequency_c_label',
                'value' => 'ifElse(not(equal($renewal_refresher_c,true)),"",$frequency_c)',
            ),
        ),
    ),
);

$dependencies['HRM_Employee_Training']['set_renew_by_date_c_to_empty_when_renewal_refresher_c_is_not_checked'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('renewal_refresher_c'),
    'onload' => false,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'renew_by_date_c',
                'label' => 'renew_by_date_c_label',
                'value' => 'ifElse(not(equal($renewal_refresher_c,true)),"",$renew_by_date_c)',
            ),
        ),
    ),
);

$dependencies['HRM_Employee_Training']['set_renewal_days_c_to_empty_when_renewal_refresher_c_is_not_checked'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('renewal_refresher_c'),
    'onload' => false,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'renewal_days_c',
                'label' => 'renewal_days_c_label',
                'value' => 'ifElse(not(equal($renewal_refresher_c,true)),"",$renewal_days_c)',
            ),
        ),
    ),
);

$dependencies['HRM_Employee_Training']['set_renewal_days_c_to_empty_when_frequency_c_is_not_other'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('frequency_c'),
    'onload' => false,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'renewal_days_c',
                'label' => 'renewal_days_c_label',
                'value' => 'ifElse(not(equal($frequency_c,"Other")),"",$renewal_days_c)',
            ),
        ),
    ),
);
