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

use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Config;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Token\UsernamePasswordTokenFactory;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\AuthProviderBasicManagerBuilder;
use Sugarcrm\Sugarcrm\IdentityProvider\OAuth2StateRegistry;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\OAuth2\Client\Provider\IdmProvider;
use Sugarcrm\Sugarcrm\Util\Uuid;
use Sugarcrm\Sugarcrm\Security\InputValidation\InputValidation;

/**
 * Class OAuth2Authenticate
 */

class OAuth2Authenticate extends BaseAuthenticate implements ExternalLoginInterface
{
    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    public function getLoginUrl($returnQueryVars = [])
    {
        $config = new Config(\SugarConfig::getInstance());
        $idmModeConfig = $config->getIDMModeConfig();
        if (empty($idmModeConfig['stsUrl'])) {
            throw new \RuntimeException('IDM-mode config and URL were not found.');
        }

        $request = InputValidation::getService();
        $platform = $returnQueryVars['platform'] ?? $request->getValidInputGet('platform', null, 'base');
        $state = $platform . '_' . $this->createState();

        return $this->getIdmProvider($idmModeConfig)->getAuthorizationUrl(
            [
                'scope' => $idmModeConfig['requestedOAuthScopes'],
                'state' => $state,
                'tenant_hint' => $idmModeConfig['tid'],
            ]
        );
    }

    /**
     * Create oauth2 state
     * @return string
     */
    protected function createState() : string
    {
        $state = Uuid::uuid4();
        $this->getStateRegistry()->registerState($state);
        return $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoutUrl(): string
    {
        $config = new Config(\SugarConfig::getInstance());
        $idmModeConfig = $config->getIDMModeConfig();
        return $idmModeConfig['idpUrl'] . '/logout?redirect_uri='.$idmModeConfig['idpUrl'];
    }

    /**
     * @inheritdoc
     */
    public function loginAuthenticate($username, $password, $fallback = false, array $params = [])
    {
        $config = new Config(\SugarConfig::getInstance());
        $token = (new UsernamePasswordTokenFactory($username, $password, ['tenant' => $this->getTenant($config)]))
            ->createIdPAuthenticationToken();
        $manager = $this->getAuthProviderBasicBuilder($config)
            ->buildAuthProviders();
        $resultToken = $manager->authenticate($token);
        if ($resultToken->isAuthenticated()) {
            return [
                'user_id' => $resultToken->getUser()->getSugarUser()->id,
                'scope' => null,
            ];
        }
        return false;
    }

    /**
     * @param Config $config
     *
     * @return string
     */
    protected function getTenant(Config $config)
    {
        $idmModeConfig = $config->get('idm_mode', []);
        return !empty($idmModeConfig['tid']) ? $idmModeConfig['tid'] : '';
    }

    /**
     * @param Config $config
     *
     * @return AuthProviderBasicManagerBuilder
     */
    protected function getAuthProviderBasicBuilder(Config $config)
    {
        return new AuthProviderBasicManagerBuilder($config);
    }

    /**
     * Gets IdmProvider instance
     * @param array $idmModeConfig
     * @return IdmProvider
     */
    protected function getIdmProvider(array $idmModeConfig): IdmProvider
    {
        return new IdmProvider($idmModeConfig);
    }

    /**
     * @return OAuth2StateRegistry
     */
    protected function getStateRegistry() : OAuth2StateRegistry
    {
        return new OAuth2StateRegistry();
    }
}
