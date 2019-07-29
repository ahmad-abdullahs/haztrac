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

namespace Sugarcrm\IdentityProvider\App\Provider;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Listener\Success\UpdateUserLastLoginListener;
use Sugarcrm\IdentityProvider\App\Listener\Success\UpdateUserAttributesListener;
use Sugarcrm\IdentityProvider\App\Listener\Success\UserPasswordListener;
use Sugarcrm\IdentityProvider\App\Subscriber\OnAuthLockoutSubscriber;
use Sugarcrm\IdentityProvider\App\Authentication\Lockout;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;

class ListenerProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        /** @var Application $app */
        /** @var EventDispatcher $dispatcher */
        $app->extend('dispatcher', function (EventDispatcherInterface $dispatcher, $app) {
            $dispatcher->addListener(
                AuthenticationEvents::AUTHENTICATION_SUCCESS,
                new UpdateUserAttributesListener(
                    $app->getDoctrineService(),
                    $app->getSession()
                )
            );
            $dispatcher->addListener(
                AuthenticationEvents::AUTHENTICATION_SUCCESS,
                new UpdateUserLastLoginListener($app->getDoctrineService())
            );
            $dispatcher->addListener(
                AuthenticationEvents::AUTHENTICATION_SUCCESS,
                new UserPasswordListener($app)
            );
            $dispatcher->addSubscriber(
                new OnAuthLockoutSubscriber(
                    new Lockout($app),
                    $app->getDoctrineService(),
                    $app->getSession(),
                    $app->getLogger()
                )
            );

            return $dispatcher;
        });
    }
}
