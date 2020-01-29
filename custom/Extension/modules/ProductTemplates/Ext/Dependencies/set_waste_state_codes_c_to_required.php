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

$dependencies['ProductTemplates']['waste_profile_relate_c_setvalue_dep_save'] = array(
    'hooks' => array("save"),
    'triggerFields' => array('waste_profile_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'waste_profile_relate_c',
                'label' => 'waste_profile_relate_c_label',
                'value' => 'ifElse(equal($waste_profile_c,true),$waste_profile_relate_c,"")',
            ),
        ),
    ),
);
