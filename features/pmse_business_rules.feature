# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
# Copyright (C) SugarCRM Inc. All rights reserved.

@modules @pmse_business_rules
Feature: pmse_Business_Rules module verification

  Background:
    Given I am logged in

  @pmse_business_rules_conditions @pr @e2e
  Scenario: pmse_Business_Rules > Verify that condition/conclusion are populated to the Business Rule UI
    Given pmse_Business_Rules records exist:
      | *name  | rst_type | rst_module | rst_source_definition |
      | PB_1   | single   | Accounts   | {"base_module":"Accounts","type":"single","columns":{"conditions":[{"module":"Accounts","field":"industry"},{"module":"Accounts","field":"name"}],"conclusions":["","account_type"]},"ruleset":[{"id":1,"conditions":[{"value":[{"expType":"CONSTANT","expSubtype":"string","expLabel":"Apparel","expValue":"Apparel"}],"variable_name":"industry","condition":"==","variable_module":"Accounts"},{"value":[{"expType":"CONSTANT","expSubtype":"string","expLabel":"\"abc\"","expValue":"abc"}],"variable_name":"name","condition":"not_equals","variable_module":"Accounts"}],"conclusions":[{"value":[{"expType":"CONSTANT","expSubtype":"boolean","expLabel":"TRUE","expValue":true}],"conclusion_value":"result","conclusion_type":"return"},{"value":[{"expType":"CONSTANT","expSubtype":"string","expLabel":"Analyst","expValue":"Analyst"}],"conclusion_value":"account_type","conclusion_type":"variable","variable_module":"Accounts"}]},{"id":2,"conditions":[{"value":[{"expType":"CONSTANT","expSubtype":"string","expLabel":"Banking","expValue":"Banking"}],"variable_name":"industry","condition":"!=","variable_module":"Accounts"}],"conclusions":[{"value":[{"expType":"VARIABLE","expSubtype":"Phone","expLabel":"Alternate Phone","expValue":"phone_alternate","expModule":"Accounts"}],"conclusion_value":"result","conclusion_type":"return"}]}]} |
    When I begin designing pmse_Business_Rules *PB_1
    Then the pmse business rule designer should contain the following values:
    # Create 2 rows with condition x 2 columns and conclusion x 2 columns (including Return Value)
      | fieldName  | value             |
      | operator_1 | ==                |
      | cd_value_1 | Apparel           |
      | operator_1 | is not            |
      | cd_value_1 | "abc"             |
      | cc_value_1 | TRUE              |
      | cc_value_1 | Analyst           |
      | operator_2 | !=                |
      | cd_value_2 | Banking           |
      | cc_value_2 |                   |
      | cc_value_2 | Alternate Phone   |
