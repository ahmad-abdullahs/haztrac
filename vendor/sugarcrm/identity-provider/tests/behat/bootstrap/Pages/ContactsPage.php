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

class ContactsPage extends AbstractPage
{
    protected $createButtonCss = "div.btn-toolbar a[href='#Contacts/create']";
    protected $showMoreCss = "button.more[data-moreless='more']";
    protected $editButtonCss = "a[name='edit_button']";
    protected $saveButtonXpath = "//a[@name='save_button' and not(@style='display: none;')]";
    protected $firstNameCss = "input[name='first_name']";
    protected $lastNameCss = "input[name='last_name']";

    protected $portalEditActiveCheckboxCss ="span.record-edit-link-wrapper[data-name='portal_active']";
    protected $portalActiveCheckboxCss = "span[data-fieldname='portal_active'] input";
    protected $portalEditUsernameCss = "span.record-edit-link-wrapper[data-name='portal_name']";
    protected $portalUsernameCss = "div[data-type='username'] input[name='portal_name']";
    protected $portalEditPasswordCss = "span.record-edit-link-wrapper[data-name='portal_password']";
    protected $portalPasswordCss = "div[data-type='change-password'] input[name='new_password']";
    protected $portalPasswordConfirmCss = "div[data-type='change-password'] input[name='confirm_password']";
    protected $successMessageCss = "div.alert-success";
    protected $closeAlertCss = "button[data-action='close']";

    protected $checkedPortalCss = "div[data-name='portal_active'] input[type='checkbox']:checked";
    protected $uncheckedPortalCss = "div[data-name='portal_active'] input[type='checkbox']:not(:checked)";

    protected $editDropdownCss = "div.main-pane h1 a[track='click:actiondropdown']";
    protected $deleteDropdownLinkCss = "div.main-pane ul.dropdown-menu a[track='click:delete_button']";
    protected $confirmDeleteCss = "div#alerts a[data-action='confirm']";


    /**
     * Creating contact with provided data
     * @param $username
     * @param $password
     * @param array $params
     */
    public function createContact($username, $password, array $params)
    {
        $this->clickByCss($this->createButtonCss);
        if ($this->isCssElementVisible($this->showMoreCss)) {
            $this->clickByCss($this->showMoreCss);
        }
        $this->waitForElement($this->firstNameCss);
        $this->sendKeysByCss($this->firstNameCss, $username);
        $this->sendKeysByCss($this->lastNameCss, $username);
        if (array_key_exists('portal', $params) && $params['portal'] == true) {
            $this->clickByCss($this->portalActiveCheckboxCss);
            $this->sendKeysByCss($this->portalUsernameCss, $username);
            $this->sendKeysByCss($this->portalPasswordCss, $password);
            $this->sendKeysByCss($this->portalPasswordConfirmCss, $password);
        }
        $this->clickByXpath($this->saveButtonXpath);
        $this->waitForElement($this->successMessageCss);
        $this->clickByCss($this->closeAlertCss);
    }

    /**
     * Open existing contact
     * @param $username
     */
    public function openContact($username)
    {
        $this->clickByXpath("//td[@data-type='fullname']//a[contains(text(), '" . $username . "')]");
        $this->waitLoadingComplete();
    }

    /**
     * Remove existing contact
     * @param $contactName
     */
    public function removeContact($contactName)
    {
        $this->openContact($contactName);
        $this->clickByCss($this->editDropdownCss);
        $this->clickByCss($this->deleteDropdownLinkCss);
        $this->clickByCss($this->confirmDeleteCss);
        $this->waitForElement($this->successMessageCss);
    }
}
