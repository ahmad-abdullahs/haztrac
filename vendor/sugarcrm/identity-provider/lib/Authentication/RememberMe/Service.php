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

namespace Sugarcrm\IdentityProvider\Authentication\RememberMe;

use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Srn;
use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;
use Sugarcrm\IdentityProvider\Authentication\Provider\Providers;

use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class Service
{
    /**
     * @var SessionInterface
     */
    protected $storage;

    /**
     * @var Connection
     */
    protected $db;

    const STORAGE_KEY = 'loggedInIdentities';

    /**
     * @param SessionInterface $session
     * @param Connection $db
     */
    public function __construct(SessionInterface $session, Connection $db)
    {
        $this->storage = $session;
        $this->db = $db;
    }

    /**
     * Stores the token
     *
     * @param TokenInterface $token
     */
    public function store(TokenInterface $token): void
    {
        $this->storage->set(self::STORAGE_KEY, [$token]);
    }

    /**
     * Retrieves remembered token if any
     *
     * @return TokenInterface|null
     */
    public function retrieve(): ?TokenInterface
    {
        $token = $this->storage->get(self::STORAGE_KEY)[0] ?? null;
        if ($token && $this->isLocalUserActive($token)) {
            return $token;
        }
        return null;
    }

    /**
     * Clear remembered tokens
     */
    public function clear(): void
    {
        $this->storage->remove(self::STORAGE_KEY);
    }

    /**
     * Check if stored user is active and exists
     * @param TokenInterface $token
     * @return bool
     */
    protected function isLocalUserActive(TokenInterface $token): bool
    {
        if (!$token instanceof UsernamePasswordToken
            || $token->getProviderKey() != AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL) {
            return true;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return true;
        }

        if (!$token->hasAttribute('tenantSrn')) {
            return true;
        }

        $tenantSrn = Srn\Converter::fromString($token->getAttribute('tenantSrn'));
        $localProvider = $this->getLocalUserProvider($tenantSrn->getTenantId());
        try {
            $localProvider->loadUserByFieldAndProvider($user->getUsername(), Providers::LOCAL);
        } catch (UsernameNotFoundException $e) {
            $this->clear();
            return false;
        }

        return true;
    }

    /**
     * @param $tenantId
     * @return LocalUserProvider
     */
    protected function getLocalUserProvider($tenantId): LocalUserProvider
    {
        return new LocalUserProvider($this->db, $tenantId);
    }
}
