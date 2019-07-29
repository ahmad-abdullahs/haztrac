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

namespace Sugarcrm\IdentityProvider\Tests\Unit\Authentication\User;

use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\App\Authentication\Lockout;
use Sugarcrm\IdentityProvider\Authentication\User\LocalUserChecker;
use Sugarcrm\IdentityProvider\Authentication\Exception\PermanentLockedUserException;

/**
 * Class LocalUserCheckerTest.
 * @coversDefaultClass \Sugarcrm\IdentityProvider\Authentication\User\LocalUserChecker
 */
class LocalUserCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Lockout
     */
    protected $lockout;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->createMock(User::class);
        $this->lockout = $this->createMock(Lockout::class);

        $this->user->method('isAccountNonLocked')->willReturn(true);
        $this->user->method('isEnabled')->willReturn(true);
        $this->user->method('isAccountNonExpired')->willReturn(true);
    }

    /**
     * @covers ::checkPreAuth
     *
     * @expectedException \Sugarcrm\IdentityProvider\Authentication\Exception\PermanentLockedUserException
     */
    public function testExceptionIsThrown()
    {
        $this->lockout->method('isEnabled')->willReturn(true);
        $this->lockout->method('isUserLocked')->willReturn(true);
        $this->lockout->method('throwLockoutException')->willThrowException(new PermanentLockedUserException());

        $checker = new LocalUserChecker($this->lockout);
        $checker->checkPreAuth($this->user);
    }

    /**
     * @covers ::checkPreAuth
     */
    public function testExceptionIsNotThrown()
    {
        $this->lockout
            ->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);
        $this->lockout
            ->expects($this->once())
            ->method('isUserLocked')
            ->with($this->user)
            ->willReturn(false);
        $this->lockout->method('throwLockoutException')->willThrowException(new PermanentLockedUserException());

        $checker = new LocalUserChecker($this->lockout);
        $checker->checkPreAuth($this->user);
    }
}
