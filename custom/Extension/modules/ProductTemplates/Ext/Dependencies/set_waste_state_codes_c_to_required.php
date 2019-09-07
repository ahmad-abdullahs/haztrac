<?php

$dependencies['ProductTemplates']['set_waste_state_codes_c_to_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('state_regulated_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'waste_state_codes_c',
                'label' => 'waste_state_codes_c_label',
                'value' => 'equal($state_regulated_c, true)',
            ),
        ),
    ),
);
