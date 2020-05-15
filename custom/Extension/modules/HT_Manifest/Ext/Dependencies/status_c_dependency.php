<?php

$dependencies['HT_Manifest']['set_status_c_to_completed_when_complete_date_c_is_entered'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('complete_date_c'),
    'onload' => false,
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'status_c',
                'label' => 'status_c_label',
                'value' => 'ifElse(not(equal($complete_date_c,"")),"Completed",$status_c)',
            ),
        ),
    ),
);
