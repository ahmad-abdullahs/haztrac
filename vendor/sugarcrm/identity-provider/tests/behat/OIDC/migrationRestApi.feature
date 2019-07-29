# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@oidc @rest @migrationApi @extended
Feature: Migrate Mango in IDM mode
  Disable IDM mode and enable it

  Scenario: Disable IDM mode and enable it
    Given I send a GET request to "/rest/v11_2/metadata/public"
    And the JSON node "config.idmModeEnabled" should be equal to "true"
    Then I get access_token for admin
    Then I add access_token to header
    And I send a POST request to "/rest/v11_2/Administration/idm/migration/enable"
    And the JSON node "success" should be equal to "true"
    Then I add access_token to header
    And I send a DELETE request to "/rest/v11_2/Administration/settings/idmMode"
    Then I send a GET request to "/rest/v11_2/metadata/public"
    And the JSON node "config.idmModeEnabled" should be equal to "false"
    Then I get access_token for admin
    Then I add access_token to header
    And I send a POST request to "/rest/v11_2/Administration/idm/migration/disable"
    And the JSON node "success" should be equal to "true"
    Then I get access_token for admin
    Then I add access_token to header
    And I send a POST request to "/rest/v11_2/Administration/idm/migration/enable"
    And the JSON node "success" should be equal to "true"
    Then I send a POST request to "/rest/v11_2/Administration/idm/migration/disable"
    And the JSON node "error" should be equal to "maintenance"
    Then I add access_token to header
    Then I enable IDM mode
    Then I send a GET request to "/rest/v11_2/metadata/public"
    And the JSON node "config.idmModeEnabled" should be equal to "true"
    Then I add access_token to header
    And I send a POST request to "/rest/v11_2/Administration/idm/migration/disable"
    And the JSON node "success" should be equal to "true"

