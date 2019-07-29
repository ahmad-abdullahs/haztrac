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

class AdministrationPage extends AbstractPage
{
    /*
     * Sugar Portal
     */
    protected $bwcFrame = "bwc-frame";
    protected $bwcFrameCss = "iframe#bwc-frame";
    protected $sugarPortalLinkCss = "a#sugarportal";
    protected $configurePortalLinkXpath = "//table[contains(@onclick, 'portalconfig')]//tr[1]//a";
    protected $uncheckedPortalCss = "input[type='checkbox'][name='appStatus']:not(:checked)";
    protected $bwcDoneXpath = "//div[@id='ajaxStatusDiv' and not(contains(@style, 'display: none'))]//b[text()='Done']";
    protected $saveButtonCss = "input#gobutton";

    /**
     * Portal is enabled check.
     * @throws \Behat\Mink\Exception\DriverException
     * @throws \Behat\Mink\Exception\UnsupportedDriverActionException
     */
    public function checkPortalEnabled()
    {
        $this->waitLoadingComplete();
        $this->waitForElement($this->bwcFrameCss);
        sleep(1);
        $this->getDriver()->switchToIFrame($this->bwcFrame);
        $this->waitLoadingComplete();
        $this->clickByCss($this->sugarPortalLinkCss);
        $this->waitElementByXpath($this->bwcDoneXpath, $this::DEFAULT_TIMEOUT);
        $this->clickByXpath($this->configurePortalLinkXpath);
        $this->waitForElement($this->saveButtonCss);
        if ($this->doesCssElementExist($this->uncheckedPortalCss)) {
            $this->clickByCss($this->uncheckedPortalCss);
            $this->clickByCss($this->saveButtonCss);
            $this->waitElementByXpath($this->bwcDoneXpath, $this::DEFAULT_TIMEOUT);
        }
        $this->getDriver()->switchToIFrame(null);
    }
}
