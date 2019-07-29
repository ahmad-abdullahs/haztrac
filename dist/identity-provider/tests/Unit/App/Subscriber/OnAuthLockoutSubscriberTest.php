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

use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\App\Subscriber\OnAuthLockoutSubscriber;
use Sugarcrm\IdentityProvider\App\Authentication\Lockout;
use Sugarcrm\IdentityProvider\Authentication\Exception\PermanentLockedUserException;
use Sugarcrm\IdentityProvider\Authentication\Exception\TemporaryLockedUserException;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\ResultToken;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;

use Psr\Log\LoggerInterface;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @coversDefaultClass Sugarcrm\IdentityProvider\App\Subscriber\OnAuthLockoutSubscriber
 */
class OnAuthLockoutSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /** @var Application */
    protected $application;

    /** @var Connection */
    protected $dbConnection;

    /** @var  AuthenticationEvent */
    protected $authEvent;

    /** @var  AuthenticationEvent | \PHPUnit_Framework_MockObject_MockObject */
    private $authFailureEvent;

    /** @var  UsernamePasswordToken */
    protected $token;

    /** @var  EventDispatcher */
    protected $dispatcher;

    /** @var  User */
    protected $user;

    /** @var  Lockout */
    protected $lockout;

    /** @var LocalUserProvider */
    protected $userProvider;

    /** @var  LoggerInterface */
    protected $logger;

    /** @var  OnAuthLockoutSubscriber */
    protected $subscriber;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->application = $this->createMock(Application::class);
        $this->dbConnection = $this->createMock(Connection::class);
        $this->authEvent = $this->createMock(AuthenticationEvent::class);
        $this->authFailureEvent = $this->createMock(AuthenticationFailureEvent::class);

        $this->token = $this->createMock(UsernamePasswordToken::class);
        $this->token->expects($this->any())
            ->method('getProviderKey')
            ->willReturn(AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);

        $this->dispatcher = $this->createMock(EventDispatcher::class);
        $this->lockout = $this->createMock(Lockout::class);
        $this->userProvider = $this->createMock(LocalUserProvider::class);
        $this->session = $this->createMock(Session::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->user = $this->createMock(User::class);

        $this->application->method('getDoctrineService')->willReturn($this->dbConnection);
        $this->authEvent->method('getAuthenticationToken')->willReturn($this->token);
        $this->authFailureEvent->method('getAuthenticationToken')->willReturn($this->token);
        $this->token->method('getUser')->willReturn($this->user);

        $this->subscriber = $this->getMockBuilder(OnAuthLockoutSubscriber::class)
            ->setMethods(['getLocalUserProvider'])
            ->setConstructorArgs([
                $this->lockout,
                $this->dbConnection,
                $this->session,
                $this->logger
            ])
            ->getMock();
        $this->subscriber->method('getLocalUserProvider')->willReturn($this->userProvider);
    }

    /**
     * @covers ::onSuccess
     */
    public function testOnSuccessTokenIsNotSupported()
    {
        $this->lockout->method('isEnabled')->willReturn(true);
        $token = $this->createMock(ResultToken::class);
        $token->expects($this->never())->method('getUser');

        $authEvent = $this->createMock(AuthenticationEvent::class);
        $authEvent->expects($this->once())
            ->method('getAuthenticationToken')
            ->willReturn($token);
        $this->subscriber->onSuccess($authEvent);
    }

    /**
     * @covers ::onSuccess
     */
    public function testOnSuccessDoesNothingIfLockoutDisabled()
    {
        $this->lockout->method('isEnabled')->willReturn(false);
        $this->dbConnection->expects($this->never())->method('executeUpdate');
        $this->subscriber->onSuccess($this->authEvent);
    }

    /**
     * @covers ::onSuccess
     */
    public function testOnSuccessDoesNothingIfUserLockoutDisabledAndNoLoggedOutDate()
    {
        $this->lockout->method('isEnabled')->willReturn(true);
        $this->user
            ->method('getAttribute')
            ->will(
                $this->returnValueMap(
                    [
                        ['failed_login_attempts', null],
                        ['id', 'max-id'],
                        ['is_locked_out', false],
                    ]
                )
            );

        $this->dbConnection->expects($this->never())->method('executeUpdate');

        $this->subscriber->onSuccess($this->authEvent);
    }

    /**
     * @covers ::onSuccess
     */
    public function testOnSuccessUpdatesUserLockout()
    {
        $this->lockout->method('isEnabled')->willReturn(true);
        $this->user
            ->method('getAttribute')
            ->will(
                $this->returnValueMap(
                    [
                        ['failed_login_attempts', 1],
                        ['id', 'max-id'],
                        ['is_locked_out', true],
                    ]
                )
            );

        $this->dbConnection
            ->expects($this->once())
            ->method('executeUpdate')
            ->with('UPDATE users SET is_locked_out = false, failed_login_attempts = 0 WHERE id = ?', ['max-id']);

        $this->subscriber->onSuccess($this->authEvent);
    }

    /**
     * @covers ::onFailure
     */
    public function testOnFailureTokenIsNotSupported()
    {
        $token = $this->createMock(ResultToken::class);
        $token->expects($this->never())->method('getUsername');

        $authEvent = $this->createMock(AuthenticationFailureEvent::class);
        $authEvent->expects($this->once())
            ->method('getAuthenticationToken')
            ->willReturn($token);

        $this->subscriber->onFailure($authEvent);
    }

    /**
     * @covers ::onFailure
     */
    public function testOnFailureDoesNothingIfNoUser()
    {
        $this->lockout->method('isEnabled')->willReturn(true);

        $this->dbConnection->expects($this->never())->method('executeUpdate');
        $this->logger->expects($this->once())->method('info');

        $this->subscriber->onFailure($this->authFailureEvent);
    }

    /**
     * @covers ::onFailure
     */
    public function testOnFailureUpdatesFailedLoginCounter()
    {
        $this->userProvider->method('loadUserByUsername')->willReturn($this->user);
        $this->lockout->method('isEnabled')->willReturn(false);
        $this->user
            ->method('getAttribute')
            ->will(
                $this->returnValueMap(
                    [
                        ['failed_login_attempts', 15],
                        ['id', 'max-id'],
                    ]
                )
            );

        $this->dbConnection
            ->expects($this->at(0))
            ->method('executeUpdate')
            ->with(
                'UPDATE users SET is_locked_out = false, failed_login_attempts = failed_login_attempts + 1 ' .
                'WHERE id = ?',
                ['max-id']
            );
        $this->logger->expects($this->once())->method('info');

        $this->subscriber->onFailure($this->authFailureEvent);
    }

    /**
     * @covers ::onFailure
     */
    public function testOnFailureLocksUserIfAttemptsExceeded()
    {
        $this->userProvider->method('loadUserByUsername')->willReturn($this->user);
        $this->lockout->method('isEnabled')->willReturn(true);
        $this->lockout->method('getAllowedFailedLoginCount')->willReturn(9);
        $this->user
            ->method('getAttribute')
            ->will(
                $this->returnValueMap(
                    [
                        ['failed_login_attempts', 15],
                        ['id', 'max-id'],
                    ]
                )
            );

        $this->dbConnection
            ->expects($this->at(1))
            ->method('executeUpdate')
            ->with(
                'UPDATE users SET is_locked_out = true, failed_login_attempts = 0, lockout_time = ? WHERE id = ?',
                $this->callback(function ($params) {
                    $this->assertCount(2, $params);
                    $this->assertRegExp('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $params[0]);
                    $this->assertEquals('max-id', $params[1]);
                    return true;
                })
            );

        $this->subscriber->onFailure($this->authFailureEvent);
    }

    /**
     * @covers ::onFailure
     */
    public function testOnFailureDoesNotLockUserIfAttemptsNotExceeded()
    {
        $this->userProvider->method('loadUserByUsername')->willReturn($this->user);
        $this->lockout->method('isEnabled')->willReturn(true);
        $this->lockout->method('getAllowedFailedLoginCount')->willReturn(42);
        $this->user
            ->method('getAttribute')
            ->will(
                $this->returnValueMap(
                    [
                        ['failed_login_attempts', 15],
                        ['id', 'max-id'],
                    ]
                )
            );

        $this->dbConnection->expects($this->once())->method('executeUpdate');

        $this->subscriber->onFailure($this->authFailureEvent);
    }

    /**
     * @see testNotExecuteOnLockoutFailures
     * @return array
     */
    public function lockoutFailures(): array
    {
        return [
            'permanent' => [
                'exception' => new PermanentLockedUserException(),
            ],
            'time' => [
                'exception' => new TemporaryLockedUserException(),
            ],
        ];
    }

    /**
     * @covers ::onFailure
     * @dataProvider lockoutFailures
     * @param \Exception $exception
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testNotExecuteOnLockoutFailures(\Exception $exception): void
    {
        $this->authFailureEvent->method('getAuthenticationException')->willReturn($exception);

        $this->authFailureEvent->expects($this->never())->method('getAuthenticationToken');
        $this->token->expects($this->never())->method('getUsername');
        $this->userProvider->expects($this->never())->method('loadUserByUsername');

        $this->subscriber->onFailure($this->authFailureEvent);
    }
}
