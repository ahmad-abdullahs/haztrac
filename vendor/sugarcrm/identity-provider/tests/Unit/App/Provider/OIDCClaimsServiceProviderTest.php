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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Provider;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Provider\OIDCClaimsServiceProvider;

/**
 * @coversDefaultClass Sugarcrm\IdentityProvider\App\Provider\OIDCClaimsServiceProvider
 */
class OIDCClaimsServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::register
     */
    public function testRegister()
    {
        /** @var Application | \PHPUnit_Framework_MockObject_MockObject */
        $application = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->setMethods([])->getMock();

        (new OIDCClaimsServiceProvider())->register($application);

        $this->assertInstanceOf(
            'Sugarcrm\IdentityProvider\App\Authentication\OpenId\StandardClaimsService',
            $application->getOIDCClaimsService()
        );
    }
}
