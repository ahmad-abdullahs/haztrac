<?php

$dictionary['LR_Lab_Reports']['fields']['lr_lab_reports_analysis_templates'] = array(
    'name' => 'lr_lab_reports_analysis_templates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getLabReportTemplates',
    'vname' => 'LBL_LR_LAB_REPORTS_ANALYSIS_TEMPLATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
    'module' => 'LR_Lab_Reports_Templates',
    'populate_list' => array(
        // LR_Lab_Reports_Templates =>  LR_Lab_Reports
        'lab_analysis' => 'lab_analysis_c',
        'analysis_metals' => 'analysis_metals_c',
        'special_instructions' => 'special_instructions_c',
        'instructions' => 'instructions_c',
    ),
);
