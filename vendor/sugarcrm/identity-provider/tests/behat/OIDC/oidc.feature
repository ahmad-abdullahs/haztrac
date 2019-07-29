# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@login @oidc @logout
Feature: OIDC flow
  Verify OIDC login flow for local user with tenant id. User not exists in Sugar
  Verify OIDC login flow for local user. Tenant does not provided in auth url
  Verify OIDC login flow for local user. User rejects consent request
  Verify OIDC login flow for local user. User confirm consent request
  Verify OIDC login flow for LDAP user who has previously been provisioned. User not exists in Sugar
  Verify OIDC login flow for LDAP user who has previously been provisioned. User exists in Sugar
  Verify OIDC login flow for LDAP user who has not previously been provisioned
  Verify OIDC login flow and required fields' provisioning for LDAP user who has not previously been provisioned.
  Verify OIDC login flow initiated by SugarCRM with invalid password
  Verify OIDC login flow initiated by SugarCRM
  Verify OIDC refresh token flow
  Verify OIDC sudo flow
  Verify SugarCRM token endpoint in OIDC flow
  Verify login service session
  Verify that app is restricted by scope
  Verify logout
  Verify OIDC language selection for new user

  Scenario: Verify OIDC login flow for local user with tenant id. User not exists in Sugar
    Given I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "0000000001" and user "" and custom scope ""
    Then I should see IdP login page
    Given I do IdP login as "max" with password "max"
    Given I get access_token from STS
    When I use access_token for GET request "/rest/v11/me"
    Then I verify response contains "user_name" with value "max"
    And I verify response contains "full_name" with value "Max Jensen"
    And I verify response contains "address_country" with value "testcountry"

  Scenario: Verify OIDC login flow for local user. Tenant is not provided in auth url
    Given I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "" and user "sally" and custom scope ""
    And I should see IdP login page
    Then I fill in "0000000001" for "tid"
    Then I do IdP login as "" with password "sally"
    Given I get access_token from STS
    When I use access_token for GET request "/rest/v11/me"
    Then I verify response contains "user_name" with value "sally"
    And I verify response contains "full_name" with value "sally sally_family"
    And I verify response contains "address_country" with value "testcountry"

  Scenario: Verify OIDC login flow for local user. User confirm consent request
    Given I use "native" client
    And I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "srn:cloud:iam::0000000001:tenant" and user "" and custom scope ""
    Then I should see IdP login page
    Given I do IdP login as "max" with password "max"
    Then I confirm consent request
    Given I get access_token from STS

  Scenario: Verify OIDC login flow for local user. User rejects consent request
    Given I use "native" client
    And I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "srn:cloud:iam::0000000001:tenant" and user "" and custom scope ""
    Then I should see IdP login page
    Given I do IdP login as "max" with password "max"
    Then I reject consent request
    And I check that current url contains "No consent"

  Scenario: Verify OIDC login flow for LDAP user who has previously been provisioned. User not exists in Sugar
    Given I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "srn:cloud:iam::0000000001:tenant" and user "" and custom scope ""
    Then I should see IdP login page
    Given I do IdP login as "abey" with password "abey"
    Given I get access_token from STS
    Then I use access_token for GET request "/rest/v11/me"
    And I verify response contains "user_name" with value "abey"

  Scenario: Verify OIDC login flow for LDAP user who has previously been provisioned. User exists in Sugar
    Given I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "srn:cloud:iam::0000000001:tenant" and user "" and custom scope ""
    Then I should see IdP login page
    Given I do IdP login as "admin" with password "admin"
    Given I get access_token from STS
    Then I use access_token for GET request "/rest/v11/me"
    And I verify response contains "user_name" with value "admin"

  Scenario: Verify OIDC login flow for LDAP user who has not previously been provisioned
    Given I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "srn:cloud:iam::0000000001:tenant" and user "" and custom scope ""
    Then I should see IdP login page
    Given I do IdP login as "tandav" with password "tandav"
    Given I get access_token from STS
    Then I use access_token for GET request "/rest/v11/me"
    And I verify response contains "user_name" with value "tandav"

  Scenario: Verify OIDC login flow and required fields' provisioning for LDAP user who has not previously been provisioned.
    Given I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "srn:cloud:iam::0000000001:tenant" and user "" and custom scope ""
    Then I should see IdP login page
    Given I do IdP login as "onlyldapuser" with password "onlyldapuser"
    Given I get access_token from STS
    Then I use access_token for GET request "/rest/v11/me"
    And I verify response contains "user_name" with value "onlyldapuser"
    And I verify response contains "full_name" with value "onlyldapuser@0000000001.com"
    And I verify response contains "email.0.email_address" with value "onlyldapuser@0000000001.com"

  Scenario: Verify OIDC login flow for legacy clients with invalid password
    Given I am on the homepage
    And I wait until the loading is completed
    Then I should see IdP login page
    Given I do IdP login as "user2" with password "user3pass"
    Then I should see "Invalid credentials"

  Scenario Outline: Verify OIDC login flow initiated by SugarCRM
    Given I am on the homepage
    And I wait until the loading is completed
    Then I should see IdP login page
    Given I do IdP login as <username> with password <password>
    And I skip login wizard
    Then I should not see "Invalid credentials"
    Then I should see "Home Dashboard"
    And I logout
    Examples:
      | username | password    |
      | "sally"  | "sally"     |
      | "user2"  | "user2pass" |
      | "tandav" | "tandav"    |

  Scenario: Verify login user with last name longer then 30 chars.
    Given I am on the homepage
    And I wait until the loading is completed
    Then I should see IdP login page
    Given I do IdP login as "chris" with password "chris"
    And I skip login wizard
    Then I should not see "Invalid credentials"
    Then I should see "Home Dashboard"
    And I logout

  Scenario: Verify OIDC refresh token flow
    Given I am on the homepage
    And I wait until the loading is completed
    Then I should see IdP login page
    Given I do IdP login as "sally" with password "sally"
    And I skip login wizard
    Then I should not see "Invalid credentials"
    Then I should see "Home Dashboard"
    And I change access token to "expired"
    When I follow "Accounts"
    And I wait until the loading is completed
    Then I compare access token with "expired" as "notEquals"
    Then I should see "My Accounts"
    And I logout

  Scenario: Verify OIDC sudo flow
    Given I am on the homepage
    And I wait until the loading is completed
    Then I should see IdP login page
    Given I do IdP login as "admin" with password "admin"
    And I skip login wizard
    Then I get access_token from local storage
    Then I use access_token for POST request "/rest/v11/oauth2/sudo/sally"
    And I get access_token from sugar token response
    And I use access_token for GET request "/rest/v11/me"
    Then I verify response contains "user_name" with value "sally"
    Then I verify response contains "full_name" with value "sally sally_family"
    And I logout

  Scenario: Verify SugarCRM token endpoint in OIDC flow
    Given I get access_token for "sally" with password "sally"
    And I use access_token for GET request "/rest/v11/me"
    Then I verify response contains "user_name" with value "sally"
    Then I verify response contains "full_name" with value "sally sally_family"

  Scenario: Verify login service session
    Given I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "srn:cloud:idp::0000000001:tenant" and user "" and custom scope ""
    Then I should see IdP login page
    Given I do IdP login as "max" with password "max"
    When I navigate to OIDC provider with tenant "srn:cloud:idp::0000000001:tenant" and user "" and custom scope ""
    Then I should not see a "#username" element

  Scenario: Verify that app is restricted by scope
    Given I try to get Mango public metadata
    Then I navigate to OIDC provider with tenant "0000000001" and user "" and custom scope "test_scope"
    Then I should see IdP login page
    Given I do IdP login as "max" with password "max"
    Then I should see "This app hasn't been verified by SugarCRM"

  Scenario: Verify OIDC language selection for new user
    Given I am on the homepage
    And I wait until the loading is completed
    Then I should see IdP login page
    And I click "#languageList"
    And I follow "Deutsch"
    Given I do IdP login as "jim" with password "jim"
    And I wait until the loading is completed
    And I wait for the page to be loaded
    And I skip login wizard
    Then I should see "Startseiten-Dashboard"
    And I logout
