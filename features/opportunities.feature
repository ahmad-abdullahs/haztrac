# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@modules @Opportunity
Feature: Opportunity characteristic verification
  As a Sugar user, I need to be able to create, update, and track Opportunities related to Accounts
  through the Opportunity itself and through the use of Revenue Line Items
  Background:
     Given I am logged in

  @opportunity_sales_stage @pr @php @api @e2e
  Scenario: Opportunities >  Verify that RLIs with closed lost sales stage are not included
    in the Opportunity rollup total
    Given RevenueLineItems records exist:
      | *name | date_closed               | worst_case | likely_case | best_case | sales_stage | quantity |
      | RLI_1 | 2018-10-19T19:20:22+00:00 | 200        | 300         | 400       | Prospecting | 5        |
    And Opportunities records exist related via opportunities link to *RLI_1:
      | *name |
      | Opp_1 |
    When I update RevenueLineItems *RLI_1 with the following values:
      | sales_stage |
      | Closed Lost |
    Then Opportunities *Opp_1 should have the following values:
      | fieldName  | value |
      | amount     | $0.00 |
      | best_case  | $0.00 |
      | worst_case | $0.00 |

  @opportunity_sale_status @pr @php @api @e2e
  Scenario Outline: Opportunities > Verify that Status of the opportunity is changed to closed won/lost if
    all RLIs linked to the opportunity have sales stage "Close won/lost"
    Given RevenueLineItems records exist:
      | *name | date_closed               | worst_case | likely_case | best_case | sales_stage | quantity |
      | RLI_1 | 2018-10-19T19:20:22+00:00 | 200        | 300         | 400       | Prospecting | 5        |
    And Opportunities records exist related via opportunities link to *RLI_1:
      | *name |
      | Opp_1 |
    When I update RevenueLineItems *RLI_1 with the following values:
      | sales_stage     |
      | <rliSalesStage> |
    Then Opportunities *Opp_1 should have the following values:
      | fieldName    | value       |
      | sales_status | <oppStatus> |
    Examples:
      | rliSalesStage | oppStatus   |
      | Closed Won    | Closed Won  |
      | Closed Lost   | Closed Lost |
      | Qualification | In Progress |

  @opportunity_accounts @pr @php @api @e2e
  Scenario: Opportunities > Verify that changing account on opportunity should cascade down to all RLIs
    linked to this opportunity
    Given RevenueLineItems records exist:
      | *name | date_closed               | worst_case | likely_case | best_case | sales_stage | quantity |
      | RLI_1 | 2018-10-19T19:20:22+00:00 | 200        | 300         | 400       | Prospecting | 5        |
    And Opportunities records exist related via opportunities link to *RLI_1:
      | *name |
      | Opp_1 |
    And Accounts records exist:
      | name         |
      | Account_1    |
      | #@##_acc_%^& |
    When I update Opportunities *Opp_1 with the following values:
      | account_name |
      | Account_1    |
    Then RevenueLineItems *RLI_1 should have the following values:
      | fieldName    | value     |
      | account_name | Account_1 |
    When I update Opportunities *Opp_1 with the following values:
      | account_name |
      | #@##_acc_%^& |
    Then RevenueLineItems *RLI_1 should have the following values:
      | fieldName    | value        |
      | account_name | #@##_acc_%^& |

  # @opportunity_not_able_to_delete @pr @e2e
  # Scenario Outline: Opportunities > Verify Opportunity cannot be deleted in the record view if sales stage of one or more RLIs is closed won
  #   Given RevenueLineItems records exist:
  #     | *name | date_closed               | worst_case | likely_case | best_case | sales_stage        | quantity |
  #     | RLI_1 | 2018-10-19T19:20:22+00:00 | 200        | 300         | 400       | <closedSalesStage> | 5        |
  #   And Opportunities records exist related via opportunities link to *RLI_1:
  #     | *name |
  #     | Opp_1 |
  #   Then Opportunities *Opp_1 should have the following values:
  #     | menu_item | active |
  #     | Delete    | false  |
  #   # Change RLI sales stage to any but not Closed
  #   When I update RevenueLineItems *RLI_1 with the following values:
  #     | sales_stage       |
  #     | <otherSalesStage> |
  #   Then Opportunities *Opp_1 should have the following values:
  #     | menu_item | active |
  #     | Delete    | true   |
  #   Examples:
  #     | closedSalesStage | otherSalesStage |
  #     | Closed Won       | Needs Analysis  |
  #     | Closed Lost      | Prospecting     |
