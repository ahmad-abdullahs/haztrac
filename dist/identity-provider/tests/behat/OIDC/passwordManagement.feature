# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@passwordManagement @oidc @extended
Feature: Password Management
  Verify Password Management page in SugarCRM
  Verify Password Management link in SugarCRM

  Scenario: Verify Password Management page in SugarCRM
    Given I am on the homepage
    And I wait until the loading is completed
    Then I should see IdP login page
    Given I do IdP login as "admin" with password "admin"
    And I wait until the loading is completed
    And I wait for the page to be loaded
    And I skip login wizard
    When I go to "/index.php?module=Administration&action=PasswordManager"
    And I switch to BWC
    And I wait for the element "#contentTable"
    Then I should see "Password Management is only available in Cloud Settings"
    And I logout

  Scenario: Verify Password Management link in SugarCRM
    Given I am on the homepage
    And I wait until the loading is completed
    Then I should see IdP login page
    Given I do IdP login as "admin" with password "admin"
    And I wait until the loading is completed
    And I wait for the page to be loaded
    And I skip login wizard
    And I wait for element "#userList"
    And I go to administration
    And I follow "Password Management"
    Then The document should open in a new tab with url "http://console.sugarcrm.local/password-management"
    And I logout
