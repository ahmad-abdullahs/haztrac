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

namespace Sugarcrm\Sugarcrm\IdentityProvider;

/**
 * Oauth2 state session registry.
 *
 * Class OAuth2StateRegistry
 * @package Sugarcrm\Sugarcrm\IdentityProvider
 */
class OAuth2StateRegistry
{
    /**
     * Register state
     * @param string $state
     */
    public function registerState(string $state): void
    {
        if (!session_id()) {
            session_start();
        }
        $_SESSION[$state] = true;
    }

    /**
     * Checks if state is registered
     * @param string $state
     * @return bool
     */
    public function isStateRegistered(string $state): bool
    {
        return isset($_SESSION[$state]);
    }

    /**
     * Unregister state
     *
     * @param string $state
     */
    public function unregisterState(string $state): void
    {
        unset($_SESSION[$state]);
    }
}
