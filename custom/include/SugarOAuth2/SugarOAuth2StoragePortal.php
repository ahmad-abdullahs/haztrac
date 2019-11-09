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

require_once 'include/SugarOAuth2/SugarOAuth2StoragePortal.php';

class CustomSugarOAuth2StoragePortal extends SugarOAuth2StoragePortal {

    /**
     * Sets up necessary visibility for a client. Not all clients will set this
     *
     * @return void
     */
    public function setupVisibility() {
        // Add the necessary visibility and acl classes to the default bean list
        $default_acls = SugarBean::getDefaultACL();
        // This one overrides the Static ACL's, so disable that
        unset($default_acls['SugarACLStatic']);
        $default_acls['SugarACLStatic'] = false;
        $default_acls['SugarACLSupportPortal'] = true;
        SugarBean::setDefaultACL($default_acls);
        SugarACL::resetACLs();

        $default_visibility = SugarBean::getDefaultVisibility();
        $default_visibility['CustomSupportPortalVisibility'] = true;
        SugarBean::setDefaultVisibility($default_visibility);
        $GLOBALS['log']->debug("Added SupportPortalVisibility to session.");
    }

}
