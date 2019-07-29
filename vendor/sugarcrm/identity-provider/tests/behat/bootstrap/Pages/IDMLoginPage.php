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

class IDMLoginPage extends AbstractPage
{
    protected $path = '/';
    protected $tidCss = "input[name='tid']";
    protected $usernameCss = "input#username";
    protected $passwordCss = "input#password";
    protected $logInCss = "a#submit_btn";
    protected $allowAccessCss = "a#consent_continue_btn";

    public function login($tid, $username, $password)
    {
        $this->waitForPageLoaded();
        $this->waitForAnyCssElement($this->tidCss, $this->logInCss);
        if ($this->doesCssElementExist($this->allowAccessCss)) {
            $this->clickByCss($this->allowAccessCss);
            $this->waitForPageLoaded();
            return;
        }
        if (!$this->getAttributeValue($this->tidCss, 'type') == 'hidden') {
            $this->waitElementByCss($this->tidCss, self::DEFAULT_TIMEOUT);
            $this->sendKeysByCss($this->tidCss, $tid);
        }
        $this->sendKeysByCss($this->usernameCss, $username);
        $this->sendKeysByCss($this->passwordCss, $password);
        $this->clickByCss($this->logInCss);
        $this->waitAjaxComplete();
        if ($this->doesCssElementExist($this->allowAccessCss)) {
            $this->clickByCss($this->allowAccessCss);
        }
        $this->waitAjaxComplete();
    }
}
