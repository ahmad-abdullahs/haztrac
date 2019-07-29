@login @idm @portal
Feature: User can login to portal if access is permitted.
  Scenario Outline: Access granted
    Given I logged in SugarCRM as administrator
    When I create contact <username> with password <password> and grant access to portal
    And I logout
    And I am on portal login page
    And I login to portal as <username> with password <password>
    Then I should logged in portal
    And I logout portal
      Examples:
        | username  | password |
        | portal    | port123  |

  Scenario Outline: Access denied
    Given I logged in SugarCRM as administrator
    When I create contact <username> with password <password> and deny access to portal
    And I logout
    And I am on portal login page
    And I login to portal as <username> with password <password>
    Then I should see message "Invalid Credentials"
      Examples:
      | username    | password |
      | dportal     | port123  |
