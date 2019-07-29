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

use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Sugarcrm\IdentityProvider\Authentication\Exception\RuntimeException;

abstract class AbstractPage extends Page
{
    protected const DEFAULT_TIMEOUT = 10;

    protected $loadingAlertXpath = "//div[@class='alert-top']//div[@class='loading']";

    protected $userActionCss = "li#userActions button";
    protected $logoutLinkCss = "li.profileactions-logout a";

    /**
     * Logout from SugarCRM
     */
    public function logout()
    {
        $this->clickByCss($this->userActionCss);
        $this->clickByCss($this->logoutLinkCss);
        $this->waitLoadingDisappear();
    }

    /**
     * Wait for element by CSS locator
     * @param $locator
     */
    public function waitForElement($locator)
    {
        $result = null;
        try {
            $condition = "$(\"$locator\").length > 0";
            $result = $this->getDriver()->wait($this::DEFAULT_TIMEOUT * 1000, $condition);
        } catch (UnsupportedDriverActionException | DriverException $e) {
            throw new RuntimeException("Something wrong with webdriver");
        }
        if (!$result) {
            throw new RuntimeException("Element doesn't appears. css: $locator");
        }
    }

    /**
     * Wait for element appears on page
     * @param $css
     * @param $timeoutSec
     */
    public function waitElementByCss($css, $timeoutSec)
    {
        $counter = 0;
        do {
            $exist = $this->doesCssElementExist($css);
            $counter++;
            if ($exist) {
                break;
            }
            if ($counter >= $timeoutSec * 100) {
                throw new RuntimeException("Element doesn't appears. Css: " . $css);
            }
            usleep(10000);
        } while (!$exist);
    }

    /**
     * Wait until element disappear using css locator.
     * @param $locator
     */
    public function waitElementDisappear($locator)
    {
        $condition = "$(\"$locator\").length == 0";
        try {
            $result = $this->getDriver()->wait($this::DEFAULT_TIMEOUT * 1000, $condition);
        } catch (UnsupportedDriverActionException | DriverException $e) {
            throw new RuntimeException("Something wrong with webdriver");
        }
        if (!$result) {
            throw new RuntimeException("Element doesn't disappears. css: $locator");
        }
    }

    /**
     * Wait while element appears by xpath
     * @param $xpath
     * @param $timeout
     */
    public function waitElementByXpath($xpath, $timeout)
    {
        $counter = 0;
        do {
            $exist = $this->doesXpathElementExist($xpath);
            $counter++;
            if ($exist) {
                break;
            }
            if ($counter >= $timeout * 100) {
                throw new RuntimeException("Element doesn't appears. Xpath: " . $xpath);
            }
            usleep(10000);
        } while (!$exist);
    }

    /**
     * Wait while element disappear by xpath
     * @param $xpath
     * @param $timeout
     */
    public function waitElementDisappearByXpath($xpath, $timeout)
    {
        $counter = 0;
        do {
            $exist = $this->doesXpathElementExist($xpath);
            $counter++;
            if (!$exist) {
                break;
            }
            if ($counter >= $timeout * 100) {
                throw new RuntimeException("Element doesn't disappear. Xpath: ". $xpath);
            }
            usleep(10000);
        } while ($exist);
    }

    /**
     * Wait while loading spinner disappear
     */
    public function waitLoadingDisappear()
    {
        $this->waitElementByXpath($this->loadingAlertXpath, $this::DEFAULT_TIMEOUT);
        $this->waitElementDisappearByXpath($this->loadingAlertXpath, $this::DEFAULT_TIMEOUT);
        $this->waitLoadingComplete();
    }

    /**
     * Wait for page loading complete
     * @throws DriverException
     * @throws UnsupportedDriverActionException
     */
    public function waitLoadingComplete()
    {
        $this->getDriver()->wait($this::DEFAULT_TIMEOUT * 1000, "window.jQuery != undefined && jQuery.active === 0");
        $this->getDriver()->wait($this::DEFAULT_TIMEOUT * 1000, "document.readyState === 'complete'");
        $this->waitAjaxComplete();
    }

    /**
     * Wait for page loaded
     * @throws DriverException
     * @throws UnsupportedDriverActionException
     */
    public function waitForPageLoaded()
    {
        $this->getDriver()->wait($this::DEFAULT_TIMEOUT * 1000, "document.readyState === 'complete'");
    }

    /**
     * Click on element using css locator
     * @param $css
     */
    public function clickByCss($css)
    {
        $this->waitElementByCss($css, self::DEFAULT_TIMEOUT);
        $this->find('css', $css)->click();
    }

    /**
     * Click on element using xpath locator
     * @param $xpath
     */
    public function clickByXpath($xpath)
    {
        $this->waitElementByXpath($xpath, $this::DEFAULT_TIMEOUT);
        $this->find('xpath', $xpath)->click();
    }

    /**
     * Send keys to element using css locator
     * @param $css
     * @param $value
     */
    public function sendKeysByCss($css, $value)
    {
        $this->find('css', $css)->setValue($value);
    }

    /**
     * Sent keys to element using xpath locator
     * @param $xpath
     * @param $value
     */
    public function sendKeysByXpath($xpath, $value)
    {
        $this->find('xpath', $xpath)->setValue($value);
    }

    /**
     * Wait for all Ajax queries complete
     */
    public function waitAjaxComplete()
    {
        try {
            $this->getDriver()->wait($this::DEFAULT_TIMEOUT * 1000, "jQuery.active == 0");
        } catch (UnsupportedDriverActionException | DriverException $e) {
            throw new RuntimeException("Something wrong with webdriver");
        }
    }

    /**
     * Visibility state of element using css locator
     * @param $css
     * @return bool
     */
    public function isCssElementVisible($css)
    {
        return $this->find('css', $css)->isVisible();
    }

    /**
     * Existing of element on page using css locator
     * @param $css
     * @return bool
     */
    public function doesCssElementExist($css)
    {
        return count($this->findAll('css', $css)) > 0;
    }

    /**
     * Existing of element on page using xpath locator
     * @param $xpath
     * @return bool
     */
    public function doesXpathElementExist($xpath)
    {
        return count($this->findAll('xpath', $xpath)) > 0;
    }

    /**
     * Wait for any element exist on page using CSS
     * @param array ...$css
     */
    public function waitForAnyCssElement(...$css)
    {
        if (!$css) {
            return;
        }

        $conditions = array_map(function ($el) {
            return sprintf('document.querySelectorAll("%s").length > 0', $el);
        }, $css);
        $selectors = array_map(function ($k, $v) {
            return sprintf('CSS-%d: %s', $k + 1, $v);
        }, array_keys($css), array_values($css));

        try {
            $this->getDriver()->wait(self::DEFAULT_TIMEOUT * 1000, implode(' || ', $conditions));
        } catch (UnsupportedDriverActionException | DriverException $e) {
            throw new RuntimeException('Elements don\'t appear: ' . implode(', ', $selectors));
        }
    }

    /**
     * Get attribute value if attribute exists
     * @param $css string
     * @param $attribute string
     * @return string
     */
    public function getAttributeValue($css, $attribute) : string
    {
        if ($this->find('css', $css)->hasAttribute($attribute)) {
            return $this->find('css', $css)->getAttribute($attribute);
        } else {
            return '';
        }
    }
}
