# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@modules @RevenueLineItems
Feature: RLI module Recalculate Values verification
  As a Sugar user, I need to be able to recalculate values of the records in the list view

  Background:
    Given I am logged in

  @quotes_recalculate_values @e2e
  Scenario: Quotes > List View > Recalculate Values > All Records
    Given Quotes records exist:
      | *name | date_quote_expected_closed | quote_stage | payment_terms |
      | Q_1   | 2020-10-19T19:20:22+00:00  | On Hold     | Net 15        |
      | Q_2   | 2020-10-19T19:20:22+00:00  | Delivered   | Net 30        |
      | Q_3   | 2020-10-19T19:20:22+00:00  | Confirmed   | Net 15        |
    And Accounts records exist:
      | *name       |
      | New Account |

    # Recalculate Values
    When I recalculate all values in Quotes

   # Verify that selected fields are updated for *Q_1 record
    Then Quotes *Q_1 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/19/2020 |
      | quote_stage                | On Hold    |

   # Verify that selected fields are updated for *Q_2 record
    And Quotes *Q_2 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/19/2020 |
      | quote_stage                | Delivered  |

   # Verify that selected fields are updated for *Q_3 record
    And Quotes *Q_3 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/19/2020 |
      | quote_stage                | Confirmed  |


  @quotes_mass_updates @e2e
  Scenario: Quotes > List View > Recalculate Values > Selected Records
    Given Quotes records exist:
      | *name | date_quote_expected_closed | quote_stage | payment_terms |
      | Q_1   | 2020-10-18T19:20:22+00:00  | On Hold     | Net 15        |
      | Q_2   | 2020-10-19T19:20:22+00:00  | Delivered   | Net 30        |
      | Q_3   | 2020-10-20T19:20:22+00:00  | Confirmed   | Net 15        |
      | Q_4   | 2020-10-21T19:20:22+00:00  | Closed Lost | Net 30        |
    And Accounts records exist:
      | *name       |
      | New Account |

    # Recalculate Values
    When I recalculate [*Q_1, *Q_2, *Q_4] values in Quotes

    # Verify that selected fields are updated for *Q_1 record
    Then Quotes *Q_1 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/18/2020 |
      | quote_stage                | On Hold    |

    # Verify that selected fields are updated for *Q_2 record
    And Quotes *Q_2 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/19/2020 |
      | quote_stage                | Delivered  |

    # Verify that selected fields are NOT !!! updated for *Q_3 record
    And Quotes *Q_3 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/20/2020 |
      | quote_stage                | Confirmed  |

    # Verify that selected fields are updated for *Q_4 record
    And Quotes *Q_4 should have the following values:
      | fieldName                  | value       |
      | date_quote_expected_closed | 10/21/2020  |
      | quote_stage                | Closed Lost |


  @rli_recalculate_value @e2e
  Scenario: RevenueLineItems > List View > Recalculate Values > All Records
    Given RevenueLineItems records exist:
      | *name | date_closed               | likely_case | best_case | sales_stage | quantity |
      | RLI_1 | 2020-10-19T19:20:22+00:00 | 200         | 300       | Prospecting | 1        |
      | RLI_2 | 2020-10-20T19:20:22+00:00 | 300         | 400       | Prospecting | 2        |
      | RLI_3 | 2020-10-21T19:20:22+00:00 | 400         | 500       | Prospecting | 3        |

    # Recalculate Values
    When I recalculate all values in RevenueLineItems

    Then RevenueLineItems *RLI_1 should have the following values:
      | fieldName   | value       |
      | date_closed | 10/19/2020  |
      | likely_case | $200.00     |
      | sales_stage | Prospecting |
      | quantity    | 1.00        |

    Then RevenueLineItems *RLI_2 should have the following values:
      | fieldName   | value       |
      | date_closed | 10/20/2020  |
      | likely_case | $300.00     |
      | sales_stage | Prospecting |
      | quantity    | 2.00        |

    Then RevenueLineItems *RLI_3 should have the following values:
      | fieldName   | value       |
      | date_closed | 10/21/2020  |
      | likely_case | $400.00     |
      | sales_stage | Prospecting |
      | quantity    | 3.00        |
