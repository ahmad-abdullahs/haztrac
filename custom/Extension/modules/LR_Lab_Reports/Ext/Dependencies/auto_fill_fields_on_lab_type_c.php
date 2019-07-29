<?php

$dependencies['LR_Lab_Reports']['auto_fill_fields_on_lab_type_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', 
    'onload' => false,
    'triggerFields' => array('lab_type_c'), 
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'sergio_test_oil_c',
                'value' => 'ifElse(equal($lab_type_c,"Gasoline"),true,false)'
            )
        )
    )
);