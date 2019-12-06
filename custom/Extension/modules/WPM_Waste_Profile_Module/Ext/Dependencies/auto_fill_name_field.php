<?php

$dependencies['WPM_Waste_Profile_Module']['auto_fill_name_field'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'onload' => true,
    'triggerFields' => array('waste_profile_num_c', 'wp_waste_name_c', 'generator_c'),
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'name',
                'value' => 'ifElse(
                            and(
                                not(equal($waste_profile_num_c,"")),
                                not(
                                    equal(
                                        ifElse(
                                            and(
                                                not(equal($wp_waste_name_c,"")), not(equal($generator_c,""))
                                            ),
                                            concat($wp_waste_name_c, " | ", $generator_c), 
                                            concat($wp_waste_name_c, $generator_c)
                                        ),""
                                    )
                                )
                            ),
                            concat(
                                $waste_profile_num_c, 
                                " | ", 
                                ifElse(
                                    and(
                                        not(equal($wp_waste_name_c,"")), not(equal($generator_c,""))
                                    ),
                                    concat($wp_waste_name_c, " | ", $generator_c), 
                                    concat($wp_waste_name_c, $generator_c)
                                )
                            ), 
                            concat(
                                $waste_profile_num_c, 
                                ifElse(
                                    and(
                                        not(equal($wp_waste_name_c,"")),not(equal($generator_c,""))
                                    ),
                                    concat($wp_waste_name_c, " | ", $generator_c), 
                                    concat($wp_waste_name_c, $generator_c)
                                )
                            ) 
                        )',
            )
        ),
    )
);

$dependencies['WPM_Waste_Profile_Module']['wpm_waste_profile_module_name_read_only'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array(''),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    // You could list multiple fields here each in their own array under 'actions'
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'name',
                'value' => 'true',
            ),
        ),
    ),
);
