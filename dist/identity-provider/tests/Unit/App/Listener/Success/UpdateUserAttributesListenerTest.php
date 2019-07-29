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

use Sugarcrm\IdentityProvider\App\Listener\Success\UpdateUserAttributesListener;
use Sugarcrm\IdentityProvider\App\Listener\Success\UpdateUserLastLoginListener;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;
use Sugarcrm\IdentityProvider\Authentication\User;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Listener\Success\UpdateUserAttributesListener
 */
class UpdateUserAttributesListenerTest extends \PHPUnit_Framework_TestCase
{
    private $eventName = 'security.authentication.success';

    /**
     * @var AuthenticationEvent | |PHPUnit_Framework_MockObject_MockObject
     */
    private $event;

    /**
     * @var EventDispatcher||PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    /**
     * @var UpdateUserLastLoginListener||PHPUnit_Framework_MockObject_MockObject
     */
    private $listener;

    /**
     * @var UsernamePasswordToken||PHPUnit_Framework_MockObject_MockObject
     */
    private $token;

    /**
     * @var User||PHPUnit_Framework_MockObject_MockObject
     */
    private $user;

    /**
     * @var User||PHPUnit_Framework_MockObject_MockObject
     */
    private $localUser;

    /**
     * @var LocalUserProvider||PHPUnit_Framework_MockObject_MockObject
     */
    private $localUserProvider;

    /**
     *
     * @return array
     */
    public function updateAttributesDataProvider(): array
    {
        return [
            'updatedAttribute' => [
                'localAttr'       => ['last' => 'name'],
                'localCustomAttr' => ['first' => 'name'],
                'attr'            => ['last' => 'updated'],
                'expects'         => ['first' => 'name', 'last' => 'updated']
            ],
            'addedAttribute' => [
                'localAttr'       => ['last' => 'name'],
                'localCustomAttr' => ['first' => 'name'],
                'attr'            => ['last' => 'name', 'added' => 'value'],
                'expects'         => ['first' => 'name', 'last' => 'name', 'added' => 'value']
            ],
        ];
    }

    /**
     * @dataProvider updateAttributesDataProvider
     * @covers ::__invoke
     * @param array $localAttr
     * @param array $localCustomAttr
     * @param array $attr
     * @param array $expects
     */
    public function testUpdateAttributes(array $localAttr, array $localCustomAttr, array $attr, array $expects): void
    {
        $userId = 'some-user-id';
        $this->event
            ->method('getAuthenticationToken')
            ->willReturn($this->token);
        $this->token
            ->method('getProviderKey')
            ->willReturn(AuthProviderManagerBuilder::PROVIDER_KEY_SAML);
        $this->token
            ->method('getUser')
            ->willReturn($this->user);

        $this->localUser
            ->method('getAttribute')
            ->will($this->returnValueMap([
                ['attributes', $localAttr],
                ['custom_attributes', $localCustomAttr],
                ['id', $userId],
            ]));
        $this->user
            ->method('getAttribute')
            ->will($this->returnValueMap([
                ['attributes', $attr],
            ]));

        $this->localUserProvider
            ->expects($this->once())
            ->method('updateUserAttributes')
            ->with(
                $this->equalTo($expects),
                $this->equalTo($userId)
            );

        \call_user_func($this->listener, $this->event, $this->eventName, $this->dispatcher);
    }

    /**
     * @covers ::__invoke
     */
    public function testSkipUpdateOnLocalProvider(): void
    {
        $this->event
            ->method('getAuthenticationToken')
            ->willReturn($this->token);
        $this->token
            ->method('getProviderKey')
            ->willReturn(AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);

        $this->localUserProvider
            ->expects($this->never())
            ->method('updateUserAttributes');

        \call_user_func($this->listener, $this->event, $this->eventName, $this->dispatcher);
    }

    /**
     * @covers ::__invoke
     */
    public function testSkipUpdateOnSameData(): void
    {
        $userId = 'some-user-id';
        $this->event
            ->method('getAuthenticationToken')
            ->willReturn($this->token);
        $this->token
            ->method('getProviderKey')
            ->willReturn(AuthProviderManagerBuilder::PROVIDER_KEY_SAML);
        $this->token
            ->method('getUser')
            ->willReturn($this->user);

        $this->localUser
            ->method('getAttribute')
            ->will($this->returnValueMap([
                ['attributes', ['last' => 'name']],
                ['custom_attributes', ['first' => 'name']],
                ['id', $userId],
            ]));
        $this->user
            ->method('getAttribute')
            ->will($this->returnValueMap([
                ['attributes', ['last' => 'name']],
            ]));

        $this->localUserProvider
            ->expects($this->never())
            ->method('updateUserAttributes');

        \call_user_func($this->listener, $this->event, $this->eventName, $this->dispatcher);
    }

    /**
     * @covers ::__invoke
     */
    public function testSkipUpdateIfInvalidUser(): void
    {
        $this->event
            ->method('getAuthenticationToken')
            ->willReturn($this->token);
        $this->token
            ->method('getProviderKey')
            ->willReturn(AuthProviderManagerBuilder::PROVIDER_KEY_SAML);
        $this->token
            ->method('getUser')
            ->willReturn(new \StdClass());

        $this->localUserProvider
            ->expects($this->never())
            ->method('updateUserAttributes');

        \call_user_func($this->listener, $this->event, $this->eventName, $this->dispatcher);
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dispatcher = $this->createMock(EventDispatcher::class);
        $this->event = $this->createMock(AuthenticationEvent::class);
        $this->listener = $this->getMockBuilder(UpdateUserAttributesListener::class)
            ->disableOriginalConstructor()
            ->setMethods(['getLocalUserProvider'])
            ->getMock();
        $this->localUserProvider = $this->createMock(LocalUserProvider::class);
        $this->listener
            ->method('getLocalUserProvider')
            ->willReturn($this->localUserProvider);

        $this->token = $this->createMock(UsernamePasswordToken::class);
        $this->user = $this->createMock(User::class);
        $this->localUser = $this->createMock(User::class);
        $this->user
            ->method('getLocalUser')
            ->willReturn($this->localUser);
    }
}
