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
namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Entity;

use Sugarcrm\IdentityProvider\App\Entity\UserProvider;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Entity\UserProvider
 */
class UserProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::setTenantId
     * @covers ::setUserId
     * @covers ::setIdentityValue
     * @covers ::setProviderCode
     * @covers ::getTenantId
     * @covers ::getUserId
     * @covers ::getIdentityValue
     * @covers ::getProviderCode
     */
    public function testSettersAndGetters(): void
    {
        $userProvider = new UserProvider();
        $userProvider->setTenantId('tenantId');
        $userProvider->setUserId('userId');
        $userProvider->setIdentityValue('identityValue');
        $userProvider->setProviderCode('local');

        $this->assertEquals('tenantId', $userProvider->getTenantId());
        $this->assertEquals('userId', $userProvider->getUserId());
        $this->assertEquals('identityValue', $userProvider->getIdentityValue());
        $this->assertEquals('local', $userProvider->getProviderCode());
    }

    /**
     * @covers ::fromArray
     */
    public function testFromArray(): void
    {
        $userProvider = UserProvider::fromArray([
            'tenant_id' => 'tenantId',
            'user_id' => 'userId',
            'provider_code' => 'local',
            'identity_value' => 'identityValue',
        ]);

        $this->assertEquals('tenantId', $userProvider->getTenantId());
        $this->assertEquals('userId', $userProvider->getUserId());
        $this->assertEquals('identityValue', $userProvider->getIdentityValue());
        $this->assertEquals('local', $userProvider->getProviderCode());
    }
}
