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

namespace Sugarcrm\IdentityProvider\Tests\Unit\Encoder;

use Sugarcrm\IdentityProvider\Encoder\BCryptPasswordEncoder;

class BCryptPasswordEncoderTest extends \PHPUnit_Framework_TestCase
{
    const COST = 10;

    public function isPasswordValidDataProvider()
    {
        return [
            'valid' => [true, '$2y$10$DjRjiUzFwTAEbM8RHCWEweUTkGWbBgaSPJzM3yfNKl9LB/OXm/H1G', 'secret'],
            'valid_md5' => [true, '$2y$10$NXgOtEGD.Ys/jVK2n9gIOecuBWDNfEyWV7lt/9XoJCAjUW6XpFQgK', 'secret'],
            'invalid' => [false, '$5$rounds=5000$1234567812345678$wrongHash', 'secret'],
        ];
    }

    /**
     * @dataProvider isPasswordValidDataProvider
     */
    public function testIsPasswordValid($expected, $hash, $secret)
    {
        $encoder = new BCryptPasswordEncoder(self::COST);
        $this->assertEquals($expected, $encoder->isPasswordValid($hash, $secret, 'salt is ignored'));
    }
}
