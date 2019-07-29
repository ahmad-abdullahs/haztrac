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

$dictionary['LR_Lab_Reports'] = array(
    'table' => 'lr_lab_reports',
    'audited' => true,
    'activity_enabled' => false,
    'fields' => array (
  'report_number' => 
  array (
    'name' => 'report_number',
    'vname' => 'LBL_NUMBER',
    'type' => 'int',
    'readonly' => true,
    'len' => 11,
    'required' => true,
    'auto_increment' => true,
    'unified_search' => true,
    'full_text_search' => 
    array (
      'enabled' => true,
      'searchable' => true,
      'boost' => 1.25,
    ),
    'comment' => 'Visual unique identifier',
    'duplicate_merge' => 'disabled',
    'disable_num_format' => true,
    'studio' => 
    array (
      'quickcreate' => false,
    ),
    'duplicate_on_record_copy' => 'no',
  ),
),
  'indices' => 
  array (
    'number' => 
    array (
      'name' => 'report_numk',
      'type' => 'unique',
      'fields' => 
      array (
        0 => 'report_number',
      ),
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
VardefManager::createVardef('LR_Lab_Reports','LR_Lab_Reports', array('basic','team_security','assignable','taggable','file'));