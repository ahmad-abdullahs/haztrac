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

$dictionary['Doc_Manager'] = array(
    'table' => 'doc_manager',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array(
        'base_module' => array(
            'required' => true,
            'name' => 'base_module',
            'vname' => 'LBL_BASE_MODULE',
            'type' => 'enum',
            'massupdate' => 0,
            'default' => '',
            'function' => 'getDocManagerAvailableModules',
            'importable' => 'false',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => true,
            'reportable' => false,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'calculated' => false,
            'len' => 100,
            'size' => '20',
            'studio' => true,
            'dependency' => false,
        ),
        'description' =>
        array(
            'name' => 'description',
            'vname' => 'LBL_DESCRIPTION',
            'type' => 'text',
            'showButton' => false,
            'comment' => 'Full text of the note',
            'full_text_search' =>
            array(
                'enabled' => true,
                'searchable' => true,
                'boost' => 0.5,
            ),
            'rows' => 1,
            'cols' => 80,
            'duplicate_on_record_copy' => 'always',
        ),
        'potential_id' =>
        array(
            'name' => 'potential_id',
            'vname' => 'LBL_POTENTIAL_ID',
            'type' => 'varchar',
            'studio' => false,
            'source' => 'non-db',
        ),
        'doc_template' =>
        array(
            'default' => '',
            'height' => '720',
            'required' => false,
            'source' => 'db',
            'name' => 'doc_template',
            'vname' => 'LBL_DOC_TEMPLATE',
            'type' => 'iframe',
            'massupdate' => false,
            'no_default' => false,
            'importable' => 'true',
            'duplicate_merge' => 'enabled',
            'duplicate_merge_dom_value' => 1,
            'audited' => false,
            'reportable' => true,
            'unified_search' => false,
            'merge_filter' => 'disabled',
            'len' => 255,
            'size' => '20',
            'dbType' => 'varchar',
            'gen' => '0',
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
VardefManager::createVardef('Doc_Manager', 'Doc_Manager', array('basic', 'team_security', 'assignable', 'taggable'));
