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

namespace Sugarcrm\IdentityProvider\Saml2\Builder;

use OneLogin\Saml2\Auth;
use OneLogin\Saml2\LogoutResponse;
use OneLogin\Saml2\Response;
use Sugarcrm\IdentityProvider\Saml2\AuthPostBinding;
use Sugarcrm\IdentityProvider\Saml2\Response\LogoutPostResponse;

/**
 * Provides methods to build suitable response.
 *
 * Class ResponseBuilder
 * @package Sugarcrm\IdentityProvider\Saml2\Builder
 *
 */
class ResponseBuilder
{
    /** @var  Auth*/
    private $auth;

    /**
     * ResponseBuilder constructor.
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Creates SAML logout response object.
     *
     * @param null $responseData
     * @return LogoutResponse|LogoutPostResponse
     * @throws \OneLogin\Saml2\Error
     */
    public function buildLogoutResponse($responseData = null)
    {
        if ($this->auth instanceof AuthPostBinding) {
            return new LogoutPostResponse($this->auth->getSettings(), $responseData);
        }

        return new LogoutResponse($this->auth->getSettings(), $responseData);
    }

    /**
     * Creates SAML response object.
     *
     * @param $responseData
     * @return Response
     * @throws \OneLogin\Saml2\ValidationError
     */
    public function buildLoginResponse($responseData): Response
    {
        return new Response($this->auth->getSettings(), $responseData);
    }
}
