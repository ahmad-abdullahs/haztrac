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

class TopMenuPage extends AbstractPage
{
    protected $contactsLocator = "ul.megamenu a.btn[href='#Contacts']";
    protected $userDropButtonCss = "ul#userList";
    protected $logOutLinkCss = "li.profileactions-logout a";
    protected $administrationLinkCss = "li.administration a";

    /**
     * Open contacts module
     */
    public function goToContacts()
    {
        $this->clickByCss($this->contactsLocator);
        $this->waitLoadingComplete();
    }

    /**
     * Open administration module
     */
    public function goToAdministration()
    {
        $this->clickByCss($this->userDropButtonCss);
        $this->clickByCss($this->administrationLinkCss);
    }

    /**
     * Logout from SugarCRM
     */
    public function logout()
    {
        $this->clickByCss($this->userDropButtonCss);
        $this->waitForElement($this->logOutLinkCss);
        $this->clickByCss($this->logOutLinkCss);
        $this->waitLoadingComplete();
    }
}
