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

namespace Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Token\OIDC;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Class CodeToken
 * Provides token that can perform auth_code OIDC operation
 */
class CodeToken extends AbstractToken
{
    /**
     * @var string
     */
    protected $credentials;

    /**
     * OAuth scope
     * @var string
     */
    protected $scope;

    /**
     * OIDCToken constructor.
     * @param string $credentials OAuth2 token.
     * @param string $scope Tenant SRN
     * @param array $roles
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $credentials, string $scope, array $roles = [])
    {
        parent::__construct($roles);

        $this->scope = $scope;
        $this->credentials = $credentials;
    }

    /**
     * @inheritdoc
     */
    public function getCredentials(): string
    {
        return $this->credentials;
    }

    /**
     * Get scope.
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }
}
