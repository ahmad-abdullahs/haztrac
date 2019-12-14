<?php

$dependencies['WPM_Waste_Profile_Template']['describe_with_dimensions_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_contain_heavy_metals_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'describe_with_dimensions_c',
                'label' => 'describe_with_dimensions_c_label',
                'value' => 'equal($quest_contain_heavy_metals_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'describe_with_dimensions_c',
                'value' => 'equal($quest_contain_heavy_metals_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Template']['describe_with_dimensions_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_contain_heavy_metals_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'describe_with_dimensions_c',
                'label' => 'describe_with_dimensions_c_label',
                'value' => 'ifElse(equal($quest_contain_heavy_metals_c,"Yes"),$describe_with_dimensions_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Template']['quest_animal_waste_c_dependent_fields_visibility'] = array(
    'hooks' => array("all"),
    'triggerFields' => array('quest_animal_waste_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'acknowledge_0',
                'value' => 'equal($quest_animal_waste_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'acknowledge_1_c',
                'value' => 'equal($quest_animal_waste_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'acknowledge_1_c',
                'label' => 'acknowledge_1_c_label',
                'value' => 'equal($quest_animal_waste_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'acknowledge_2_c',
                'value' => 'equal($quest_animal_waste_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'acknowledge_2_c',
                'label' => 'acknowledge_2_c_label',
                'value' => 'equal($quest_animal_waste_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'acknowledge_1_c_1',
                'value' => 'equal($quest_animal_waste_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'acknowledge_2_c_1',
                'value' => 'equal($quest_animal_waste_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Template']['quest_animal_waste_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_animal_waste_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'acknowledge_1_c',
                'label' => 'acknowledge_1_c_label',
                'value' => 'ifElse(equal($quest_animal_waste_c,"Yes"),$acknowledge_1_c,"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'acknowledge_2_c',
                'label' => 'acknowledge_2_c_label',
                'value' => 'ifElse(equal($quest_animal_waste_c,"Yes"),$acknowledge_2_c,"")',
            ),
        ),
    ),
);
