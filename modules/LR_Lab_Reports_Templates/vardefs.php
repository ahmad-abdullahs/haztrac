<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$dictionary['LR_Lab_Reports_Templates'] = array(
    'table' => 'lr_lab_reports_templates',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array(
        'lab_analysis' =>
        array(
            'labelValue' => 'Lab Analysis',
            'dependency' => '',
            'visibility_grid' => '',
            'required' => false,
            'name' => 'lab_analysis',
            'vname' => 'LBL_LAB_ANALYSIS',
            'type' => 'multienum',
            'massupdate' => true,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => 1,
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'pii' => false,
            'calculated' => false,
            'size' => '20',
            'options' => 'lab_analysis_list',
            'default' => NULL,
            'isMultiSelect' => true,
        ),
        'analysis_metals' =>
        array(
            'labelValue' => 'Analysis Metals',
            'dependency' => '',
            'visibility_grid' => '',
            'required' => false,
            'name' => 'analysis_metals',
            'vname' => 'LBL_ANALYSIS_METALS',
            'type' => 'multienum',
            'massupdate' => true,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => 1,
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'pii' => false,
            'calculated' => false,
            'size' => '20',
            'options' => 'lab_metals',
            'default' => NULL,
            'isMultiSelect' => true,
        ),
        'special_instructions' =>
        array(
            'labelValue' => 'Special Instructions',
            'full_text_search' =>
            array(
                'enabled' => '0',
                'boost' => '1',
                'searchable' => false,
            ),
            'enforced' => '',
            'dependency' => '',
            'required' => false,
            'name' => 'special_instructions',
            'vname' => 'LBL_SPECIAL_INSTRUCTIONS',
            'type' => 'text',
            'massupdate' => false,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => 1,
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'pii' => false,
            'calculated' => false,
            'size' => '20',
            'studio' => 'visible',
            'rows' => '6',
            'cols' => '80',
        ),
        'instructions' =>
        array(
            'labelValue' => 'Lab Instructions',
            'full_text_search' =>
            array(
                'enabled' => '0',
                'boost' => '1',
                'searchable' => false,
            ),
            'enforced' => '',
            'dependency' => '',
            'required' => false,
            'name' => 'instructions',
            'vname' => 'LBL_INSTRUCTIONS',
            'type' => 'text',
            'massupdate' => false,
            'no_default' => false,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => 1,
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'pii' => false,
            'calculated' => false,
            'size' => '20',
            'studio' => 'visible',
            'rows' => '6',
            'cols' => '80',
        ),
    ),
    'relationships' => array(
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
    'full_text_search' => true,
);

if (!class_exists('VardefManager')) {
    
}
VardefManager::createVardef('LR_Lab_Reports_Templates', 'LR_Lab_Reports_Templates', array('basic', 'team_security', 'assignable', 'taggable'));
