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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Listener\Success;

use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LocalConfigAdapter;
use Sugarcrm\IdentityProvider\App\Listener\Success\UserPasswordListener;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Symfony\Component\HttpFoundation\Session\Session;

use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Listener\Success\UserPasswordListener
 */
class UserPasswordListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Application | \PHPUnit_Framework_MockObject_MockObject */
    protected $application;

    /** @var Connection | \PHPUnit_Framework_MockObject_MockObject */
    protected $db;

    /** @var Session | \PHPUnit_Framework_MockObject_MockObject */
    protected $session;

    /** @var  AuthenticationEvent | \PHPUnit_Framework_MockObject_MockObject */
    protected $authEvent;

    /** @var  EventDispatcher | \PHPUnit_Framework_MockObject_MockObject */
    protected $dispatcher;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->application = $this->createMock(Application::class);

        $this->db = $this->createMock(Connection::class);
        $this->application->method('getDoctrineService')->willReturn($this->db);

        $this->session = $this->createMock(Session::class);
        $this->application->method('getSession')->willReturn($this->session);

        $this->authEvent = $this->createMock(AuthenticationEvent::class);
        $this->dispatcher = $this->createMock(EventDispatcher::class);
    }

    public function providerTestInvokeWrongCriteria()
    {
        return [
            [$this->createMock(TokenInterface::class), []],
            [new UsernamePasswordToken('', '', AuthProviderManagerBuilder::PROVIDER_KEY_SAML), []],
            [new UsernamePasswordToken('', '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL), [
                'type' => LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_TIME,
            ]],
        ];
    }

    /**
     * @covers ::__invoke
     * @dataProvider providerTestInvokeWrongCriteria
     *
     * @param TokenInterface $token
     * @param int $type
     */
    public function testInvokeWrongCriteria($token, $type)
    {
        /** @var $listener UserPasswordListener | \PHPUnit_Framework_MockObject_MockObject */
        $listener = $this->getMockBuilder(UserPasswordListener::class)
            ->setMethods(['getConfigValue'])
            ->setConstructorArgs([$this->application])
            ->getMock();
        $listener->expects($this->any())->method('getConfigValue')->willReturn($type);

        $this->authEvent->expects($this->once())->method('getAuthenticationToken')->willReturn($token);

        $this->db->expects($this->never())->method('executeUpdate');
        $listener($this->authEvent, 'success', $this->dispatcher);
    }

    /**
     * @covers ::__invoke
     */
    public function testInvoke()
    {
        $this->application->expects($this->once())
            ->method('getConfig')
            ->willReturn([
                'local' => [
                    'password_expiration' => [
                        'type' => LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_LOGIN,
                    ],
                ],
            ]);

        $user = new User('test-user-id', '', ['id' => 'test-user-id']);
        $token = new UsernamePasswordToken($user, '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);
        $this->authEvent->expects($this->once())->method('getAuthenticationToken')->willReturn($token);

        $this->session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn('srn:dev:iam:na:1144464366:tenant');

        $this->db->expects($this->once())
            ->method('executeUpdate')
            ->with(
                'UPDATE users SET login_attempts = login_attempts + 1 WHERE tenant_id = ? AND id = ?',
                ['1144464366', 'test-user-id']
            );

        $listener = new UserPasswordListener($this->application);
        $listener($this->authEvent, 'success', $this->dispatcher);
        $this->assertEquals(1, $user->getAttribute('login_attempts'));
    }
}
