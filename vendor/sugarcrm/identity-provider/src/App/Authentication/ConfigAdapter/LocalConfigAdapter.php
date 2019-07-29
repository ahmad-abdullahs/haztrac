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

namespace Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter;

class LocalConfigAdapter extends AbstractConfigAdapter
{
    public const LOCKOUT_DISABLED = 0;
    public const LOCK_TYPE_TIME = 2;
    public const LOCK_TYPE_PERMANENT = 1;

    public const PASSWORD_EXPIRATION_DISABLED = 0;
    public const PASSWORD_EXPIRATION_TYPE_TIME = 1;
    public const PASSWORD_EXPIRATION_TYPE_LOGIN = 2;

    /**
     * modify IPD-API config to Local auth usage
     * @param $config
     * @return array
     */
    public function getConfig(string $config): array
    {
        $config = $this->decode($config);
        if (empty($config)) {
            return [];
        }

        $config = array_replace_recursive($this->getDefaultConfig(), $config);
        return [
            'password_requirements' => [
                'minimum_length' => (int)$config['password_requirements']['minimum_length'],
                'maximum_length' => (int)$config['password_requirements']['maximum_length'],
                'require_upper' => (bool)$config['password_requirements']['require_upper'],
                'require_lower' => (bool)$config['password_requirements']['require_lower'],
                'require_number' => (bool)$config['password_requirements']['require_number'],
                'require_special' => (bool)$config['password_requirements']['require_special'],
            ],
            'password_expiration' => [
                'type' => $this->getPasswordExpirationType($config['password_expiration']),
                'time' => (int)$config['password_expiration']['time']['seconds'],
                'attempt' => (int)$config['password_expiration']['attempt'],
            ],
            'login_lockout' => [
                'type' => (int)$config['login_lockout']['type'],
                'attempt' => (int)$config['login_lockout']['attempt'],
                'time' => (int)$config['login_lockout']['time']['seconds'],
            ],
        ];
    }

    /**
     * Get default values for the config
     *
     * @return array
     */
    private function getDefaultConfig(): array
    {
        return [
            'password_requirements' => [
                'minimum_length' => 0,
                'maximum_length' => 0,
                'require_upper' => false,
                'require_lower' => false,
                'require_number' => false,
                'require_special' => false,
            ],
            'password_expiration' => [
                'time' => ['seconds' => 0],
                'attempt' => 0,
            ],
            'login_lockout' => [
                'type' => 0,
                'attempt' => 0,
                'time' => ['seconds' => 0],
            ],
        ];
    }

    /**
     * @param array $config
     * @return int
     */
    private function getPasswordExpirationType(array $config): int
    {
        if (!empty($config['time']['seconds']) && empty($config['attempt'])) {
            return self::PASSWORD_EXPIRATION_TYPE_TIME;
        } elseif (empty($config['time']['seconds']) && !empty($config['attempt'])) {
            return self::PASSWORD_EXPIRATION_TYPE_LOGIN;
        } else {
            return self::PASSWORD_EXPIRATION_DISABLED;
        }
    }
}
