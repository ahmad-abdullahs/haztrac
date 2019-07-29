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

use Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap\Pages\AdministrationPage;
use Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap\Pages\ContactsPage;
use Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap\Pages\IDMLoginPage;
use Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap\Pages\PortalPage;
use Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap\Pages\TopMenuPage;
use PHPUnit\Framework\Assert;

class IDMContext extends FeatureContext
{
    /**
     * Log into SugarCRM as administrator
     * @Given /^I logged in SugarCRM as administrator$/
     */
    public function iLoggedInSugarCRMAsAdministrator()
    {
        $loginPage = $this->getPage(IDMLoginPage::class);
        $loginPage->open();
        $loginPage->login('1', 'admin', 'admin');
        $this->iSkipLoginWizard();
    }

    /**
     * Create contact and enable portal access
     * @When /^I create contact (.*) with password (.*) and grant access to portal$/
     */
    public function iCreateContactAndGrantAccessToPortal($user, $password)
    {
        $topMenuPage = $this->getPage(TopMenuPage::class);
        $topMenuPage->goToContacts();
        $contactsPage = $this->getPage(ContactsPage::class);
        $contactsPage->createContact($user, $password, ['portal' => true]);
    }

    /**
     * Make sure that user on portal page
     * @Given /^I am on portal login page$/
     */
    public function iAmOnPortalPage()
    {
        $portalPage = $this->getPage(PortalPage::class);
        $portalPage->open();
    }

    /**
     * Login to portal with provided credentials
     * @Given /^I login to portal as (.*) with password (.*)$/
     */
    public function iLoginToPortalAs($username, $password)
    {
        $portalPage = $this->getPage(PortalPage::class);
        $portalPage->login($username, $password);
    }

    /**
     * Verify that user successfully logged in to portal
     * @Then /^I should logged in portal$/
     */
    public function iShouldLoggedInPortal()
    {
        $portalPage = $this->getPage(PortalPage::class);
        $portalPage->waitLoadingComplete();
        Assert::assertTrue($portalPage->isPortalPage());
    }

    /**
     * Create contact with disabled portal access
     * @When /^I create contact (.*) with password (.*) and deny access to portal$/
     */
    public function iCreateContactAndDenyAccessToPortal($username, $password)
    {
        $topMenuPage = $this->getPage(TopMenuPage::class);
        $contactsPage = $this->getPage(ContactsPage::class);
        $topMenuPage->goToContacts();
        $contactsPage->createContact($username, $password, ['portal' => false]);
    }

    /**
     * Verify that message with provided text appears on page
     * @Then /^I should see message "([^"]*)"$/
     */
    public function iShouldSeeMessage($message)
    {
        $portalPage = $this->getPage(PortalPage::class);
        Assert::assertTrue($portalPage->isAlertAppears($message));
    }

    /**
     * Log out from portal
     * @Given /^I logout portal$/
     */
    public function iLogoutPortal()
    {
        $portalPage = $this->getPage(PortalPage::class);
        $portalPage->logout();
    }

    /**
     * Delete created during test contact
     * @AfterScenario @portal
     * @param $event
     */
    public function deleteCreatedContacts($event)
    {
        $contactName = $event->getScenario()->getTokens()['username'];
        $this->iLoggedInSugarCRMAsAdministrator();
        $topMenuPage = $this->getPage(TopMenuPage::class);
        $topMenuPage->goToContacts();
        $contactsPage = $this->getPage(ContactsPage::class);
        $contactsPage->removeContact($contactName);
        $topMenuPage->logout();
    }

    /**
     * Make sure that portal is enabled in SugarCRM
     * @Given /^I check that portal is enabled$/
     */
    public function iCheckThatPortalEnabled()
    {
        $topMenuPage = $this->getPage(TopMenuPage::class);
        $topMenuPage->goToAdministration();
        $adminPage = $this->getPage(AdministrationPage::class);
        $adminPage->checkPortalEnabled();
    }
}
