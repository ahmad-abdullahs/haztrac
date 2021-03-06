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
$searchFields['Teams'] = array(
    'name' => array('query_type' => 'default', 'db_field' => array('name', 'name_2'), 'force_unifiedsearch' => true),
    'private' => array(
        'query_type' => 'default',
        'db_field' => array('private'),
        'force_unifiedsearch' => true,
        'type' => 'bool',
    ),
);
?>
