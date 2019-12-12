<?php

$dependencies['WPM_Waste_Profile_Module']['generator_type_c_setvalue_dep'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('generator_type_c'),
    'onload' => false,
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'quest_is_cesqg_c',
                'label' => 'quest_is_cesqg_c_label',
                'value' => 'ifElse(equal($generator_type_c,"CESQG"),"Yes","No")',
            ),
        ),
    ),
);

/////////////////////////
$dependencies['WPM_Waste_Profile_Module']['exact_pcb_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('pcb_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'exact_pcb_c',
                'label' => 'exact_pcb_c_label',
                'value' => 'equal($pcb_c,"Exact")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['exact_pcb_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('pcb_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'exact_pcb_c',
                'label' => 'exact_pcb_c_label',
                'value' => 'ifElse(equal($pcb_c,"Exact"),$exact_pcb_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['exact_hoc_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('hoc_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'exact_hoc_c',
                'label' => 'exact_hoc_c_label',
                'value' => 'equal($hoc_c,"Exact")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['exact_hoc_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('hoc_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'exact_hoc_c',
                'label' => 'exact_hoc_c_label',
                'value' => 'ifElse(equal($hoc_c,"Exact"),$exact_hoc_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['undisclosed_hazards_comments_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('undisclosed_hazards_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'undisclosed_hazards_comments_c',
                'label' => 'undisclosed_hazards_comments_c_label',
                'value' => 'equal($undisclosed_hazards_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['undisclosed_hazards_comments_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('undisclosed_hazards_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'undisclosed_hazards_comments_c',
                'label' => 'undisclosed_hazards_comments_c_label',
                'value' => 'ifElse(equal($undisclosed_hazards_c,"Yes"),$undisclosed_hazards_comments_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_foreign_waste_code_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_foreign_waste_code_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_foreign_waste_code_c',
                'label' => 'notes_foreign_waste_code_c_label',
                'value' => 'equal($quest_foreign_waste_code_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_foreign_waste_code_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_foreign_waste_code_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_foreign_waste_code_c',
                'label' => 'notes_foreign_waste_code_c_label',
                'value' => 'ifElse(equal($quest_foreign_waste_code_c,"Yes"),$notes_foreign_waste_code_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_40_cfr_part_1_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_40_cfr_part_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_40_cfr_part_1_c',
                'label' => 'notes_40_cfr_part_1_c_label',
                'value' => 'equal($quest_40_cfr_part_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_40_cfr_part_1_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_40_cfr_part_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_40_cfr_part_1_c',
                'label' => 'notes_40_cfr_part_1_c_label',
                'value' => 'ifElse(equal($quest_40_cfr_part_c,"Yes"),$notes_40_cfr_part_1_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_40_cfr_part_2_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_40_cfr_part_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_40_cfr_part_2_c',
                'label' => 'notes_40_cfr_part_2_c_label',
                'value' => 'equal($quest_40_cfr_part_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_40_cfr_part_2_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_40_cfr_part_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_40_cfr_part_2_c',
                'label' => 'notes_40_cfr_part_2_c_label',
                'value' => 'ifElse(equal($quest_40_cfr_part_c,"Yes"),$notes_40_cfr_part_2_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['neshap_rules_c_readonly_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_one_of_neshap_rule_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'neshap_rules_c',
                'value' => 'not(equal($quest_one_of_neshap_rule_c,"Yes"))',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['neshap_rules_c_setvalue_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_one_of_neshap_rule_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'neshap_rules_c',
                'label' => 'neshap_rules_c_label',
                'value' => 'ifElse(equal($quest_one_of_neshap_rule_c,"Yes"),$neshap_rules_c,"")',
            ),
        ),
    ),
);

//////////////////////////////////////
$dependencies['WPM_Waste_Profile_Module']['notes_usepa_hazardous_waste_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_usepa_hazardous_waste_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_usepa_hazardous_waste_c',
                'label' => 'notes_usepa_hazardous_waste_c_label',
                'value' => 'equal($quest_usepa_hazardous_waste_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_usepa_hazardous_waste_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_usepa_hazardous_waste_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_usepa_hazardous_waste_c',
                'label' => 'notes_usepa_hazardous_waste_c_label',
                'value' => 'ifElse(equal($quest_usepa_hazardous_waste_c,"Yes"),$notes_usepa_hazardous_waste_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_any_state_code_apply_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_any_state_code_apply_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_any_state_code_apply_c',
                'label' => 'notes_any_state_code_apply_c_label',
                'value' => 'equal($quest_any_state_code_apply_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_any_state_code_apply_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_any_state_code_apply_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_any_state_code_apply_c',
                'label' => 'notes_any_state_code_apply_c_label',
                'value' => 'ifElse(equal($quest_any_state_code_apply_c,"Yes"),$notes_any_state_code_apply_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_texas_waste_code_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_any_state_code_apply_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_texas_waste_code_c',
                'label' => 'notes_texas_waste_code_c_label',
                'value' => 'equal($quest_any_state_code_apply_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['notes_texas_waste_code_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_any_state_code_apply_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_texas_waste_code_c',
                'label' => 'notes_texas_waste_code_c_label',
                'value' => 'ifElse(equal($quest_any_state_code_apply_c,"Yes"),$notes_texas_waste_code_c,"")',
            ),
        ),
    ),
);

//////////////////////////////////////
$dependencies['WPM_Waste_Profile_Module']['quest_waste_from_facility_c_1_hide'] = array(
    'hooks' => array("all"),
    'triggerFields' => array('quest_is_usepa_hazardous_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'quest_waste_from_facility_c_1',
                'value' => 'equal($quest_is_usepa_hazardous_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'quest_total_annual_benzene_c_1',
                'value' => 'equal($quest_is_usepa_hazardous_c,"Yes")',
            ),
        ),
//        array(
//            'name' => 'SetVisibility',
//            'params' => array(
//                'target' => 'notes_tab_quantity_c_1',
//                'value' => 'equal($quest_is_usepa_hazardous_c,"Yes")',
//            ),
//        ),
//        array(
//            'name' => 'SetVisibility',
//            'params' => array(
//                'target' => 'notes_describe_knowledge_c_header_1',
//                'value' => 'equal($quest_is_usepa_hazardous_c,"Yes")',
//            ),
//        ),
//        array(
//            'name' => 'SetVisibility',
//            'params' => array(
//                'target' => 'notes_describe_knowledge_c_header_2',
//                'value' => 'equal($quest_is_usepa_hazardous_c,"Yes")',
//            ),
//        ),
//        array(
//            'name' => 'SetVisibility',
//            'params' => array(
//                'target' => 'notes_describe_knowledge_c_1',
//                'value' => 'equal($quest_is_usepa_hazardous_c,"Yes")',
//            ),
//        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['quest_waste_from_facility_c_1_hide_step_down'] = array(
    'hooks' => array("all"),
    'triggerFields' => array('quest_is_usepa_hazardous_c', 'quest_total_annual_benzene_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'notes_tab_quantity_c',
                'value' => 'and(equal($quest_is_usepa_hazardous_c,"Yes"),equal($quest_total_annual_benzene_c,"Yes"))',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'notes_describe_knowledge_c',
                'value' => 'and(equal($quest_is_usepa_hazardous_c,"Yes"),equal($quest_total_annual_benzene_c,"Yes"))',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'notes_tab_quantity_c_1',
                'value' => 'and(equal($quest_is_usepa_hazardous_c,"Yes"),equal($quest_total_annual_benzene_c,"Yes"))',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'notes_describe_knowledge_c_header_1',
                'value' => 'and(equal($quest_is_usepa_hazardous_c,"Yes"),equal($quest_total_annual_benzene_c,"Yes"))',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'notes_describe_knowledge_c_header_2',
                'value' => 'and(equal($quest_is_usepa_hazardous_c,"Yes"),equal($quest_total_annual_benzene_c,"Yes"))',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'notes_describe_knowledge_c_1',
                'value' => 'and(equal($quest_is_usepa_hazardous_c,"Yes"),equal($quest_total_annual_benzene_c,"Yes"))',
            ),
        ),
    ),
);
/////////////////////////////////////////
$dependencies['WPM_Waste_Profile_Module']['benzene_container_dep'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('quest_is_usepa_hazardous_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'quest_waste_from_facility_c',
                'label' => 'quest_waste_from_facility_c_label',
                'value' => 'ifElse(equal($quest_is_usepa_hazardous_c,"Yes"),$quest_waste_from_facility_c,"No")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'quest_total_annual_benzene_c',
                'label' => 'quest_total_annual_benzene_c_label',
                'value' => 'ifElse(equal($quest_is_usepa_hazardous_c,"Yes"),$quest_total_annual_benzene_c,"No")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['benzene_container_dep_step_down'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('quest_is_usepa_hazardous_c', 'quest_total_annual_benzene_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_tab_quantity_c',
                'label' => 'notes_tab_quantity_c_label',
                'value' => 'ifElse(equal($quest_is_usepa_hazardous_c,"Yes"),ifElse(equal($quest_total_annual_benzene_c,"Yes"),$notes_tab_quantity_c,""),"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'notes_describe_knowledge_c',
                'label' => 'notes_describe_knowledge_c_label',
                'value' => 'ifElse(equal($quest_is_usepa_hazardous_c,"Yes"),ifElse(equal($quest_total_annual_benzene_c,"Yes"),$notes_describe_knowledge_c,""),"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['quest_total_annual_benzene_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('quest_total_annual_benzene_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_tab_quantity_c',
                'label' => 'notes_tab_quantity_c_label',
                'value' => 'equal($quest_total_annual_benzene_c,"Yes")',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'notes_describe_knowledge_c',
                'label' => 'notes_describe_knowledge_c_label',
                'value' => 'equal($quest_total_annual_benzene_c,"Yes")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['other_shipment_frequency_c_required_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('estimated_shipment_frequency_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'other_shipment_frequency_c',
                'label' => 'other_shipment_frequency_c_label',
                'value' => 'equal($estimated_shipment_frequency_c,"Other")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['other_shipment_frequency_c_dep_save'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('estimated_shipment_frequency_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'other_shipment_frequency_c',
                'label' => 'other_shipment_frequency_c_label',
                'value' => 'ifElse(equal($estimated_shipment_frequency_c,"Other"),$other_shipment_frequency_c,"")',
            ),
        ),
    ),
);
