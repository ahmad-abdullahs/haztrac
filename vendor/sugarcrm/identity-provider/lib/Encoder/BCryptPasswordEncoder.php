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

namespace Sugarcrm\IdentityProvider\Encoder;

class BCryptPasswordEncoder extends \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder
{
    /**
     * {@inheritdoc}
     *
     * @param string $encoded An encoded password
     * @param string $raw     A raw password
     * @param string $salt    Salt parameter is ignored for SHA-2 as it's stored directly in the hash
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return parent::isPasswordValid($encoded, $raw, $salt) || parent::isPasswordValid($encoded, md5($raw), $salt);
    }
}
