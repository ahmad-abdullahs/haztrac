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

$config = [

    'admin' => [
        'core:AdminPassword',
    ],

    'example-userpass' => [
        'exampleauth:UserPass',
        'user1:user1pass' => [
            'uid' => ['1'],
            'eduPersonAffiliation' => ['group1'],
            'email' => 'user1@example.com',
        ],
        'user2:user2pass' => [
            'uid' => ['2'],
            'eduPersonAffiliation' => ['group2'],
            'email' => 'user2@example.com',
        ],
        'user3:user3pass' => [
            'uid' => ['3'],
            'eduPersonAffiliation' => ['group1'],
            'email' => 'user3@example.com',
        ],
        'user4:user4pass' => [
            'uid' => ['4'],
            'eduPersonAffiliation' => ['group2'],
            'email' => 'user4@example.com',
        ],
        'user5:user5pass' => [
            'uid' => ['5'],
            'eduPersonAffiliation' => ['group1'],
            'email' => 'user5@example.com',
        ],
    ],

];
