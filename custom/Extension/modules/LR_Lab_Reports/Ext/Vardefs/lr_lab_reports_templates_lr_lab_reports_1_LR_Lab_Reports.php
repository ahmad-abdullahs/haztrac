<?php

// created: 2019-10-16 01:33:23
$dictionary["LR_Lab_Reports"]["fields"]["lr_lab_reports_templates_lr_lab_reports_1"] = array(
    'name' => 'lr_lab_reports_templates_lr_lab_reports_1',
    'type' => 'link',
    'relationship' => 'lr_lab_reports_templates_lr_lab_reports_1',
    'source' => 'non-db',
    'module' => 'LR_Lab_Reports_Templates',
    'bean_name' => 'LR_Lab_Reports_Templates',
    'side' => 'right',
    'vname' => 'LBL_LR_LAB_REPORTS_TEMPLATES_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE',
    'id_name' => 'lr_lab_repd2cdmplates_ida',
    'link-type' => 'one',
);
$dictionary["LR_Lab_Reports"]["fields"]["lr_lab_reports_templates_lr_lab_reports_1_name"] = array(
    'name' => 'lr_lab_reports_templates_lr_lab_reports_1_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_LR_LAB_REPORTS_TEMPLATES_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TEMPLATES_TITLE',
    'save' => true,
    'id_name' => 'lr_lab_repd2cdmplates_ida',
    'link' => 'lr_lab_reports_templates_lr_lab_reports_1',
    'table' => 'lr_lab_reports_templates',
    'module' => 'LR_Lab_Reports_Templates',
    'rname' => 'name',
    'auto_populate' => true,
    'populate_list' => array(
        'lab_analysis' => 'lab_analysis_c',
        'analysis_metals' => 'analysis_metals_c',
        'special_instructions' => 'special_instructions_c',
        'instructions' => 'instructions_c',
    ),
);
$dictionary["LR_Lab_Reports"]["fields"]["lr_lab_repd2cdmplates_ida"] = array(
    'name' => 'lr_lab_repd2cdmplates_ida',
    'type' => 'id',
    'source' => 'non-db',
    'vname' => 'LBL_LR_LAB_REPORTS_TEMPLATES_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE_ID',
    'id_name' => 'lr_lab_repd2cdmplates_ida',
    'link' => 'lr_lab_reports_templates_lr_lab_reports_1',
    'table' => 'lr_lab_reports_templates',
    'module' => 'LR_Lab_Reports_Templates',
    'rname' => 'id',
    'reportable' => false,
    'side' => 'right',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
);
