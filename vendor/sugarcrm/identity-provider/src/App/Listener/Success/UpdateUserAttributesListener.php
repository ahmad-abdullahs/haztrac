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

namespace Sugarcrm\IdentityProvider\App\Listener\Success;

use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Srn\Converter;

use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

class UpdateUserAttributesListener
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var Connection
     */
    private $db;

    /**
     * UpdateUserAttributesListener constructor.
     * @param Connection $db
     * @param SessionInterface $session
     */
    public function __construct(Connection $db, SessionInterface $session)
    {
        $this->db = $db;
        $this->session = $session;
    }

    /**
     * make this class callable
     * @param AuthenticationEvent $event
     * @param string $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function __invoke(AuthenticationEvent $event, string $eventName, EventDispatcherInterface $dispatcher)
    {
        /** @var TokenInterface $token */
        $token = $event->getAuthenticationToken();
        if ($token instanceof UsernamePasswordToken
            && AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL === $token->getProviderKey()) {
            return;
        }
        /** @var User $user */
        $user = $token->getUser();
        if (!$user instanceof User) {
            return;
        }

        $localUser = $user->getLocalUser();
        $localAttr = array_merge(
            (array)$localUser->getAttribute('attributes'),
            (array)$localUser->getAttribute('custom_attributes')
        );
        $oldAttr = array_intersect_key($localAttr, $user->getAttribute('attributes'));
        if (!array_diff($user->getAttribute('attributes'), $oldAttr)) {
            return;
        }

        $this->getLocalUserProvider()->updateUserAttributes(
            array_merge($localAttr, $user->getAttribute('attributes')),
            $user->getLocalUser()->getAttribute('id')
        );
    }

    /**
     * Get LocalUserProvider.
     * We load it lazily to initialize it with tenant-id. Otherwise it'd be better to inject it into constructor.
     *
     * @return LocalUserProvider
     */
    protected function getLocalUserProvider(): LocalUserProvider
    {
        $tenant = $this->session->get(TenantConfigInitializer::SESSION_KEY);
        $tenantId = Converter::fromString($tenant)->getTenantId();
        return new LocalUserProvider($this->db, $tenantId);
    }
}
