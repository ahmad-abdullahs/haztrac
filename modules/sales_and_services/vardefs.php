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

$dictionary['sales_and_services'] = array(
    'table' => 'sales_and_services',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
        'ss_number' => 
        array (
          'name' => 'ss_number',
          'vname' => 'LBL_SS_NUMBER',
          'type' => 'varchar',
          'readonly' => true,
          'len' => 255,
          'required' => false,
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
    ),
    'optimistic_locking' => true,
    'unified_search' => true,
    'full_text_search' => true,
);

if (!class_exists('VardefManager')){
}
VardefManager::createVardef('sales_and_services','sales_and_services', array('basic','team_security','assignable','taggable'));