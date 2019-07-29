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

namespace Sugarcrm\IdentityProvider\IntegrationTests\Bootstrap\Pages;

class LoginPage extends AbstractPage
{
    /**
     * @var string $path
     */
    protected $path = '/';
    protected $usernameLocator = "input[name='username']";
    protected $passwordLocator = "input[name='password']";
    protected $loginLinkLocator = "a[name='login_button']";
    protected $userActionsCss = "li#userActions";

    /*
     * Login wizard
     */
    protected $wizardEmailCss = "div.welcome input[name='email']";
    protected $wizardNextCss = "div.welcome a[name='next_button']";
    protected $wizardStartSugarCss = "div.welcome a[name='start_sugar_button']";
    protected $warningCloseXpath = "//div[@id='alerts']//strong[text()='Warning']//ancestor::div[@class='alert-wrapper']//button[@data-action='close']";

    /**
     * Login to SugarCRM with provided credentials
     * @param $username
     * @param $password
     */
    public function login($username, $password)
    {
        $this->waitForElement($this->usernameLocator);
        $this->sendKeysByCss($this->usernameLocator, $username);
        $this->sendKeysByCss($this->passwordLocator, $password);
        $this->clickByCss($this->loginLinkLocator);
        $this->waitLoadingDisappear();
        if ($this->doesXpathElementExist($this->warningCloseXpath)) {
            $this->clickByXpath($this->warningCloseXpath);
        }
    }

    /**
     * Is alert with some message appears
     * @param $message
     * @return bool
     */
    public function isAlertAppears($message)
    {
        $alerts = $this->findAll('xpath', "//div[@id='alerts']//*[contains(text(), '" . $message . "')]");
        return count($alerts) > 0;
    }

    /**
     * Complete user configuration if needed
     */
    private function completeUserConfiguration()
    {
        if ($this->doesCssElementExist($this->wizardEmailCss)) {
            $this->sendKeysByCss($this->wizardEmailCss, bin2hex(random_bytes(10)) . "@test.test");
            $this->clickByCss($this->wizardNextCss);
            $this->waitLoadingComplete();
            $this->clickByCss($this->wizardNextCss);
            $this->clickByCss($this->wizardStartSugarCss);
            $this->waitLoadingDisappear();
        }
    }

    /**
     * Is user logged into system
     * @return bool
     * @throws \Behat\Mink\Exception\DriverException
     * @throws \Behat\Mink\Exception\UnsupportedDriverActionException
     */
    public function isLoggedIn()
    {
        $this->waitLoadingComplete();
        return $this->doesCssElementExist($this->userActionsCss);
    }
}
