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


/**
 * Sugar OAuth2.0 Base Storage system, allows the OAuth2 library we are using to
 * store and retrieve data by interacting with our Base client.
 *
 * This class should only be used by the OAuth2 library and cannot be relied
 * on as a stable API for any other sources.
 */
require_once 'include/SugarOAuth2/SugarOAuth2StorageBase.php';

class CustomSugarOAuth2StorageBase extends SugarOAuth2StorageBase {

    /**
     * How many simultaneous sessions allowed for this platform
     *
     * @var int
     */
    public $numSessions = 3;

}
