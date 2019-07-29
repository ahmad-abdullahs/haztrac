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

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\Testwork\Tester\Result\TestResult;
use elkan\BehatFormatter\Context\BehatFormatterContext;
use GuzzleHttp;
use Behat\Gherkin\Node\TableNode;
use Psr\Http\Message\ResponseInterface;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectAware;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory as PageObjectFactory;

/**
 * Defines application features from the specific context.
 */

class FeatureContext extends BehatFormatterContext implements PageObjectAware
{
    /**
     * @var array
     */
    protected $sugarAdmin;

    protected $pageObjectFactory = null;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * SetUp necessary configs.
     *
     * @param array $sugarAdmin
     * @param string $screenShotPath
     */
    public function __construct(array $sugarAdmin, string $screenShotPath = null)
    {
        $this->sugarAdmin = $sugarAdmin;
        parent::__construct($screenShotPath);
    }

    /**
     * Follows to admin page
     *
     * @And I go to administration
     * @When I go to administration
     */
    public function iGoToAdministration()
    {
        $this->waitForThePageToBeLoaded();
        $this->iClick('#userList');
        $this->iClick('.administration');
        $this->iWaitUntilTheLoadingIsCompleted();
        $this->waitForThePageToBeLoaded();
        $this->switchBwc();
    }

    /**
     * Provides user login operation.
     *
     * @param $username
     * @param $password
     *
     * @And /^I login as "([^"]*)" with password "([^"]*)"$/
     * @When /^I login as "([^"]*)" with password "([^"]*)"$/
     */
    public function iLogin($username, $password)
    {
        $this->waitForThePageToBeLoaded();
        $this->iWaitUntilTheLoadingIsCompleted();
        $page = $this->getSession()->getPage();
        $switchForm = $page->find('css', 'a[name=login_form_button]');
        if (!is_null($switchForm)) {
            $this->iClick("a[name=login_form_button]");
        }
        $this->waitForElement('input[name=username]');
        $page->fillField('username', $username);
        $page->fillField('password', $password);
        $page->pressButton('login_button');
        $this->iWaitUntilTheLoadingIsCompleted();
        $this->waitForThePageToBeLoaded();
    }

    /**
     * Provides user logout operation.
     *
     * @Then I logout
     * @And I logout
     */
    public function iLogout()
    {
        $this->waitForThePageToBeLoaded();
        $this->switchSidecar();
        $this->waitForThePageToBeLoaded();
        $this->iClick('#userList');
        $this->waitForElement('.profileactions-logout');
        $this->iClick('.profileactions-logout');
        $this->iWaitUntilTheLoadingIsCompleted();
        $this->waitForThePageToBeLoaded();
    }

    /**
     * Click on element found by css selector.
     * @When /^I click "([^"]*)"$/
     * Example: I click "ul.megamenu li button"
     */
    public function iClick($selector)
    {
        $element = $this->getSession()->getPage()->find('css', $selector);
        if (is_null($element)) {
            throw new \RuntimeException("Not found element by selector($selector)");
        }
        $element->click();
    }

    /**
     * Wait until the loading is completed
     * @When /^I wait until the loading is completed$/
     */
    public function iWaitUntilTheLoadingIsCompleted()
    {
        $condition = '!document.querySelector(".alert-wrapper .alert-process .loading") '
            . '&& !document.querySelector("span[sfuuid]:empty:not([class])");';
        $this->getSession()->wait(20000, $condition);
    }

    /**
     * Before working with BWC Iframe need this command.
     * @When /^I switch to BWC$/
     */
    public function switchBwc()
    {
        $this->spin(function (FeatureContext $context) {
            $context->getSession()->getDriver()->switchToIFrame('bwc-frame');
            $result = boolval($context->getSession()->getPage()->findById('main'));
            if (!$result) {
                $context->switchSidecar();
            }
            return $result;
        }, 60);
    }

    /**
     * Output from bwc.
     * @When /^I switch to sidecar$/
     */
    public function switchSidecar()
    {
        $this->getSession()->getDriver()->switchToIFrame(null);
    }

    /**
     * Wait :milliseconds.
     * @When I wait :milliseconds
     */
    public function wait($milliseconds)
    {
        $this->getSession()->wait($milliseconds);
    }

    /**
     * Wait for the page to be redirected to the specific url
     * @Then /^I should be redirected to "?([^"]*)"?$/
     * @And /^I should be redirected to "?([^"]*)"?$/
     * Example: I should be redirected to "http://localhost:8000"
     *          I should be redirected to saml-server
     */
    public function iShouldBeRedirectedTo($redirectedTo)
    {
        $redirectedTo = $this->getContextSpecificUrl($redirectedTo);
        $this->spin(function (FeatureContext $context) use ($redirectedTo) {
            $diff = $result = array_diff(
                parse_url($redirectedTo),
                parse_url($context->getSession()->getCurrentUrl())
            );
            return empty($diff);
        }, 10);
    }

    /**
     * Wait for the specific query string
     * @param string $query
     * @throws \Exception
     *
     * @Then /^I should see "([^"]*)" in url query$/
     * @And /^/^I should see "([^"]*)" in url query$/
     */
    public function iShouldSeeQueryStringInUrl(string $query)
    {
        $this->spin(function (FeatureContext $context) use ($query) {
            return parse_url($context->getSession()->getCurrentUrl(), PHP_URL_QUERY) === $query;
        }, 10);
    }

    /**
     * Checks valid redirect in new tab
     * @param $url
     * @Then /^The document should open in a new tab with url "?([^"]*)"?$/
     */
    public function documentShouldOpenInNewTab($url)
    {
        $current = $this->getSession()->getWindowName();
        $windows = $this->getSession()->getWindowNames();
        if (count($windows) != 2) {
            throw new \RuntimeException("Only two windows must be opened at one moment.");
        }
        $second = array_filter($windows, function ($window) use ($current) {
            return $window != $current;
        });
        $second = array_pop($second);
        $this->getSession()->switchToWindow($second);
        assertEquals($url, $this->getSession()->getCurrentUrl());
        $this->getSession()->switchToWindow($current);
    }

    /**
     * @param string $url
     * @return string
     */
    protected function getContextSpecificUrl($url)
    {
        return $url;
    }

    /**
     * Wait for the page to be loaded.
     * @And I wait for the page to be loaded
     * @When I wait for the page to be loaded
     */
    public function waitForThePageToBeLoaded()
    {
        $this->getSession()->wait(20000, "document.readyState === 'complete'");
    }

    /**
     * Wait for the ajax to be finished
     * @And I wait for the ajax to be finished
     * @When I wait for the ajax to be finished
     */
    public function waitForAjaxToBeFinished()
    {
        $result = $this->getSession()->wait(5000, '$.active == 0');
        if (!$result) {
            $backtrace = debug_backtrace();

            throw new \Exception(
                "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
                (array_key_exists('file', $backtrace[1]) ? $backtrace[1]['file'] . ", line " . $backtrace[1]['line'] :
                    '')
            );
        }
    }

    /**
     * Checking radiobutton.
     * @When /^I check the "([^"]*)" radio button with "([^"]*)" value$/
     * @And /^I check the "([^"]*)" radio button with "([^"]*)" value$/
     * Example: I check the "radioName" radio button with "radioValue" value
     */
    public function iCheckTheRadioButtonWithValue($element, $value)
    {
        $element = $this->fixStepArgument($element);
        $value = $this->fixStepArgument($value);
        $selector = 'input[type="radio"][name="' . $element . '"]';
        foreach ($this->getSession()->getPage()->findAll('css', $selector) as $radio) {
            if ($radio->getAttribute('value') == $value) {
                $radio->check();
                return true;
            }
        }
        return false;
    }

    /**
     * @Then I skip login wizard
     * @And I skip login wizard
     */
    public function iSkipLoginWizard()
    {
        $this->iWaitUntilTheLoadingIsCompleted();

        $loginWizardElement = $this->getSession()->getPage()->waitFor(
            5,
            function () {
                return $this->getSession()->getPage()->findField('first_name');
            }
        );

        if (!$loginWizardElement) {
            return;
        }

        $accessToken = $this->getAccessToken();
        if ($accessToken) {
            $client = new GuzzleHttp\Client();
            $response = $client->get(
                $this->getMinkParameter('base_url') . '/rest/v11/me/preferences',
                ['headers' => ['OAuth-Token' => $accessToken]]
            );

            $userPreferences = json_decode($response->getBody(true));
            $wizard = !(isset($userPreferences->ut) && $userPreferences->ut);
            if ($wizard) {
                $this->updateUserPreferences($accessToken, ["ut" => 1]);
                $this->getSession()->reload();
                sleep(5);
                $this->waitForThePageToBeLoaded();
                $this->iWaitUntilTheLoadingIsCompleted();
                $this->waitForElement('#userList');
            }
        }
    }

    /**
     * Updates user preferences
     *
     * @When I update user preferences with this data:
     */
    public function iUpdateUserPreferences(TableNode $data)
    {
        $accessToken = $this->getAccessToken();
        if ($accessToken) {
            $preferences = [];
            foreach ($data as $row) {
                $preferences[$row['field']] = $row['value'];
            }
            if ($preferences) {
                $this->updateUserPreferences($accessToken, $preferences);
            }
        }
    }

    /**
     * @And I get access_token from local storage
     * @Then I get access_token from local storage
     */
    public function iGetAccessTokenFromLocalStorage()
    {
        $this->accessToken = $this->getAccessToken();
        assertNotEmpty($this->accessToken, "Assertion failed - accessToken is empty");
    }

    /**
     * Gets access token through REST
     * @param string $username
     * @param string $password
     *
     * @And /^I get access_token for "([^"]*)" with password "([^"]*)"$/
     * @Then /^I get access_token for "([^"]*)" with password "([^"]*)"$/
     *
     * @throws \RuntimeException
     */
    public function iGetAccessTokenForUserWithPassword(string $username, string $password): void
    {
        $client = new GuzzleHttp\Client();
        $url = rtrim($this->getMinkParameter('base_url'), '/') . '/rest/v11/oauth2/token';
        try {
            $formParams = [
                'client_id' => 'sugar',
                'client_info' => ['current_language' => 'en_us'],
                'client_secret' => '',
                'current_language' => 'en_us',
                'grant_type' => 'password',
                'password' => $password,
                'platform' => 'base',
                'username' => $username,
            ];
            $response = $client->post($url, ['form_params' => $formParams]);
            $body = $response->getBody();
            $result = json_decode((string)$body, true);
            $this->accessToken = $result['access_token'];
        } catch (\Exception $exception) {
            throw new \RuntimeException('Can not login as ' . $username . ' using password: ' . $password);
        }
    }

    /**
     * Updates user preferences
     *
     * @param string $accessToken
     * @param array $preferences
     */
    protected function updateUserPreferences($accessToken, array $preferences)
    {
        $client = new GuzzleHttp\Client();
        $client->put(
            $this->getMinkParameter('base_url') . '/rest/v11/me/preferences',
            [
                'headers' => ['OAuth-Token' => $accessToken],
                'body' => json_encode($preferences),
            ]
        );
    }

    /**
     * Creates Sugar user with a specified set of bean properties.
     *
     * @Then /^As "([^"]*)" I create Sugar user with the following properties:$/
     * @And /^As "([^"]*)" I create Sugar user with the following properties:$/
     */
    public function iCreateUser($adminKey, TableNode $table)
    {
        $credentials = $this->$adminKey;
        if (empty($credentials)) {
            throw new \RuntimeException('Configuration for ' . $adminKey . ' not found');
        }

        $this->iLogin($credentials['username'], $credentials['password']);
        $this->iSkipLoginWizard();

        $body = [];
        foreach ($table as $row) {
            $body[$row['field']] = $row['value'];
        }

        $accessToken = $this->getAccessToken();
        $usersUrl = rtrim($this->getMinkParameter('base_url'), '/') . '/rest/v11/Users';
        $client = new GuzzleHttp\Client();
        /** @var ResponseInterface $response */
        $response = $client->post(
            $usersUrl,
            [
                'headers' => ['OAuth-Token' => $accessToken],
                'body' => json_encode($body),
            ]
        );
        $body = $response->getBody();
        $list = json_decode((string)$body, true);

        $this->iLogout();

        return $list['id'];
    }

    /**
     * Get access token from localStorage
     *
     * @return string
     */
    public function getAccessToken()
    {
        $accessToken = '';
        try {
            $accessToken = $this->getLocalStorageItem('prod:SugarCRM:AuthAccessToken');
        } catch (\Exception $e) {
        }
        return $accessToken;
    }

    /**
     * Get local storage item value
     *
     * @param string $key
     *
     * @return string
     */
    protected function getLocalStorageItem($key)
    {
        $value = $this->getSession()->getDriver()->evaluateScript("localStorage.getItem('$key')");
        $decodedValue = json_decode($value);
        return $decodedValue ?: $value;
    }

    /**
     * Set local storage item
     *
     * @param $key
     * @param $value
     */
    protected function setLocalStorageItem($key, $value)
    {
        $this->getSession()->getDriver()->evaluateScript("localStorage.setItem('$key', '$value')");
    }

    /**
     * Wait until element is appear on the page
     * @When /^I wait for(?: the)? element "([^"]*)"$/
     * @And /^I wait for(?: the)? element "([^"]*)"$/
     * Example: I wait for element "ul.megamenu li button"
     */
    public function waitForElement($css)
    {
        $css = $this->fixStepArgument($css);
        $this->spin(function (FeatureContext $context) use ($css) {
            $element = $context->getSession()->getPage()->find('css', $css);
            return !is_null($element);
        }, 20);
    }

    /**
     * Spin wrapper for long test.
     * @param \Closure $lambda will call until not return true or time out
     * @param int $wait
     * @return bool
     * @throws \Exception
     */
    public function spin(\Closure $lambda, $wait = 60)
    {
        for ($i = 0; $i < $wait; $i++) {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (\Exception $e) {
                // do nothing
            }
            sleep(1);
        }

        $backtrace = debug_backtrace();

        throw new \Exception(
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
            (array_key_exists('file', $backtrace[1]) ? $backtrace[1]['file'] . ", line " . $backtrace[1]['line'] : '')
        );
    }

    /**
     * Mark scenario as pending.
     *
     * @Given /Mark scenario as pending (?:because|since|see)*(.*)$/
     * Example: Mark scenario as pending because it will be addressed in ticket NNN
     */
    public function iWantToMarkScenarioAsPending($reason)
    {
        $message = 'Scenario is pending.';
        if ($reason) {
            $message .= ' Reason: ' . trim($reason);
        }
        throw new PendingException($message);
    }

    /**
     * Closes all alerts on the page
     *
     * @Then I close alerts
     * @And I close alerts
     */
    public function iCloseAlerts()
    {
        $closeElements = $this->getSession()->getPage()->findAll('css', 'button.close.btn.btn-link.btn-invisible');
        foreach ($closeElements as $closeButton) {
            $closeButton->click();
        }
    }

    /**
     * Override method assertPageContainsText (MinkContext class) to wait for page is loaded
     *
     * Checks, that page contains specified text
     * Example: Then I should see "Who is the Batman?"
     * Example: And I should see "Who is the Batman?"
     */
    public function assertPageContainsText($text)
    {
        $this->waitForThePageToBeLoaded();
        $this->iWaitUntilTheLoadingIsCompleted();
        parent::assertPageContainsText($text);
    }

    /**
     * Override method assertPageNotContainsText (MinkContext class) to wait for page is loaded
     *
     * Checks, that page doesn't contain specified text
     * Example: Then I should not see "Batman is Bruce Wayne"
     * Example: And I should not see "Batman is Bruce Wayne"
     */
    public function assertPageNotContainsText($text)
    {
        $this->waitForThePageToBeLoaded();
        $this->iWaitUntilTheLoadingIsCompleted();
        parent::assertPageNotContainsText($text);
    }

    /**
     * Take a screenshot of a page if step fails.
     *
     * Disabled, use artifacts to see screenshots
     */
    public function takeScreenshotAfterFailedStep($event)
    {
        $stepResult = $event->getTestResult();
        if ($stepResult && $stepResult->getResultCode() == TestResult::FAILED) {
            try {
                $screenShot = $this->getSession()->getScreenshot();

                $this->printDecoratedMessage('At: ' . strftime('%c'));
                $this->printDecoratedMessage("Current page URL: " . $this->getSession()->getCurrentUrl());

                if (empty($screenShot)) {
                    $this->printDecoratedMessage("Screenshot is unavailable");
                    return;
                }

                $this->printDecoratedMessage(
                    "Screenshot of the page (base64-encoded):\n" .
                    "To preview copy the below contents & paste it to any online/offline base64-to-image converter."
                );
                $this->printDecoratedMessage(base64_encode($screenShot));
                $this->printDecoratedMessage("End of the screenshot");
            } catch (UnsupportedDriverActionException $e) {
                $this->printDecoratedMessage("Web Driver doesn't support taking of the screenshots.");
            }
        }
    }

    /**
     * Prints message with a header formed by a string specified in decorator.
     *
     * @param string $message
     * @param string $decorator
     *
     * @return string
     */
    protected function printDecoratedMessage($message, $decorator = '=')
    {
        echo str_repeat($decorator, 65) . "\n";
        echo $message . "\n";
    }

    /**
     * @AfterScenario
     * Clear cookies and reset session
     */
    public function resetSession()
    {
        $this->getSession()->reset();
    }

    /**
     * @param PageObjectFactory $pageObjectFactory
     *
     * @return null
     */
    public function setPageObjectFactory(PageObjectFactory $pageObjectFactory)
    {
        $this->pageObjectFactory = $pageObjectFactory;
    }

    /*
     * Implicit page object creation via factory.
     */
    protected function getPage($pageObjectClass)
    {
        return $this->pageObjectFactory->create($pageObjectClass);
    }
}
