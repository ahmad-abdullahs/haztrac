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

class SugarUpgradeUpgradeAuthenticationClass extends UpgradeScript
{
    public $order = 1100;

    public $type = self::UPGRADE_CUSTOM;

    /**
     *
     * @var Configurator
     */
    private $configurator;

    /**
     * Upgrade authentication class map
     * @var array
     */
    private $upgradeMap = [
        'SugarAuthenticate' => 'IdMSugarAuthenticate',
        'LDAPAuthenticate' => 'IdMLDAPAuthenticate',
        'SAMLAuthenticate' => 'IdMSAMLAuthenticate',
    ];

    public function run()
    {
        if (!version_compare($this->from_version, '8.1.0', '<')) {
            return;
        }

        if (!empty($this->upgrader->config['authenticationClass'])) {
            $authenticationClass = $this->upgrader->config['authenticationClass'];
            if (array_key_exists($authenticationClass, $this->upgradeMap)) {
                $configurator = $this->getConfigurator();
                $configurator->config['authenticationClass'] = $this->upgradeMap[$authenticationClass];
                $configurator->handleOverride();
                $configurator->clearCache();
                $this->getConfigInstance()->clearCache();
                if (function_exists('opcache_invalidate')) {
                    opcache_invalidate('modules/Users/authentication/SAMLAuthenticate/SAMLAuthenticate.php', true);
                    opcache_invalidate('modules/Users/authentication/LDAPAuthenticate/LDAPAuthenticate.php', true);
                    opcache_invalidate('modules/Users/authentication/AuthenticationController.php', true);
                    opcache_invalidate('config_override.php', true);
                }

                $this->log(
                    sprintf(
                        'AuthenticationClass upgraded form %s to %s',
                        $authenticationClass,
                        $this->upgradeMap[$authenticationClass]
                    )
                );
            } else {
                $this->error(sprintf('Unexpected authenticationClass:%s', $authenticationClass), true);
            }
        } else {
            $this->log('AuthenticationClass was empty leave as is');
        }
    }

    /**
     * @return Configurator
     */
    protected function getConfigurator():Configurator
    {
        if (is_null($this->configurator)) {
            $this->configurator = new Configurator();
        }
        return $this->configurator;
    }

    /**
     * @return SugarConfig
     */
    protected function getConfigInstance():SugarConfig
    {
        return SugarConfig::getInstance();
    }
}
