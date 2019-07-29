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

// we extend the prod.php
require_once __DIR__ . '/prod.php';

$config['debug'] = true;

$config['twig']['twig.options'] = ['cache' => false];

$config['grpc']['disabled'] = $params['grpc']['disabled'] ?? false;

$config['translation'] = [
    // set up default in full format. This is mango's requirement
    'default' => 'en-US',
    'fallback' => ['en'],
    'resources' => [
        'en' => '/src/App/Resources/translation/en.xlf',
        'de' => '/src/App/Resources/translation/de.xlf',
    ],
];
