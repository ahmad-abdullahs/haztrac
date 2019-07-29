# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@loginService @ldap @login @logout
Feature: LDAP
  New LDAP user tries to login if provision is enabled
  New LDAP user tries to login if provision is enabled and user filter is present

  Scenario: New LDAP user tries to login if provision is enabled
    Given I am on "/"
    And I login as "abey" with password "abey" to tenant "0000000002"
    Then I should see "You are logged in as abey"
    Then I should see "Your tenant id is srn:cloud:iam:eu:0000000002:tenant"
    Then I should see "Authentication provider - LDAP"
    And I do logout
    Then I should see "Log In"

  Scenario: New LDAP user tries to login if provision is enabled and user filter is present
    Given I am on "/"
    And I login as "user1" with password "user1" to tenant "0000000003"
    Then I should see "You are logged in as user1"
    Then I should see "Your tenant id is srn:cloud:iam:eu:0000000003:tenant"
    Then I should see "Authentication provider - LDAP"
    And I do logout
    Then I should see "Log In"

  Scenario: User no see tenant if it pre-filled
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:0000000002:tenant"
    Then I wait for the element "input[name=user_name]"
    Then I should not see "Tenant"
    And I should not see a "#tid" element
    When I fill in "user_name" with "abey"
    When I fill in "password" with "abey"
    Then I click "#submit_btn"
    And I wait for the page to be loaded
    Then I should see "You are logged in as abey"
    Then I should see "Your tenant id is srn:cloud:iam:eu:0000000002:tenant"
    Then I should see "Authentication provider - LDAP"
    And I do logout
    Then I should see "Log In"
    And I should see an "input[placeholder=Tenant]" element
    And I should see a "#tid" element
