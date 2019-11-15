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

$module = 'LR_Lab_Reports';
$viewdefs[$module]['base']['filter']['file'] = array(
    'quicksearch_field' => array_merge(array(), getViewColumns($module, 'listview')),
    'quicksearch_priority' => 2,
);
