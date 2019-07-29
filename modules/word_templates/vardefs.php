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

$dictionary['word_templates'] = array(
    'table' => 'word_templates',
    'audited' => true,
    'activity_enabled' => false,
    'fields' => array (
  'word_temp_module' => 
  array (
    'name' => 'word_temp_module',
    'vname' => 'LBL_WORD_TEMP_MODULE',
    'type' => 'enum',
    'help' => '',
    'comment' => '',
    'options' => 'word_templates_modules_list',
    'default_value' => 'sales_and_services',
    'mass_update' => false,
    'required' => true,
    'reportable' => true,
    'audited' => false,
    'importable' => 'true',
    'duplicate_merge' => false,
  ),
),
    'relationships' => array (
),
    'optimistic_locking' => true,
    'unified_search' => true,
    'full_text_search' => true,
);

if (!class_exists('VardefManager')){
}
VardefManager::createVardef('word_templates','word_templates', array('basic','assignable','taggable','file'));