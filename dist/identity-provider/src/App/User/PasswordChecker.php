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

namespace Sugarcrm\IdentityProvider\App\User;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LocalConfigAdapter;
use Sugarcrm\IdentityProvider\Authentication\User;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Sugarcrm\IdentityProvider\Srn;

class PasswordChecker
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var array
     */
    protected $config;

    /**
     * PasswordTimeExpireChecker constructor.
     * @param Connection $db
     * @param array $config
     */
    public function __construct(Connection $db, array $config)
    {
        $this->db = $db;
        $this->config = $config['local']['password_expiration'] ?? [];
    }

    /**
     * Is user password time expired?
     *
     * @param TokenInterface $token
     * @return boolean
     */
    public function isPasswordExpired(TokenInterface $token)
    {
        if (!$token instanceof UsernamePasswordToken
            || $token->getProviderKey() !== AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL) {
            return false;
        }

        $type = (int) ($this->config['type'] ?? 0);
        switch ($type) {
            case LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_TIME:
                return $this->checkPasswordTime($token);
            case LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_LOGIN:
                return $this->checkLoginAttempts($token);
            default:
                return false;
        }
    }

    /**
     * Is password expired by time?
     * @param UsernamePasswordToken $token
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function checkPasswordTime(UsernamePasswordToken $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        $tenantSrn = Srn\Converter::fromString($token->getAttribute('tenantSrn'));

        $lastChangeDateFromDB = $user->getAttribute('password_last_changed');
        if ($lastChangeDateFromDB) {
            $lastChangeDate = \DateTime::createFromFormat('Y-m-d H:i:s', $lastChangeDateFromDB);
        } else {
            $lastChangeDate = new \DateTime();
            $this->db->update(
                'users',
                ['password_last_changed' => $lastChangeDate->format('Y-m-d H:i:s')],
                ['tenant_id' => $tenantSrn->getTenantId(), 'id' => $user->getAttribute('id')]
            );
        }

        $timeToExpiration = $this->config['time'] ?? 1;
        if (time() >= $lastChangeDate->modify("+$timeToExpiration seconds")->getTimestamp()) {
            return true;
        }
        return false;
    }

    /**
     * Is password expired by login attempts?
     * @param UsernamePasswordToken $token
     * @return bool
     */
    protected function checkLoginAttempts(UsernamePasswordToken $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        $attempts = (int) $user->getAttribute('login_attempts');
        $allowed = (int) ($this->config['attempt'] ?? 0);
        return $attempts >= $allowed;
    }
}
