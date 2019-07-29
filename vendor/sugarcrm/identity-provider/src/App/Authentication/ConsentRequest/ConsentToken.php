<?php

namespace Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest;

use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;

class ConsentToken implements ConsentTokenInterface
{
    /**
     * @var string
     */
    protected $tenantSrn;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * array of client scope
     * @var array
     */
    protected $scope = [];

    /**
     * consent request id
     * @var string
     */
    protected $requestId;

    /**
     * consent redirect url
     * @var  string
     */
    protected $redirectUrl;

    /**
     * User name(optional)
     * @var string
     */
    protected $username;

    /**
     * @inheritDoc
     */
    public function getTenantSRN()
    {
        return $this->tenantSrn;
    }

    /**
     * set tenant srn
     * @param string $tenantSrn
     */
    public function setTenantSRN($tenantSrn)
    {
        $this->tenantSrn = $tenantSrn;
    }

    /**
     * @inheritDoc
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scope;
    }

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * fill fields by oauth2 consent data
     * @param array $data
     * @return ConsentToken
     */
    public function fillByConsentRequestData(array $data)
    {
        $this->requestId = $data['id'];
        $this->scope = $data['requestedScopes'];
        $this->clientId = $data['clientId'];
        $this->redirectUrl = $data['redirectUrl'];

        $queryParams = [];
        parse_str(parse_url($this->redirectUrl, PHP_URL_QUERY), $queryParams);

        if (!empty($queryParams[TenantConfigInitializer::REQUEST_KEY])) {
            $this->tenantSrn = $queryParams[TenantConfigInitializer::REQUEST_KEY];
        }

        if (!empty($queryParams['login_hint'])) {
            $this->username = $queryParams['login_hint'];
        }

        return $this;
    }
}
