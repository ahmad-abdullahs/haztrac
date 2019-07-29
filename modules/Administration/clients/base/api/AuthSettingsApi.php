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

use RobRichards\XMLSecLibs\XMLSecurityKey;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication;

class AuthSettingsApi extends SugarApi
{
    /**
     * @var \Administration
     */
    private $ldapSettings;

    /**
     * @var Authentication\Config
     */
    private $authConfig;

    /**
     * @var array
     */
    private $administrationSettings;

    /**
     * Register endpoints
     * @return array
     */
    public function registerApiRest()
    {
        return [
            'authSettings' => [
                'reqType' => ['GET'],
                'path' => ['Administration', 'settings', 'auth'],
                'pathVars' => [''],
                'method' => 'authSettings',
                'shortHelp' => 'Fetch auth settings',
                'longHelp' => 'include/api/help/administration_idm_auth_settings.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                ],
                'minVersion' => '11.2',
            ],
            'switchOnIdmMode' => [
                'reqType' => ['POST'],
                'path' => ['Administration', 'settings', 'idmMode'],
                'pathVars' => [''],
                'method' => 'switchOnIdmMode',
                'shortHelp' => 'Turns IDM mode on',
                'longHelp' => 'include/api/help/administration_settings_post_idm_mode_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                    'SugarApiExceptionMissingParameter',
                ],
                'minVersion' => '11.2',
            ],
            'switchOffIdmMode' => [
                'reqType' => ['DELETE'],
                'path' => ['Administration', 'settings', 'idmMode'],
                'pathVars' => [''],
                'method' => 'switchOffIdmMode',
                'shortHelp' => 'Turns IDM mode off',
                'longHelp' => 'include/api/help/administration_settings_delete_idm_mode_help.html',
                'exceptions' => [
                    'SugarApiExceptionNotAuthorized',
                ],
                'minVersion' => '11.2',
            ],
        ];
    }

    /**
     * Fetch auth settings
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionNotAuthorized
     */
    public function authSettings(ServiceBase $api, array $args) :array
    {
        $this->ensureMigrationEnabled();
        $this->ensureAdminUser();
        $settings = [
            'enabledProviders' => ['local'],
            'local' => $this->getLocalSettings(),
        ];

        if (!empty($this->getAuthConfig()->getLdapConfig())) {
            $settings['enabledProviders'][] = 'ldap';
            $settings['ldap'] = $this->getLdapConfig();
        }
        if ('IdMSAMLAuthenticate' == $this->getAuthConfig()->get('authenticationClass', 'IdMSugarAuthenticate')) {
            $settings['enabledProviders'][] = 'saml';
            $settings['saml'] = $this->getSAMLConfig();
        }

        return $settings;
    }

    /**
     * Turns IDM-mode on
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     * @throws SugarApiExceptionMissingParameter
     */
    public function switchOnIdmMode(ServiceBase $api, array $args) : array
    {
        $this->ensureMigrationEnabled();
        $this->ensureAdminUser();
        if (empty($args['idmMode']) || empty($args['idmMode']['enabled'])) {
            throw new SugarApiExceptionMissingParameter('IDM mode config is not provided');
        }
        $this->getAuthConfig()->setIDMMode($args['idmMode']);
        return $this->getAuthConfig()->getIDMModeConfig();
    }

    /**
     * Turns IDM-mode off
     *
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function switchOffIdmMode(ServiceBase $api, array $args) : array
    {
        $this->ensureMigrationEnabled();
        $this->ensureAdminUser();
        $this->getAuthConfig()->setIDMMode(false);
        return $this->getAuthConfig()->getIDMModeConfig();
    }

    /**
     * Configuration of LDAP auth provider
     * @return array
     */
    private function getLdapConfig(): array
    {
        $config = $this->getAuthConfig()->getLdapConfig();
        return [
            'config' => [
                'auto_create_users' => (bool)$config['autoCreateUser'],
                'server' => (string)$this->getLdapServer($config),
                'user_dn' => (string)$config['baseDn'],
                'user_filter' => (string)$config['filter'],
                'login_attribute' => (string)$config['uidKey'],
                'bind_attribute' => (string)$config['entryAttribute'],

                'authentication' => (bool)(($config['searchDn'] ?? '') . ($config['searchPassword'] ?? '')),
                'authentication_user_dn' => (string)($config['searchDn'] ?? ''),
                'authentication_password' => (string)($config['searchPassword'] ?? ''),

                'group_membership' => (bool)($config['groupMembership'] ?? false),
                'group_dn' => (string)$this->getLdapSetting('ldap_group_dn', ''),
                'group_name' => (string)$this->getLdapSetting('ldap_group_name', ''),
                'group_attribute' => (string)($config['groupAttribute'] ?? ''),
                'user_unique_attribute' => (string)($config['userUniqueAttribute'] ?? ''),
                'include_user_dn' => (bool)($config['includeUserDN'] ?? false),
            ],
            'attribute_mapping' => $this->reformatAttributeMapping($config['user']['mapping']),
        ];
    }

    /**
     * @param array $config
     * @return string
     */
    private function getLdapServer(array $config): string
    {
        $server = "{$config['adapter_config']['host']}:{$config['adapter_config']['port']}";
        if ('ssl' === $config['adapter_config']['encryption']) {
            return "ldaps://{$server}";
        } else {
            return $server;
        }
    }

    /**
     * return settings value from mango ldap settings
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function getLdapSetting(string $key, $default = null)
    {
        if (!$this->ldapSettings) {
            $this->ldapSettings = \Administration::getSettings('ldap');
        }
        if (isset($this->ldapSettings->settings[$key])) {
            return trim(htmlspecialchars_decode($this->ldapSettings->settings[$key])) ?: $default;
        }

        return $default;
    }

    /**
     * Configuration of SAML auth provider
     * @return array
     */
    private function getSAMLConfig(): array
    {
        $config = $this->getAuthConfig()->getSAMLConfig();
        $mapping  = new Authentication\User\Mapping\SugarSAMLUserMapping($config);
        $signatureAlgorithmMap = [
            XMLSecurityKey::RSA_SHA256 => 'RSA_SHA256',
            XMLSecurityKey::RSA_SHA512 => 'RSA_SHA512',
        ];
        return [
            'config' => [
                'sp_entity_id' => (string)$config['sp']['entityId'],
                'request_signing_cert' => (string)$config['sp']['x509cert'],
                'request_signing_pkey' => (string)$config['sp']['privateKey'],
                'provision_user' => (bool)$config['sp']['provisionUser'],
                'same_window' => (bool)$this->getAuthConfig()->get('SAML_SAME_WINDOW', false),
                'idp_entity_id' => (string)$config['idp']['entityId'],
                'idp_sso_url' => (string)$config['idp']['singleSignOnService']['url'],
                'idp_slo_url' => (string)$config['idp']['singleLogoutService']['url'],
                'x509_cert' => (string)$config['idp']['x509cert'],
                'sign_authn_request' => (bool)$config['security']['authnRequestsSigned'],
                'sign_logout_request' => (bool)$config['security']['logoutRequestSigned'],
                'sign_logout_response' => (bool)$config['security']['logoutResponseSigned'],
                'request_signing_method' => $signatureAlgorithmMap[$config['security']['signatureAlgorithm']],
                'validate_request_id' => (bool)$config['security']['validateRequestId'],
                'user_identity_field' => $mapping->getIdentityField(),
            ],
            'attribute_mapping' => $this->reformatAttributeMapping((array) ($config['user_mapping'] ?? [])),
        ];
    }

    /**
     * Reformat Attribute Mapping
     * @param array $in
     * @return array
     */
    private function reformatAttributeMapping(array $in): array
    {
        $out = [];
        foreach ($in as $source => $destination) {
            $out[] = [
                'source' => (string)$source,
                'destination' => (string)$destination,
                'overwrite' => true,
            ];
        }
        return $out;
    }

    /**
     * Configuration of local auth provider
     * @return array
     */
    private function getLocalSettings() : array
    {
        $passConfig = $this->getAuthConfig()->get('passwordsetting', []);
        $lockout = $this->getLockout();
        return [
            'password_requirements' => [
                'minimum_length' => intval($passConfig['minpwdlength']),
                'maximum_length' => intval($passConfig['maxpwdlength']),
                'require_upper' => boolval($passConfig['oneupper']),
                'require_lower' => boolval($passConfig['onelower']),
                'require_number' => boolval($passConfig['onenumber']),
                'require_special' => boolval($passConfig['onespecial']),
            ],
            'password_expiration' => $this->getPasswordExpiration($passConfig),
            'login_lockout' => [
                'type' => $lockout->getLockType(),
                'attempt' => (int)$lockout->getFailedLoginsCount(),
                'time' => $lockout->getLockoutDurationMins() * 60,
            ],
        ];
    }

    /**
     * Format password expiration
     * @param array $passConfig
     * @return array formatted representation
     */
    private function getPasswordExpiration(array $passConfig):array
    {
        $expectedModes = [
            0 => 'disabled',
            1 => 'time',
            2 => 'upon_logins',
        ];
        $mode = $expectedModes[intval($passConfig['userexpiration'])];
        switch ($mode) {
            case 'time':
                return [
                    'time' =>
                        intval($passConfig['userexpirationtime']) *
                        intval($passConfig['userexpirationtype']) * 3600 * 24,
                    'attempt' => 0,
                ];
            case 'upon_logins':
                return [
                    'time' => 0,
                    'attempt' => intval($passConfig['userexpirationlogin']),
                ];
            default:
            case 'disabled':
                return [
                    'time' => 0,
                    'attempt' => 0,
                ];
        }
    }

    /**
     * Returns Authentication Lockout
     *
     * @return Authentication\Lockout
     */
    protected function getLockout(): Authentication\Lockout
    {
        return new Authentication\Lockout();
    }

    /**
     * Returns Authentication Config
     *
     * @return Authentication\Config
     */
    protected function getAuthConfig() : Authentication\Config
    {
        if (is_null($this->authConfig)) {
            $this->authConfig = new Authentication\Config(SugarConfig::getInstance());
        }
        return $this->authConfig;
    }

    /**
     * Ensure current user has admin permissions
     * @throws SugarApiExceptionNotAuthorized
     */
    private function ensureAdminUser() :void
    {
        if (empty($GLOBALS['current_user']) || !$GLOBALS['current_user']->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized(
                $GLOBALS['app_strings']['EXCEPTION_NOT_AUTHORIZED']
            );
        }
    }

    /**
     * @throws SugarApiExceptionNotFound
     */
    private function ensureMigrationEnabled(): void
    {
        if (empty($GLOBALS['sugar_config']['idmMigration'])) {
            throw new SugarApiExceptionNotFound();
        }
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    protected function get(string $key, $default = null)
    {
        if (is_null($this->administrationSettings)) {
            $administration = new Administration();
            $administration->retrieveSettings();
            $this->administrationSettings = $administration->settings;
        }

        if (array_key_exists($key, $this->administrationSettings)) {
            return $this->administrationSettings[$key];
        } else {
            return $default;
        }
    }
}
