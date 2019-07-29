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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\User;

use Doctrine\DBAL\Connection;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LocalConfigAdapter;
use Sugarcrm\IdentityProvider\App\User\PasswordChecker;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Sugarcrm\IdentityProvider\Authentication\User;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\User\PasswordChecker
 */
class PasswordCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Connection
     */
    protected $db;

    protected function setUp()
    {
        $this->db = $this->createMock(Connection::class);
    }

    public function providerTestIsPasswordExpiredWrongCriteria()
    {
        return [
            [$this->createMock(TokenInterface::class), []],
            [new UsernamePasswordToken('', '', AuthProviderManagerBuilder::PROVIDER_KEY_SAML), []],
            [new UsernamePasswordToken('', '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL), ['type' => 0]],
        ];
    }

    /**
     * @covers ::isPasswordExpired
     * @dataProvider providerTestIsPasswordExpiredWrongCriteria
     * @param $token
     * @param $config
     */
    public function testIsPasswordExpiredWrongCriteria($token, $config)
    {
        $config = [
            'local' => [
                'password_expiration' => $config,
            ],
        ];
        $checker = new PasswordChecker($this->db, $config);
        $this->assertFalse($checker->isPasswordExpired($token));
    }

    /**
     * @covers ::isPasswordExpired
     */
    public function testIsPasswordExpiredByTimePasswordLastChangeTimeFromDb()
    {
        $config = [
            'local' => [
                'password_expiration' => [
                    'type' => LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_TIME,
                    'time' => 60,
                ],
            ],
        ];
        $user = new User('test-user-id', '', [
            'id' => 'test-user-id',
            'password_last_changed' => (new \DateTime())->modify('-65 seconds')->format('Y-m-d H:i:s'),
        ]);
        $token = new UsernamePasswordToken($user, '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);
        $token->setAttribute('tenantSrn', 'srn:dev:iam:na:1144464366:tenant');

        $checker = new PasswordChecker($this->db, $config);
        $this->assertTrue($checker->isPasswordExpired($token));
    }

    /**
     * @covers ::isPasswordExpired
     */
    public function testIsPasswordExpiredByTimeNoPasswordLastChangeTime()
    {
        $config = [
            'local' => [
                'password_expiration' => [
                    'type' => LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_TIME,
                    'time' => 36000,
                ],
            ],
        ];
        $user = new User('test-user-id', '', [
            'id' => 'test-user-id',
        ]);
        $token = new UsernamePasswordToken($user, '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);
        $token->setAttribute('tenantSrn', 'srn:dev:iam:na:1144464366:tenant');

        $this->db->expects($this->once())
            ->method('update')
            ->with('users', $this->isType('array'), ['tenant_id' => '1144464366', 'id' => 'test-user-id']);

        $checker = new PasswordChecker($this->db, $config);
        $this->assertFalse($checker->isPasswordExpired($token));
    }

    /**
     * @covers ::isPasswordExpired
     */
    public function testIsPasswordExpiredByLoginAttempts()
    {
        $config = [
            'local' => [
                'password_expiration' => [
                    'type' => LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_LOGIN,
                    'attempt' => 100,
                ],
            ],
        ];
        $user = new User('test-user-id', '', [
            'id' => 'test-user-id',
            'login_attempts' => 100,
        ]);
        $token = new UsernamePasswordToken($user, '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);
        $checker = new PasswordChecker($this->db, $config);
        $this->assertTrue($checker->isPasswordExpired($token));
    }
}
