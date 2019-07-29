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

$dictionary['HT_Assets_and_Objects'] = array(
    'table' => 'ht_assets_and_objects',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
    	'asset_number' => 
        array (
          'name' => 'asset_number',
          'vname' => 'LBL_ASSET_NUMBER',
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
            'boost' => 1.29,
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
    'relationships' => array (
	),
    'indices' => array(
        'number' =>  array (
          'name' => 'assetnumk',
          'type' => 'unique',
          'fields' => array (
            0 => 'asset_number',
          ),
        ),
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
    'full_text_search' => true,
);

if (!class_exists('VardefManager')){
}
VardefManager::createVardef('HT_Assets_and_Objects','HT_Assets_and_Objects', array('basic','team_security','assignable','taggable'));