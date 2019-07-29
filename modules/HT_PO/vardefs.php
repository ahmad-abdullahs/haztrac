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

$dictionary['HT_PO'] = array(
    'table' => 'ht_po',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
  'po_date' => 
  array (
    'name' => 'po_date',
    'vname' => 'LBL_PO_DATE',
    'type' => 'date',
    'required' => false,
    'enable_range_search' => true,
  ),
  'expire_date' => 
  array (
    'name' => 'expire_date',
    'vname' => 'LBL_EXPIRE_DATE',
    'type' => 'date',
    'required' => false,
    'enable_range_search' => true,
  ),
  'po_status' => 
  array (
    'name' => 'po_status',
    'vname' => 'LBL_PO_STATUS',
    'type' => 'enum',
    'options' => 'po_status_list',
    'len' => '255',
    'duplicate_merge' => 'disabled',
    'studio' => true,
    'reportable' => true,
    'massupdate' => true,
    'importable' => true,
    'default' => 'Open',
    'audited' => true,
    'merge_filter' => 'disabled',
    'calculated' => false,
    'dependency' => false,
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
VardefManager::createVardef('HT_PO','HT_PO', array('basic','team_security','assignable','taggable'));