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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication;

use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LocalConfigAdapter;
use Sugarcrm\IdentityProvider\App\Authentication\Lockout;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\Authentication\User;
use Symfony\Component\Translation\Translator;

/**
 * @coversDefaultClass Sugarcrm\IdentityProvider\App\Authentication\Lockout
 */
class LockoutTest extends \PHPUnit_Framework_TestCase
{
    /** @var Application */
    protected $application;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->translator = new Translator('en');

        $this->application = $this->createMock(Application::class);
        $this->application->method('getTranslator')->willReturn($this->translator);
    }

    public function providerGetAllowedFailedLoginCount()
    {
        return [
            ['1', 1],
            [1, 1],
            ['60', 60],
            [null, 0],
        ];
    }

    /**
     * @covers ::getAllowedFailedLoginCount
     * @dataProvider providerGetAllowedFailedLoginCount
     *
     * @param mixed $value
     * @param int $expected
     */
    public function testGetAllowedFailedLoginCount($value, $expected)
    {
        $this->application
            ->method('getConfig')
            ->willReturn([
                'local' => [
                    'login_lockout' => ['attempt' => $value],
                ],
            ]);

        $lockout = new Lockout($this->application);
        $this->assertEquals($expected, $lockout->getAllowedFailedLoginCount());
    }

    public function providerIsEnabled()
    {
        return [
            [LocalConfigAdapter::LOCKOUT_DISABLED, false],
            [LocalConfigAdapter::LOCK_TYPE_PERMANENT, true],
            [LocalConfigAdapter::LOCK_TYPE_TIME, true],
            [9999999, true],
        ];
    }

    /**
     * @covers ::isEnabled
     * @dataProvider providerIsEnabled
     *
     * @param int $value
     * @param int $expected
     */
    public function testIsEnabled($value, $expected)
    {
        $this->application
            ->method('getConfig')
            ->willReturn(['local' => ['login_lockout' => ['type' => $value]]]);

        $lockout = new Lockout($this->application);
        $this->assertEquals($expected, $lockout->isEnabled());
    }

    /**
     * @covers ::throwLockoutException
     *
     * @expectedException \Sugarcrm\IdentityProvider\Authentication\Exception\TemporaryLockedUserException
     * @expectedExceptionMessage Too many failed login attempts.
     */
    public function testThrowLockoutExceptionThrowsTemporaryLocked()
    {
        $this->application
            ->method('getConfig')
            ->willReturn(['local' => ['login_lockout' => ['type' => LocalConfigAdapter::LOCK_TYPE_TIME]]]);

        $lockout = new Lockout($this->application);
        $lockout->throwLockoutException(new User('max'));
    }

    /**
     * @covers ::throwLockoutException
     *
     * @expectedException \Sugarcrm\IdentityProvider\Authentication\Exception\TemporaryLockedUserException
     * @expectedExceptionMessage Too many failed login attempts. You can try logging in again in 8 hours
     */
    public function testThrowLockoutExceptionThrowsTemporaryLockedWithDetailedMessage()
    {
        $user = new User('max', 'max', ['lockout_time' => (new \DateTime())->format('Y-m-d H:i:s')]);
        $this->application
            ->method('getConfig')
            ->willReturn(
                [
                    'local' => [
                        'login_lockout' => [
                            'type' => LocalConfigAdapter::LOCK_TYPE_TIME,
                            'time' => 3600 * 8,
                        ],
                    ],
                ]
            );

        $lockout = new Lockout($this->application);
        $lockout->throwLockoutException($user);
    }

    public function providerGetTimeLockedExceptionMessage()
    {
        return [
            [86400, 'Too many failed login attempts. You can try logging in again in 1 days'],
            [86401, 'Too many failed login attempts. You can try logging in again in 1 days 1 seconds'],
            [86402, 'Too many failed login attempts. You can try logging in again in 1 days 2 seconds'],
            [1, 'Too many failed login attempts. You can try logging in again in 1 seconds'],
            [60, 'Too many failed login attempts. You can try logging in again in 1 minutes'],
            [61, 'Too many failed login attempts. You can try logging in again in 1 minutes 1 seconds'],
            [124, 'Too many failed login attempts. You can try logging in again in 2 minutes 4 seconds'],
            [196473, 'Too many failed login attempts. You can try logging in again in ' .
                '2 days 6 hours 34 minutes 33 seconds'],
            [1654, 'Too many failed login attempts. You can try logging in again in 27 minutes 34 seconds'],
            [11654, 'Too many failed login attempts. You can try logging in again in 3 hours 14 minutes 14 seconds'],
        ];
    }

    /**
     * @covers ::throwLockoutException
     * @dataProvider providerGetTimeLockedExceptionMessage
     *
     * @param int $timeLeft
     * @param string $message
     */
    public function testGetTimeLockedExceptionMessage($timeLeft, $message)
    {
        $lockout = $this->getMockBuilder(Lockout::class)
            ->setConstructorArgs([$this->application])
            ->setMethods(['calculateTimeLeft', 'calculateExpireTime', 'getLockType'])
            ->getMock();

        $lockout->method('getLockType')->willReturn(LocalConfigAdapter::LOCK_TYPE_TIME);
        $lockout->method('calculateExpireTime')->willReturn(new \DateTime());
        $lockout->method('calculateTimeLeft')->willReturn($timeLeft);

        $this->expectException('\Sugarcrm\IdentityProvider\Authentication\Exception\TemporaryLockedUserException');
        $this->expectExceptionMessageRegExp("/^$message$/");

        $lockout->throwLockoutException(new User('max', 'max'));
    }

    /**
     * @covers ::throwLockoutException
     *
     * @expectedException \Sugarcrm\IdentityProvider\Authentication\Exception\PermanentLockedUserException
     * @expectedExceptionMessage Too many failed login attempts.
     */
    public function testThrowLockoutExceptionThrowsPermanentLocked()
    {
        $this->application
            ->method('getConfig')
            ->willReturn(['local' => ['login_lockout' => ['type' => LocalConfigAdapter::LOCK_TYPE_PERMANENT]]]);

        $lockout = new Lockout($this->application);
        $lockout->throwLockoutException(new User('max'));
    }

    public function providerIsUserLocked()
    {
        return [
            [LocalConfigAdapter::LOCK_TYPE_PERMANENT, 0, true, true],
            [LocalConfigAdapter::LOCK_TYPE_PERMANENT, 0, false, false],
            [LocalConfigAdapter::LOCKOUT_DISABLED, 0, true, false],
            [LocalConfigAdapter::LOCKOUT_DISABLED, 0, '0', false],
            [99999, 0, true, false],
            [LocalConfigAdapter::LOCK_TYPE_TIME, 1 * 3600, false, false],
            [LocalConfigAdapter::LOCK_TYPE_TIME, 3 * 3600, false, true],
        ];
    }

    /**
     * @covers ::isUserLocked
     * @dataProvider providerIsUserLocked
     *
     * @param int $lockoutType
     * @param int $expirationTime
     * @param bool $userLockout
     * @param bool $expected
     */
    public function testIsUserLocked($lockoutType, $expirationTime, $userLockout, $expected)
    {
        $user = new User('max', 'max', [
            'lockout_time' => (new \DateTime())->modify('-2 hours')->format('Y-m-d H:i:s'),
            'is_locked_out' => $userLockout,
        ]);

        $this->application
            ->method('getConfig')
            ->willReturn(
                [
                    'local' => [
                        'login_lockout' => [
                            'type' => $lockoutType,
                            'time' => $expirationTime,
                        ],
                    ],
                ]
            );

        $lockout = new Lockout($this->application);
        $this->assertEquals($expected, $lockout->isUserLocked($user));
    }
}
