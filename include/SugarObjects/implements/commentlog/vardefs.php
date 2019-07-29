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

$vardefs = array(
    'fields' => array(
        'commentlog' =>  array(
            'name' => 'commentlog',
            'vname' => 'LBL_COMMENTLOG',
            'type' => 'collection',
            'displayParams' => array(
                'type' => 'commentlog',
                'fields' => array(
                    'entry',
                    'date_entered',
                    'created_by_name',
                ),
                'max_num' => 100,
            ),
            'links' => array('commentlog_link'),
            'order_by' => 'date_entered:asc',
            'source' => 'non-db',
            'module' => 'CommentLog',
            'studio' => array(
                'listview' => false,
                'recordview' => true,
            ),
            'full_text_search' => array(
                'enabled' => true,
                'searchable' => true,
            ),
        ),
        'commentlog_link' => array(
            'name' => 'commentlog_link',
            'type' => 'link',
            'vname' => 'LBL_COMMENTLOG_LINK',
            'relationship' => strtolower($module).'_commentlog',
            'source' => 'non-db',
            'exportable' => false,
            'duplicate_merge' => 'disabled',
        ),
    ),
    'relationships' => array(
        strtolower($module).'_commentlog' => array(
            'lhs_module' => $module,
            'lhs_table' => $table_name,
            'lhs_key' => 'id',
            'rhs_module' => 'CommentLog',
            'rhs_table' => 'commentlog',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'commentlog_rel',
            'join_key_lhs' => 'record_id',
            'join_key_rhs' => 'commentlog_id',
            'relationship_role_column' => 'module',
            'relationship_role_column_value' => $module,
        ),
    ),
);
