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

use function mysql_xdevapi\getSession;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LocalConfigAdapter;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\Exception\PasswordExpiredException;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\Srn;

use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserPasswordListener
{

    /**
     * @var Connection
     */
    protected $db;

    /**
     * Local Authentication config for a particular tenant
     * @var array
     */
    protected $app;

    /**
     * Mapping between config value and multiplier.
     * @var array
     */
    protected $expirationTimeTypeMap = [
        'day' => 1,
        'week' => 7,
        'month' => 30,
    ];

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->db = $app->getDoctrineService();
        $this->app = $app;
    }

    /**
     * @param AuthenticationEvent $event
     * @param string $eventName
     * @param EventDispatcherInterface $dispatcher
     * @throws PasswordExpiredException
     */
    public function __invoke(AuthenticationEvent $event, string $eventName, EventDispatcherInterface $dispatcher)
    {
        $token = $event->getAuthenticationToken();
        if (!$token instanceof UsernamePasswordToken
            || $token->getProviderKey() !== AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL) {
            return;
        }

        $expirationType = (int) $this->getConfigValue('type', 0);
        if ($expirationType == LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_LOGIN) {
            /** @var User $user */
            $user = $token->getUser();
            $tenantSrn = Srn\Converter::fromString(
                $this->app->getSession()->get(TenantConfigInitializer::SESSION_KEY)
            );

            $this->db->executeUpdate(
                'UPDATE users SET login_attempts = login_attempts + 1 WHERE tenant_id = ? AND id = ?',
                [$tenantSrn->getTenantId(), $user->getAttribute('id')]
            );
            $user->setAttribute('login_attempts', $user->getAttribute('login_attempts') + 1);
        }
    }

    /**
     * Get value from tenant's Local config for given key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getConfigValue(string $key, $default = null)
    {
        return $this->app->getConfig()['local']['password_expiration'][$key] ?? $default;
    }
}
