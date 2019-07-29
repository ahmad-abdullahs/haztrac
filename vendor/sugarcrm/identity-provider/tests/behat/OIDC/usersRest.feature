# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.
@userManagement @rest @oidc
Feature: User REST API in IDM mode
  When Mango is in IDM mode
  User REST API should be limited

  Scenario Outline: User create REST API is forbidden
    Given I get access_token for admin
    When I add access_token to header
    And I set "Content-Type" header equal to "application/json"
    And I send a POST request to "<url>" with body:
        """
        <body>
        """
    Then the JSON node "error" should be equal to "not_authorized"
    Examples:
      | url                 | body                                                                               |
      | /rest/v10/Users     | {"id" : "idmModeRestCreatedUser1", "user_name": "idmModeRestCreatedUser1"}         |
      | /rest/v10/Employees | {"id" : "idmModeRestCreatedEmployee1", "user_name": "idmModeRestCreatedEmployee1"} |

  Scenario Outline: User create REST API is allowed with bypass flag
    Given I get access_token for admin
    When I add access_token to header
    And I set "Content-Type" header equal to "application/json"
    And I send a POST request to "<url>" with body:
        """
        <body>
        """
    Then the JSON node "error" should not exist
    And the JSON node "id" should exist
    Examples:
      | url                                                 | body                                                                               |
      | /rest/v10/Users?skip_idm_mode_restrictions=true     | {"id" : "idmModeRestCreatedUser1", "user_name": "idmModeRestCreatedUser1"}         |
      | /rest/v10/Employees?skip_idm_mode_restrictions=true | {"id" : "idmModeRestCreatedEmployee1", "user_name": "idmModeRestCreatedEmployee1"} |

  Scenario Outline: User update REST API is forbidden(idm mode fields will be ignored)
    Given I get access_token for admin
    When I add access_token to header
    And I set "Content-Type" header equal to "application/json"
    And I send a PUT request to "<url>" with body:
        """
        <body>
        """
    Then the JSON node "user_name" should be equal to "<old_value>"
    And the JSON node "error" should not exist
    And the JSON node "id" should exist
    Examples:
      | url                                             | body                                                                              | old_value                   |
      | /rest/v10/Users/idmModeRestCreatedUser1         | {"id" : "idmModeRestCreatedUser1", "user_name": "idmModeRestUpdateUser1"}         | idmModeRestCreatedUser1     |
      | /rest/v10/Employees/idmModeRestCreatedEmployee1 | {"id" : "idmModeRestCreatedEmployee1", "user_name": "idmModeRestUpdateEmployee1"} | idmModeRestCreatedEmployee1 |

  Scenario Outline: User update REST API is allowed with bypass flag
    Given I get access_token for admin
    When I add access_token to header
    And I set "Content-Type" header equal to "application/json"
    And I send a PUT request to "<url>" with body:
        """
        <body>
        """
    Then the JSON node "user_name" should be equal to "<new_value>"
    And the JSON node "error" should not exist
    And the JSON node "id" should exist
    Examples:
      | url                                                                             | body                                                                              | new_value                  |
      | /rest/v10/Users/idmModeRestCreatedUser1?skip_idm_mode_restrictions=true         | {"id" : "idmModeRestCreatedUser1", "user_name": "idmModeRestUpdateUser1"}         | idmModeRestUpdateUser1     |
      | /rest/v10/Employees/idmModeRestCreatedEmployee1?skip_idm_mode_restrictions=true | {"id" : "idmModeRestCreatedEmployee1", "user_name": "idmModeRestUpdateEmployee1"} | idmModeRestUpdateEmployee1 |

  Scenario Outline: User delete REST API is forbidden
    Given I get access_token for admin
    When I add access_token to header
    And I set "Content-Type" header equal to "application/json"
    And I send a <method> request to "<url>" with body:
        """
        <body>
        """
    Then the JSON node "error" should be equal to "not_authorized"
    Examples:
      | method | url                                             | body                                                                               |
      | DELETE | /rest/v10/Users/idmModeRestCreatedUser1         | { }                                                                                |
      | DELETE | /rest/v10/Employees/idmModeRestCreatedEmployee1 | { }                                                                                |

  Scenario Outline: User delete REST API is allowed with bypass flag
    Given I get access_token for admin
    When I add access_token to header
    And I set "Content-Type" header equal to "application/json"
    And I send a DELETE request to "<url>" with body:
        """
        {}
        """
    Then the JSON node "error" should not exist
    And the JSON node "id" should exist
    Examples:
      | url                                                                             |
      | /rest/v10/Users/idmModeRestCreatedUser1?skip_idm_mode_restrictions=true         |
      | /rest/v10/Employees/idmModeRestCreatedEmployee1?skip_idm_mode_restrictions=true |
