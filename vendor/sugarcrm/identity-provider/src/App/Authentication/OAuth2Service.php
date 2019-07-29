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

namespace Sugarcrm\IdentityProvider\App\Authentication;

use GuzzleHttp\Exception\RequestException;

use League\OAuth2\Client\Tool\QueryBuilderTrait;
use Sugarcrm\IdentityProvider\Authentication\User;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\HttpFoundation\Response;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentTokenInterface;
use Sugarcrm\IdentityProvider\App\Authentication\OpenId\StandardClaimsService;
use Sugarcrm\IdentityProvider\STS\EndpointService;
use Sugarcrm\IdentityProvider\League\OAuth2\Client\Provider\HttpBasicAuth\GenericProvider as OAuth2Provider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class OAuth2Service
{
    use QueryBuilderTrait;

    /**
     * @var EndpointService
     */
    protected $stsEndpoint;

    /**
     * @var OAuth2Provider
     */
    protected $oAuth2Provider;

    /**
     * @var StandardClaimsService
     */
    protected $claimsService;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * OAuth2Service constructor.
     * @param EndpointService $stsEndpoint
     * @param OAuth2Provider $oAuth2Provider
     * @param StandardClaimsService $claimsService
     */
    public function __construct(
        EndpointService $stsEndpoint,
        OAuth2Provider $oAuth2Provider,
        StandardClaimsService $claimsService
    ) {
        $this->claimsService = $claimsService;
        $this->stsEndpoint = $stsEndpoint;
        $this->oAuth2Provider = $oAuth2Provider;
    }

    /**
     * Get oauth2 public or private key from specified endpoint.
     *
     * @param $keyEndpoint
     * @param null $keyType
     * @return mixed
     * @throws RequestException
     * @throws \UnexpectedValueException
     */
    public function getKey($keyEndpoint, $keyType = null)
    {
        if (!$this->accessToken) {
            $this->accessToken = $this->oAuth2Provider->getAccessToken(
                'client_credentials',
                ['scope' => 'hydra']
            );
        }
        $keyRequest = $this->oAuth2Provider->getAuthenticatedRequest(
            OAuth2Provider::METHOD_GET,
            $this->stsEndpoint->getKeysEndpoint(
                $keyEndpoint,
                $keyType
            ),
            $this->accessToken
        );

        $keyResponse = $this->oAuth2Provider->getParsedResponse($keyRequest);

        if (!isset($keyResponse['keys'])) {
            throw new \UnexpectedValueException('Keys not found');
        }

        return is_null($keyType) ? $keyResponse['keys'] : $keyResponse['keys'][0];
    }

    /**
     * Token introspection on OIDC server.
     *
     * @param string $token
     * @return array
     * @throws AuthenticationException
     */
    public function introspectToken($token): array
    {
        $request = $this->oAuth2Provider->getAuthenticatedRequest(
            OAuth2Provider::METHOD_POST,
            $this->stsEndpoint->getOAuth2Endpoint(EndpointService::INTROSPECT_ENDPOINT),
            $this->getAccessToken(),
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json',
                ],
                'body' => $this->buildQueryString(['token' => $token]),
            ]
        );

        try {
            $result = $this->oAuth2Provider->getParsedResponse($request);
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            $this->refreshAccessToken();
            throw new AuthenticationException(
                sprintf('Introspect token is invalid, reason: %s, refreshing. Please try again', $e->getMessage())
            );
        }

        if (empty($result) || empty($result['active'])) {
            throw new AuthenticationException('OIDC Token is not valid');
        }

        return $result;
    }

    /**
     * request consent request data from OP
     * @param $requestId
     * @return mixed
     */
    public function getConsentRequestData($requestId)
    {
        if (!$this->accessToken) {
            $this->accessToken = $this->oAuth2Provider->getAccessToken(
                'client_credentials',
                ['scope' => 'hydra.consent']
            );
        }
        $request = $this->oAuth2Provider->getAuthenticatedRequest(
            OAuth2Provider::METHOD_GET,
            $this->stsEndpoint->getConsentDataRequestEndpoint($requestId),
            $this->accessToken
        );
        return $this->oAuth2Provider->getParsedResponse($request);
    }

    /**
     * accept consent request
     * @param ConsentTokenInterface $token
     * @param AbstractToken $userToken
     */
    public function acceptConsentRequest(ConsentTokenInterface $token, AbstractToken $userToken)
    {
        if (!$this->accessToken) {
            $this->accessToken = $this->oAuth2Provider->getAccessToken(
                'client_credentials',
                ['scope' => 'hydra.consent']
            );
        }
        /** @var User $user */
        $user = $userToken->getUser();

        $claims = $this->claimsService->getUserClaims($user);
        $claims['tid'] = $token->getTenantSRN();

        $body = [
            'grantScopes' => $token->getScopes(),
            'subject' => $userToken->getAttribute('srn'),
            'idTokenExtra' => $claims,
            'accessTokenExtra' => $claims,
        ];
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'body' => json_encode($body),
        ];
        $request = $this->oAuth2Provider->getAuthenticatedRequest(
            Request::METHOD_PATCH,
            $this->stsEndpoint->getConsentAcceptRequestEndpoint($token->getRequestId()),
            $this->accessToken,
            $options
        );
        $response = $this->oAuth2Provider->getResponse($request);
        if ($response->getStatusCode() != Response::HTTP_NO_CONTENT) {
            throw new \RuntimeException('Wrong consent accept response status code');
        }
    }

    /**
     * reject consent request
     * @param string $requestId
     * @param string $reason
     */
    public function rejectConsentRequest($requestId, $reason)
    {
        if (!$this->accessToken) {
            $this->accessToken = $this->oAuth2Provider->getAccessToken(
                'client_credentials',
                ['scope' => 'hydra.consent']
            );
        }
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'body' => json_encode(['reason' => $reason]),
        ];
        $request = $this->oAuth2Provider->getAuthenticatedRequest(
            Request::METHOD_PATCH,
            $this->stsEndpoint->getConsentRejectRequestEndpoint($requestId),
            $this->accessToken,
            $options
        );
        $response = $this->oAuth2Provider->getResponse($request);
        if ($response->getStatusCode() != Response::HTTP_NO_CONTENT) {
            throw new \RuntimeException('Wrong consent reject response status code');
        }
    }

    /**
     * Return access token
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        if (!$this->accessToken) {
            $this->accessToken = $this->oAuth2Provider->getAccessToken(
                'client_credentials',
                [
                    'scope' => implode(
                        ' ',
                        [
                            'hydra.keys.get',
                            'hydra.consent',
                            'hydra.introspect',
                            'https://apis.sugarcrm.com/auth/iam',
                        ]
                    ),
                ]
            );
        }
        return (string)$this->accessToken;
    }

    /**
     * Call token inject refresh token endpoint
     * @return bool
     */
    public function refreshAccessToken()
    {
        return $this->oAuth2Provider->refreshAccessToken();
    }
}
