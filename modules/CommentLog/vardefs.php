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

$dictionary['CommentLog'] = [
    'table' => 'commentlog',
    'audited' => false,
    'comment' => 'CommentLog entries that are related to a record',
    'duplicate_merge' => false,
    'unified_search' => true,
    'full_text_search' => false, // prevent comment log from appearing in list of global searchable modules
    'unified_search_default_enabled' => true,
    'fields' => [
        'entry' => [
            'name' => 'entry',
            'vname' => 'LBL_ENTRY',
            'type' => 'text',
        ],
    ],
    'ignore_templates' => [
        'commentlog',
    ],
    'uses' => [
        'basic',
    ],
    'load_fields' => [
        'class' => 'CommentLogRelatedModulesUtilities',
        'method' => 'getRelatedFields',
    ],
];

VardefManager::createVardef('CommentLog', 'CommentLog');
