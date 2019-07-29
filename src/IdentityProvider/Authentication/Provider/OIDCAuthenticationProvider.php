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

namespace Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

use Sugarcrm\IdentityProvider\Authentication\UserMapping\MappingInterface;
use Sugarcrm\IdentityProvider\STS\EndpointInterface;
use Sugarcrm\IdentityProvider\Srn\Converter;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Exception\IdmNonrecoverableException;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\OAuth2\Client\Provider\IdmProvider;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\ServiceAccount\Checker;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Token\OIDC\CodeToken;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Token\OIDC\IntrospectToken;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Token\OIDC\JWTBearerToken;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Token\OIDC\RefreshToken;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\User\SugarOIDCUserChecker;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\UserProvider\SugarOIDCUserProvider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @internal
 * Class OIDCAuthenticationProvider
 * Provides all authentication operations on OIDC server.
 */
class OIDCAuthenticationProvider implements AuthenticationProviderInterface
{
    /**
     * @var IdmProvider
     */
    protected $oAuthProvider = null;

    /**
     * @var SugarOIDCUserProvider
     */
    protected $userProvider;

    /**
     * @var SugarOIDCUserChecker
     */
    protected $userChecker;

    /**
     * @var MappingInterface
     */
    protected $userMapping;

    /**
     * @var Sugarcrm\Sugarcrm\IdentityProvider\Authentication\ServiceAccount\Checker
     */
    protected $SAChecker;

    /**
     * List of handlers that can be used to handle tokens.
     * Actually, they correspond to steps of SAML authentication flow.
     *
     * @var array
     */
    protected $handlers = [
        IntrospectToken::class => 'introspectToken',
        JWTBearerToken::class => 'jwtBearerGrantTypeAuth',
        RefreshToken::class => 'refreshTokenGrantTypeAuth',
        CodeToken::class => 'authCodeGrantTypeAuth',
    ];

    /**
     * OIDCAuthenticationProvider constructor.
     * @param AbstractProvider $oAuthProvider
     * @param UserProviderInterface $userProvider
     * @param UserCheckerInterface $userChecker
     * @param MappingInterface $userMapping
     */
    public function __construct(
        AbstractProvider $oAuthProvider,
        UserProviderInterface $userProvider,
        UserCheckerInterface $userChecker,
        MappingInterface $userMapping,
        Checker $SAChecker
    ) {
        $this->oAuthProvider = $oAuthProvider;
        $this->userProvider = $userProvider;
        $this->userChecker = $userChecker;
        $this->userMapping = $userMapping;
        $this->SAChecker = $SAChecker;
    }

    /**
     * @inheritdoc
     */
    public function authenticate(TokenInterface $token)
    {
        $handlerMethod = null;
        foreach ($this->handlers as $tokenClass => $handler) {
            if ($token instanceof $tokenClass) {
                $handlerMethod = $handler;
                break;
            }
        }
        if (!$handlerMethod) {
            throw new AuthenticationServiceException('There is no authentication handler for ' . get_class($token));
        }

        try {
            return $this->{$handlerMethod}($token);
        } catch (AuthenticationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new AuthenticationException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Processes exchange oauth2 code to access token.
     *
     * @param TokenInterface $token
     * @return TokenInterface
     *
     * @throws AuthenticationException
     */
    protected function authCodeGrantTypeAuth(TokenInterface $token): TokenInterface
    {
        try {
            $accessToken = $this->oAuthProvider->getAccessToken(
                'authorization_code',
                ['code' => $token->getCredentials(), 'scope' => explode(' ', $token->getScope())]
            );

            $resultToken = new CodeToken($token->getCredentials(), $token->getScope());
            $this->populateAuthenticatedTokenByAccessToken($accessToken, $resultToken);

            return $resultToken;
        } catch (\Exception $e) {
            throw new AuthenticationException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param TokenInterface $token
     * @return TokenInterface
     *
     * @throws AuthenticationException
     */
    protected function refreshTokenGrantTypeAuth(TokenInterface $token): TokenInterface
    {
        try {
            $accessToken = $this->oAuthProvider->getAccessToken(
                'refresh_token',
                ['refresh_token' => $token->getCredentials()]
            );

            $resultToken = new RefreshToken($accessToken->getRefreshToken());
            $this->populateAuthenticatedTokenByAccessToken($accessToken, $resultToken);

            return $resultToken;
        } catch (\Exception $e) {
            throw new AuthenticationException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Token introspection on OIDC server.
     *
     * @param TokenInterface $token
     * @return IntrospectToken
     */
    protected function introspectToken(TokenInterface $token)
    {
        $accessToken = new AccessToken(['access_token' => $token->getCredentials()]);
        $result = $this->oAuthProvider->introspectToken($accessToken);

        if (empty($result) || empty($result['active'])) {
            throw new AuthenticationException('OIDC Token is not valid');
        }

        if (empty($result['sub'])) {
            throw new AuthenticationException('Empty subject in OIDC token');
        }

        $resultScopes = explode($this->oAuthProvider->getScopeSeparator(), $result['scope'] ?? '');
        if (!in_array($token->getCrmOAuthScope(), $resultScopes)) {
            throw new IdmNonrecoverableException(
                sprintf('Access token should contain %s scope', $token->getCrmOAuthScope())
            );
        }

        $resultToken = new IntrospectToken($token->getCredentials(), $token->getTenant(), $token->getCrmOAuthScope());
        $resultToken->setAttributes($result);
        $resultToken->setAttribute('platform', $token->getAttribute('platform'));

        /** @var User $user */
        $user = $this->userProvider->loadUserBySrn($result['sub']);

        if ($user->isServiceAccount()) {
            if (!$this->SAChecker->isAllowed($result['sub'])) {
                throw new AuthenticationException(
                    sprintf('Service account is not allowed: %s', $result['sub'])
                );
            }
            $resultToken->setUser($user);
            $resultToken->setAuthenticated(true);
            return $resultToken;
        }

        if (isset($result['ext']['tid']) && $token->getTenant() != $result['ext']['tid']) {
            throw new IdmNonrecoverableException(
                sprintf('Access token does not belong to tenant %s', $token->getTenant())
            );
        }

        $userSRN = Converter::fromString($result['sub'] ?? '');
        $tenantSRN = Converter::fromString($token->getTenant());
        if ($userSRN->getTenantId() != $tenantSRN->getTenantId()) {
            throw new IdmNonrecoverableException(
                sprintf('Access token claims should belong to tenant %s', $token->getTenant())
            );
        }

        $userInfo = $this->oAuthProvider->getUserInfo($accessToken);
        $user->setAttribute('oidc_data', $this->userMapping->map($userInfo));
        $user->setAttribute('oidc_identify', $this->userMapping->mapIdentity($result));

        foreach ($result as $key => $value) {
            $user->setAttribute($key, $value);
        }
        try {
            $this->userChecker->checkPostAuth($user);
        } catch (\Exception $e) {
            throw new IdmNonrecoverableException($e->getMessage());
        }

        $resultToken->setUser($user);
        $resultToken->setAuthenticated(true);

        return $resultToken;
    }

    /**
     * Provides JWT Bearer oauth2 flow
     *
     * @param TokenInterface $token
     * @return TokenInterface
     */
    protected function jwtBearerGrantTypeAuth(TokenInterface $token)
    {
        $userSrn = Converter::fromString($token->getIdentity());
        $userResource = $userSrn->getResource();
        $user = $this->userProvider->loadUserByField($userResource[1], 'id');
        $token->setUser($user);

        $keySetInfo = $this->oAuthProvider->getKeySet();
        $privateKey = array_filter($keySetInfo['keys'], function ($value) {
            return $value['kid'] == EndpointInterface::PRIVATE_KEY;
        });

        $token->setAttribute('privateKey', array_shift($privateKey));
        $token->setAttribute('aud', $this->oAuthProvider->getBaseAccessTokenUrl([]));
        $token->setAttribute('iss', $keySetInfo['clientId']);
        $token->setAttribute('kid', $keySetInfo['keySetId']);
        $token->setAttribute('iat', time());

        $accessToken = $this->oAuthProvider->getJwtBearerAccessToken((string)$token);
        $resultToken = clone $token;
        $this->populateAuthenticatedTokenByAccessToken($accessToken, $resultToken);
        return $resultToken;
    }

    /**
     * Populates Authenticated Token by data stored in Access Token
     * @param AccessToken $source
     * @param TokenInterface $destination
     */
    protected function populateAuthenticatedTokenByAccessToken(AccessToken $source, TokenInterface $destination): void
    {
        $extraValues = $source->getValues();
        $destination->setAttribute('token', $source->getToken());
        $destination->setAttribute('exp', $source->getExpires());
        $destination->setAttribute('expires_in', $source->getExpires() - time());
        $destination->setAttribute('token_type', $extraValues['token_type'] ?? 'bearer');
        $destination->setAttribute('scope', $extraValues['scope'] ?? null);
        if ($source->getRefreshToken()) {
            $destination->setAttribute('refresh_token', $source->getRefreshToken());
        }
        $destination->setAuthenticated(true);
    }

    /**
     * @inheritdoc
     */
    public function supports(TokenInterface $token)
    {
        return array_key_exists(get_class($token), $this->handlers);
    }
}
