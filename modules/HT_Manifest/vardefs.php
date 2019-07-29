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

$dictionary['HT_Manifest'] = array(
    'table' => 'ht_manifest',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
      'manifest_number' => 
      array (
        'name' => 'manifest_number',
        'vname' => 'LBL_MANIFEST_NUMBER',
        'type' => 'varchar',
        'len' => 255,
        'readonly' => true,
        'duplicate_on_record_copy' => 'no',
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
VardefManager::createVardef('HT_Manifest','HT_Manifest', array('basic','team_security','assignable','taggable'));