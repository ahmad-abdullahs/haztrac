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

namespace Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap;

use Behat\Behat\Context\Context;
use Ubirak\RestApiBehatExtension\Json\JsonInspector;
use Ubirak\RestApiBehatExtension\Rest\RestApiBrowser;

class MangoIDMRestFeatureContext implements Context
{
    /**
     * @var array
     */
    protected $sugarAdmin;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var RestApiBrowser
     */
    protected $restApiBrowser;

    /**
     * @var JsonInspector
     */
    protected $jsonInspector;

    /**
     * @param array $sugarAdmin
     * @param RestApiBrowser $restApiBrowser
     * @param JsonInspector $jsonInspector
     */
    public function __construct(array $sugarAdmin, RestApiBrowser $restApiBrowser, JsonInspector $jsonInspector)
    {
        $this->sugarAdmin = $sugarAdmin;
        $this->restApiBrowser = $restApiBrowser;
        $this->jsonInspector = $jsonInspector;
    }

    /**
     * Gets admin's access token through REST as a legacy client
     *
     * @Given I get access_token for admin
     */
    public function iGetAccessTokenForUserWithPassword(): void
    {
        $this->restApiBrowser->addRequestHeader('Content-Type', 'application/json');
        $this->restApiBrowser->sendRequest(
            'POST',
            '/rest/v10/oauth2/token',
            json_encode([
                'grant_type' => 'password',
                'username' => $this->sugarAdmin['username'],
                'password' => $this->sugarAdmin['password'],
                'client_id' => 'sugar',
                'client_secret' => '',
                'platform' => 'base',
            ])
        );
        $this->jsonInspector->writeJson($this->restApiBrowser->getResponse()->getBody());
        $this->accessToken = $this->jsonInspector->readJsonNodeValue('access_token');
    }

    /**
     * @Then I add access_token to header
     */
    public function iAddAccessTokenToHeader()
    {
        $this->restApiBrowser->addRequestHeader('Authorization', 'Bearer ' . $this->accessToken);
    }

    /**
     * @Then I enable IDM mode
     * @And I enable IDM mode
     */
    public function iEnableIDMMode()
    {
        $sugar_config = [];
        require_once __DIR__ . '/../../../k8s/pipeline/mango/config/config-oidc.php';

        $this->restApiBrowser->addRequestHeader('Content-Type', 'application/json');
        $this->restApiBrowser->sendRequest('POST', '/rest/v11_2/Administration/settings/idmMode', json_encode([
            'idmMode' => $sugar_config['idm_mode'],
        ]));
    }
}
