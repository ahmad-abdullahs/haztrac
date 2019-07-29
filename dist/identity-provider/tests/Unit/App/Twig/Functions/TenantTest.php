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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Twig\Functions;

use Sugarcrm\IdentityProvider\App\Application;

use Sugarcrm\IdentityProvider\App\Repository\TenantRepository;
use Sugarcrm\IdentityProvider\App\Twig\Extension;
use Sugarcrm\IdentityProvider\App\Twig\Functions\Tenant as TenantFunction;

use Sugarcrm\IdentityProvider\Authentication\Tenant;
use Sugarcrm\IdentityProvider\Srn;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class TenantTest
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Twig\Functions\Tenant
 */
class TenantTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TenantFunction
     */
    private $function;

    /**
     * @var Session|\PHPUnit_Framework_MockObject_MockObject
     */
    private $session;

    /**
     * @var TenantRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $tenantRepository;


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->session = $this->createMock(Session::class);
        $this->tenantRepository = $this->createMock(TenantRepository::class);

        $this->function = new TenantFunction($this->session, $this->tenantRepository);
    }

    /**
     * @covers ::getTenant
     */
    public function testEmptySession()
    {
        $this->session->method('get')->willReturn(null);
        $this->session->expects($this->once())->method('get');

        $this->assertNull($this->function->getTenant());
    }

    /**
     * @covers ::getTenant
     */
    public function testTenantNotFound()
    {
        $srnString = 'srn:cloud:idp:eu:1234567890:tenant:12345678901';

        $this->session->method('get')->willReturn($srnString);
        $this->session->expects($this->once())->method('get');

        $this->tenantRepository->method('findTenantById')->willThrowException(new \RuntimeException());
        $this->tenantRepository->expects($this->once())->method('findTenantById');

        $this->assertNull($this->function->getTenant());
    }

    /**
     * @covers ::getTenant
     */
    public function testTenantFound()
    {
        $srnString = 'srn:cloud:idp:eu:1234567890:tenant:12345678901';
        $tenant = Tenant::fromSrn(Srn\Converter::fromString($srnString))
            ->setDisplayName($name = 'some-name')
            ->setLogo($logo = 'some-logo');

        $this->session->method('get')->willReturn($srnString);
        $this->session->expects($this->once())->method('get');

        $this->tenantRepository->method('findTenantById')->willReturn($tenant);
        $this->tenantRepository
            ->expects($this->once())
            ->method('findTenantById')
            ->with('1234567890');

        $this->assertEquals($tenant, $this->function->getTenant());
    }
}
