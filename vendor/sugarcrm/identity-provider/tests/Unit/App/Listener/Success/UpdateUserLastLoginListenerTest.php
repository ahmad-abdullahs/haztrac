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

use Sugarcrm\IdentityProvider\App\Listener\Success\UpdateUserLastLoginListener;
use Sugarcrm\IdentityProvider\Authentication\User;

use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @coversDefaultClass Sugarcrm\IdentityProvider\App\Listener\Success\UpdateUserLastLoginListener
 */
class UpdateUserLastLoginListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $dbConnection = $this->createMock(Connection::class);
        $event = $this->createMock(AuthenticationEvent::class);
        $token = $this->createMock(UsernamePasswordToken::class);
        $dispatcher = $this->createMock(EventDispatcher::class);
        $user = new User('max', 'max', ['id' => 'max-id']);

        $token->method('getUser')->willReturn($user);
        $event->method('getAuthenticationToken')->willReturn($token);

        $dbConnection->expects($this->once())
            ->method('executeUpdate')
            ->with(
                'UPDATE users SET last_login = ? WHERE id = ?',
                $this->callback(function ($params) {
                    $this->assertCount(2, $params);
                    $this->assertRegExp('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $params[0]);
                    $this->assertEquals('max-id', $params[1]);
                    return true;
                })
            );

        $listener = new UpdateUserLastLoginListener($dbConnection);
        $listener($event, 'success', $dispatcher);
    }
}
