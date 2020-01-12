<?php

$dependencies['WPM_Waste_Profile_Template']['liquid_solid_mixture_group_visibility'] = array(
    'hooks' => array("all"),
    'triggerFields' => array('physical_state_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'liquid_solid_mixture_group',
                'value' => 'equal($physical_state_c,"Liquid and Solid")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Template']['liquid_solid_mixture_group_setvalue'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('physical_state_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'free_liquid_c',
                'label' => 'free_liquid_c_label',
                'value' => 'ifElse(equal($physical_state_c,"Liquid and Solid"),$free_liquid_c,"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'settled_solid_c',
                'label' => 'settled_solid_c_label',
                'value' => 'ifElse(equal($physical_state_c,"Liquid and Solid"),$settled_solid_c,"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'total_suspended_solid_c',
                'label' => 'total_suspended_solid_c_label',
                'value' => 'ifElse(equal($physical_state_c,"Liquid and Solid"),$total_suspended_solid_c,"")',
            ),
        ),
    ),
);

//$dependencies["WPM_Waste_Profile_Template"]["free_liquid_c_synofieldmask"] = array(
//    'hooks' =>
//    array(
//        0 => 'edit',
//        1 => 'save',
//    ),
//    'trigger' => 'true',
//    'triggerFields' =>
//    array(
//        0 => 'free_liquid_c',
//        0 => 'settled_solid_c',
//        0 => 'total_suspended_solid_c',
//    ),
//    'onload' => true,
//    'actions' =>
//    array(
//        0 =>
//        array(
//            'name' => 'SetSynoFieldMask',
//            'params' =>
//            array(
//                'target' => 'free_liquid_c',
//                'label' => 'free_liquid_c_label',
//                'value' =>
//                array(
//                    'mask' => '9[9][9][.][9][9]',
//                    'greedy' => false,
//                ),
//            ),
//        ),
//        1 =>
//        array(
//            'name' => 'SetSynoFieldMask',
//            'params' =>
//            array(
//                'target' => 'settled_solid_c',
//                'label' => 'settled_solid_c_label',
//                'value' =>
//                array(
//                    'mask' => '9[9][9][.][9][9]',
//                    'greedy' => false,
//                ),
//            ),
//        ),
//        2 =>
//        array(
//            'name' => 'SetSynoFieldMask',
//            'params' =>
//            array(
//                'target' => 'total_suspended_solid_c',
//                'label' => 'total_suspended_solid_c_label',
//                'value' =>
//                array(
//                    'mask' => '9[9][9].[9][9]',
//                    'greedy' => false,
//                ),
//            ),
//        ),
//    ),
//);

$dependencies['WPM_Waste_Profile_Template']['notes_on_test_or_knowledge_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_on_test_or_knowledge_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_on_test_or_knowledge_c',
                'label' => 'notes_on_test_or_knowledge_c_label',
                'value' => 'equal($quest_on_test_or_knowledge_c,"Knowledge")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'notes_on_test_or_knowledge_c',
                'value' => 'equal($quest_on_test_or_knowledge_c,"Knowledge")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'notes_on_test_or_knowledge_c_1',
                'value' => 'equal($quest_on_test_or_knowledge_c,"Knowledge")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Template']['notes_on_test_or_knowledge_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_on_test_or_knowledge_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_on_test_or_knowledge_c',
                'label' => 'notes_on_test_or_knowledge_c_label',
                'value' => 'ifElse(equal($quest_on_test_or_knowledge_c,"Knowledge"),$notes_on_test_or_knowledge_c,"")',
            ),
        ),
    ),
);
