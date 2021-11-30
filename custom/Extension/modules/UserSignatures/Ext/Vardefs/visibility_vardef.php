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
$dictionary['UserSignature']['visibility'] = array(
    'OwnerOrAdminVisibility' => true,
);

$dictionary["UserSignature"]["fields"]["custom_user_name"] = array(
    'source' => 'non-db',
    'name' => 'custom_user_name',
    'rname' => 'name',
    'vname' => 'LBL_USER_NAME',
    'type' => 'relate',
    'len' => 255,
    'size' => '20',
    'id_name' => 'user_id',
    'module' => 'Users',
    'quicksearch' => 'enabled',
    'studio' => 'visible',
);

$dictionary["UserSignature"]["fields"]["user_id"] = array(
    'required' => false,
    'source' => 'db',
    'name' => 'user_id',
    'vname' => 'LBL_USER_NAME',
    'type' => 'id',
    'len' => 36,
    'size' => '20',
);
