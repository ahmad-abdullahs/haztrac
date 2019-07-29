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

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Class LoginServiceFeatureContext
 * @package Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap
 */
class LoginServiceFeatureContext extends FeatureContext
{
    /**
     * @var string
     */
    protected $baseUrl;
    /**
     * LoginServiceFeatureContext constructor.
     * @param string $base_url
     * @param string $screenShotPath
     */
    public function __construct(string $base_url, string $screenShotPath)
    {
        $this->baseUrl = $base_url;
        parent::__construct([], $screenShotPath);
    }

    /**
     * @param BeforeScenarioScope $scope
     *
     * @BeforeScenario
     */
    public function switchBaseUrl(BeforeScenarioScope $scope): void
    {
        $this->setMinkParameter('base_url', $this->baseUrl);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $tenant
     *
     * @And /^I login as "([^"]*)" with password "([^"]*)" to tenant "([^"]*)"$/
     * @When /^I login as "([^"]*)" with password "([^"]*)" to tenant "([^"]*)"$/
     */
    public function iLoginToTenant(string $username, string $password, string $tenant): void
    {
        $this->waitForElement('input[name=user_name]');
        $this->fillField('user_name', $username);
        $this->fillField('password', $password);
        $this->fillField('tid', $tenant);
        $this->iClick('#submit_btn');
    }

    /**
     * Provides operation for logout on IdP landing page.
     *
     * @And /^I do logout$/
     * @When /^I do logout$/
     */
    public function iDoLogout(): void
    {
        $this->iClick('#logout_btn');
        $this->waitForThePageToBeLoaded();
    }

    /**
     * @And /^I should see logo with "([^"]*)" = "([^"]*)"$/
     * @Then /^I should see logo with "([^"]*)" = "([^"]*)"$/
     */
    public function iShouldSeeLogoWith($attr, $value)
    {
        $css = sprintf('img[%s="%s"]', $attr, $value);
        $element = $this->getSession()->getPage()->find('css', $css);
        if (is_null($element)) {
            throw new \LogicException('Wrong logo');
        }
    }

    /**
     * @And /^I should see logout cookie$/
     * @Then /^I should see logout cookie$/
     */
    public function iShouldSeeLogoutCookie(): void
    {
        $session = $this->getSession();
        $logoutCookie = (int)$session->getCookie('cloud-log');
        if ($logoutCookie !== 1) {
            throw new \LogicException('Logout cookie not found');
        }
    }

    /**
     * @And /^I should not see logout cookie$/
     * @Then /^I should not see logout cookie$/
     */
    public function iShouldNotSeeLogoutCookie(): void
    {
        $session = $this->getSession();
        $logoutCookie = $session->getCookie('cloud-log');
        if (!empty($logoutCookie)) {
            throw new \LogicException('Logout cookie found but should not');
        }
    }
}
