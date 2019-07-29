<?php

$dependencies['LR_Lab_Reports']['auto_fill_fields_on_analysis_templates_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true', 
    'onload' => false,
    'triggerFields' => array('analysis_templates_c'), 
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'coa_pcb_c',
                'value' => 'ifElse(or(equal($analysis_templates_c,"ULO 279.11 On Spec"),equal($analysis_templates_c,"ULO CA On Spec")),true,false)'
            )
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'metal_lead_c',
                'value' => 'ifElse(equal($analysis_templates_c,"ULO 279.11 On Spec"),true,false)'
            )
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'metal_chromium_c',
                'value' => 'ifElse(equal($analysis_templates_c,"ULO 279.11 On Spec"),true,false)'
            )
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'metal_cadmium_c',
                'value' => 'ifElse(equal($analysis_templates_c,"ULO 279.11 On Spec"),true,false)'
            )
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'metal_arsenic_c',
                'value' => 'ifElse(equal($analysis_templates_c,"ULO 279.11 On Spec"),true,false)'
            )
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'coa_total_halogens_ppm_c',
                'value' => 'ifElse(or(equal($analysis_templates_c,"ULO 279.11 On Spec"),equal($analysis_templates_c,"ULO CA On Spec")),true,false)'
            )
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'coa_flash_point_pmcc_f_c',
                'value' => 'ifElse(or(equal($analysis_templates_c,"ULO 279.11 On Spec"),equal($analysis_templates_c,"ULO CA On Spec")),true,false)'
            )
        )
    )
);