# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@loginService @login @saml
Feature: SAML
  SAML login form. New SAML user tries to login if provision is enabled
  Regular login form. SAML user tries to login
  SAML login form. Can switch to regular login form and login as local user
  User sees an error in case of empty tenant
  User sees an error in case of invalid tenant
  User sees an error in case of tenant with not configured SAML
  User sees an error in case of tenant with wrong configured SAML

  Scenario: SAML login form. New SAML user tries to login if provision is enabled
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:0000000004:tenant"
    Then I wait for the element "a[name=external_login_button]"
    Then I click "a[name=external_login_button]"
    Then I wait for the page to be loaded
    Then I should see "Enter your username and password"
    When I fill in "user5" for "username"
    And I fill in "user5pass" for "password"
    And I press "Login"
    Then I should see "user5@example.com"
    And I should see "You are logged in"
    Then I should see "Authentication provider - Saml"
    Then I click "#logout_btn"

  Scenario: Regular login form. SAML user tries to login
    Given I am on "/"
    Then I wait for the element "input[name=tid]"
    Then I wait for the element "input[name=user_name]"
    And I wait for the element "input[name=password]"
    Then I fill in "tid" with "srn:cloud:iam:eu:0000000004:tenant"
    Then I click "a[name=sso_button]"
    Then I wait for the page to be loaded
    Then I should see "Enter your username and password"
    When I fill in "user5" for "username"
    And I fill in "user5pass" for "password"
    And I press "Login"
    Then I should see "user5@example.com"
    And I should see "You are logged in"
    Then I should see "Authentication provider - Saml"
    Then I click "#logout_btn"

  Scenario: SAML login form. Can switch to regular login form and login as local user
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:0000000004:tenant"
    Then I wait for the element "a[name=login_form_button]"
    Then I click "a[name=login_form_button]"
    Then I wait for the element "input[name=user_name]"
    Then I should not see "Tenant"
    And I should not see a "#tid" element
    When I fill in "user_name" with "sally"
    When I fill in "password" with "sally"
    Then I click "#submit_btn"
    And I wait for the page to be loaded
    Then I should see "You are logged in as sally"
    Then I should see "Your tenant id is srn:cloud:iam:eu:0000000004:tenant"
    Then I should see "Authentication provider - Local"
    Then I do logout

  Scenario: User sees an error in case of empty tenant
    Given I am on "/"
    Then I wait for the element "input[name=tid]"
    And I wait for the element "a[name=sso_button]"
    Then I click "a[name=sso_button]"
    Then I should see a "#tid" element
    And I should see "Invalid tenant ID"

  Scenario: User sees an error in case of invalid tenant
    Given I am on "/"
    Then I wait for the element "input[name=tid]"
    And I wait for the element "a[name=sso_button]"
    Then I fill in "tid" with "INVALID_TENANT_ID"
    Then I click "a[name=sso_button]"
    Then I should see a "#tid" element
    And I should see "Invalid tenant ID"

  Scenario: User sees an error in case of tenant with not configured SAML
    Given I am on "/"
    Then I wait for the element "input[name=tid]"
    And I wait for the element "a[name=sso_button]"
    Then I fill in "tid" with "0000000001"
    Then I click "a[name=sso_button]"
    Then I should not see a "#tid" element
    And I should see "SAML is not configured for given tenant"
    And I go to "/logout"

  Scenario: User sees an error in case of tenant with wrong configured SAML
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:0000000005:tenant"
    Then I wait for the element "a[name=external_login_button]"
    Then I click "a[name=external_login_button]"
    Then I wait for the page to be loaded
    Then I should see "Enter your username and password"
    When I fill in "user1" for "username"
    And I fill in "user1pass" for "password"
    And I press "Login"
    Then I wait for the page to be loaded
    And I should not see "You are logged in"
    And I should see "Login using SAML"
    And I should see a "#sso_btn" element
    And I go to "/logout"
