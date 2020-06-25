<?php

$dependencies['WPM_Waste_Profile_Module']['third_party_waste_profile_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('third_party_waste_profile_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'third_party_waste_profile_no_c',
                'label' => 'third_party_waste_profile_no_c_label',
                'value' => 'ifElse(equal($third_party_waste_profile_c,true),$third_party_waste_profile_no_c,"")',
            ),
        ),
    ),
);


$dependencies['WPM_Waste_Profile_Module']['third_party_waste_profile_c_required_dep_all'] = array(
    'hooks' => array("view"),
    'trigger' => 'true',
    'triggerFields' => array('third_party_waste_profile_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'third_party_waste_profile_no_c',
                'label' => 'third_party_waste_profile_no_c_label',
                'value' => 'equal($third_party_waste_profile_c, true)',
            ),
        ),
    ),
);
