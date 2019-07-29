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

// moved from hint_accountsets_targetsMetaData.php
$dictionary['hint_accountsets_targets'] = [
    'true_relationship_type' => 'many-to-many',
    'from_studio' => false,
    'relationships' => [
        'hint_accountsets_targets' => [
            'lhs_module' => 'HintAccountsets',
            'lhs_table' => 'hint_accountsets',
            'lhs_key' => 'id',
            'rhs_module' => 'HintNotificationTargets',
            'rhs_table' => 'hint_notification_targets',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'hint_accountsets_targets',
            'join_key_lhs' => 'accountset_id',
            'join_key_rhs' => 'target_id',
        ],
    ],
    'table' => 'hint_accountsets_targets',
    'fields' => [
        'id' => [
            'name' => 'id',
            'type' => 'id',
        ],
        'accountset_id' => [
            'name' => 'accountset_id',
            'type' => 'id',
        ],
        'target_id' => [
            'name' => 'target_id',
            'type' => 'id',
        ],
        'date_modified' => [
            'name' => 'date_modified',
            'type' => 'datetime',
        ],
        'deleted' => [
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => true,
        ],
    ],
    'indices' => [
        [
            'name' => 'accountsets_targets_pk',
            'type' => 'primary',
            'fields' => [
                'id',
            ],
        ],
        [
            'name' => 'accountsets_targets_acc_idk',
            'type' => 'index',
            'fields' => [
                'accountset_id',
            ],
        ],
        [
            'name' => 'accountsets_targets_trg_idk',
            'type' => 'alternate_key',
            'fields' => [
                'target_id',
            ],
        ],
    ],
];

// moved from hint_events_queueMetaData.php
$dictionary['hint_events_queue'] = [
    'table' => 'hint_events_queue',
    'module' => 'application',
    'from_studio' => false,
    'fields' => [
        'id' => [
            'name' => 'id',
            'type' => 'id',
            'required' => true,
        ],
        'type' => [
            'name' => 'type',
            'type' => 'varchar',
            'len' => '32',
            'required' => true,
        ],
        'data' => [
            'name' => 'data',
            'type' => 'longtext',
            'required' => true,
        ],
        'user_id' => [
            'name' => 'user_id',
            'type' => 'id',
        ],
        'processing_instance' => [
            'name' => 'processing_instance',
            'type' => 'varchar',
            'len' => '32',
            'default' => null,
            'required' => false,
        ],
        'processing_start_time' => [
            'name' => 'processing_start_time',
            'type' => 'datetime',
            'default' => null,
            'required' => false,
        ],
        // the way to handle event order
        'group_ms' => [
            'name' => 'group_ms',
            'dbType' => 'decimal',
            'type' => 'float',
            'len' => '26,4',
            'default' => '0',
            'readonly' => true,
            'required' => true,
        ],
        'event_number' => [
            'name' => 'event_number',
            'type' => 'int',
            'readonly' => true,
            'required' => true,
            'auto_increment' => true,
        ],
        'created' => [
            'name' => 'created',
            'type' => 'datetime',
            'required' => true,
        ],
    ],
    'indices' => [
        [
            'name' => 'hint_events_queue_pk',
            'type' => 'primary',
            'fields' => [
                'id',
            ],
        ],
        [
            'name' =>'event_number_uk',
            'type' => 'unique',
            'fields'=> [
                'event_number',
            ],
        ],
        [
            'name' => 'hint_events_queue_instance_ordered_idk',
            'type' => 'index',
            'fields' => [
                'processing_instance',
                'group_ms',
                'event_number',
            ],
        ],
        [
            'name' => 'hint_events_queue_start_time_idk',
            'type' => 'index',
            'fields' => [
                'processing_start_time',
            ],
        ],
    ],
];
