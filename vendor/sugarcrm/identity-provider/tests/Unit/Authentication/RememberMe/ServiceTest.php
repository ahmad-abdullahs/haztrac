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

namespace Sugarcrm\IdentityProvider\Tests\Unit\Authentication\RememberMe;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Driver\Statement;

use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\Authentication\RememberMe\Service;
use Sugarcrm\IdentityProvider\Authentication\Provider\Providers;
use Sugarcrm\IdentityProvider\Authentication\User;

use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\Authentication\RememberMe\Service
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Connection
     */
    protected $db;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | SessionInterface
     */
    protected $session;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | SessionInterface
     */
    protected $provider;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Service
     */
    protected $service;

    protected function setUp()
    {
        $this->db = $this->createMock(Connection::class);
        $this->session = $this->createMock(SessionInterface::class);

        $this->provider = $this->createMock(LocalUserProvider::class);

        $this->service = $this->getMockBuilder(Service::class)
            ->setConstructorArgs([$this->session, $this->db])
            ->setMethods(['getLocalUserProvider'])
            ->getMock();
        $this->service->expects($this->any())
            ->method('getLocalUserProvider')
            ->willReturn($this->provider);
    }

    /**
     * @covers ::store
     */
    public function testStore()
    {
        $token = $this->createMock(TokenInterface::class);
        $this->session->expects($this->once())
            ->method('set')
            ->with(Service::STORAGE_KEY, [$token]);
        /** @var TokenInterface $token */
        $this->service->store($token);
    }

    /**
     * @covers ::clear
     */
    public function testClear()
    {
        $this->session->expects($this->once())->method('remove');
        $this->service->clear();
    }

    /**
     * @return array
     */
    public function providerRetrieveWrongToken()
    {
        return [
            [$this->createMock(TokenInterface::class)],
            [new UsernamePasswordToken('test', null, Providers::LDAP)],
            [new UsernamePasswordToken('test', null, Providers::LOCAL)],
            [new UsernamePasswordToken(new User(), null, Providers::LOCAL)],
        ];
    }

    /**
     * @covers ::retrieve
     * @param TokenInterface $token
     * @dataProvider providerRetrieveWrongToken
     */
    public function testRetrieveWrongToken(TokenInterface $token)
    {
        $this->session->expects($this->once())->method('get')->willReturn([$token]);
        $this->assertEquals($token, $this->service->retrieve());
    }

    /**
     * @covers ::retrieve
     */
    public function testRetrieveInactiveUser()
    {
        $user = new User('test-user-id', '', [
            'id' => 'test-user-id',
            'password_hash' => 'test_password_hash',
        ]);

        $token = new UsernamePasswordToken($user, null, AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);
        $token->setAttribute('tenantSrn', 'srn:dev:iam:na:1144464366:tenant');

        $this->provider->expects($this->once())
            ->method('loadUserByFieldAndProvider')
            ->with('test-user-id', Providers::LOCAL)
            ->willThrowException(new UsernameNotFoundException());

        $this->session->expects($this->once())->method('remove');
        $this->session->expects($this->once())->method('get')->willReturn([$token]);

        $this->assertNull($this->service->retrieve());
    }

    /**
     * @covers ::retrieve
     */
    public function testRetrieve()
    {
        $user = new User('test-user-id', '', [
            'id' => 'test-user-id',
            'password_hash' => 'test_password_hash',
        ]);

        $token = new UsernamePasswordToken($user, null, AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);
        $token->setAttribute('tenantSrn', 'srn:dev:iam:na:1144464366:tenant');

        $this->provider->expects($this->once())
            ->method('loadUserByFieldAndProvider')
            ->with('test-user-id', Providers::LOCAL)
            ->willReturn($user);

        $this->session->expects($this->never())->method('remove');
        $this->session->expects($this->once())->method('get')->willReturn([$token]);

        $this->assertEquals($token, $this->service->retrieve());
    }
}
