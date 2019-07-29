# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@custom_filters
Feature: Custom filters
  As a Sugar user, I need to be able to add, edit, reset and delete custom filters
  in the list view of any SIDECAR module

  Background:
    Given I am logged in

  @custom_filter_cancel @e2e
  Scenario: Custom list view filter > Cancel
    Given Quotes records exist:
      | *name | date_quote_expected_closed | quote_stage     | payment_terms |
      | Q_1   | 2020-10-19T19:20:22+00:00  | On Hold         | Net 15        |
      | Q_2   | 2020-10-20T19:20:22+00:00  | Delivered       | Net 30        |
      | Q_3   | 2020-10-20T19:20:22+00:00  | Closed Accepted | Net 30        |
      | Q_4   | 2020-10-20T19:20:22+00:00  | On Hold         | Net 30        |

    # Cancel adding custom filter creation is cancellled
    When I cancel custom filter 'New Filter 1' on the Quotes list view with the following values:
      | fieldName                  | filter_operator | filter_value |
      | quote_stage                | is any of       | On Hold      |
      | date_quote_expected_closed | is equal to     | 10/20/2020   |

    # Verify list view content
    Then I should see [*Q_1, *Q_2, *Q_3, *Q_4] on Quotes list view


  @custom_filter_add @custom_filter_edit @e2e
  Scenario: Custom list view filter > Add / Edit
    Given Quotes records exist:
      | *name | date_quote_expected_closed | quote_stage     | payment_terms |
      | Q_1   | 2020-10-19T19:20:22+00:00  | On Hold         | Net 15        |
      | Q_2   | 2020-10-20T19:20:22+00:00  | Delivered       | Net 30        |
      | Q_3   | 2020-10-20T19:20:22+00:00  | Closed Accepted | Net 30        |
      | Q_4   | 2020-10-20T19:20:22+00:00  | On Hold         | Net 30        |

    # Add custom filter
    When I add custom filter 'New Filter 1' on the Quotes list view with the following values:
      | fieldName                  | filter_operator | filter_value   |
      | quote_stage                | is any of       | On Hold, Draft |
      | date_quote_expected_closed | is equal to     | 10/20/2020     |

    # Verify list view content
    Then I should see [*Q_4] on Quotes list view
    And I should not see [*Q_1, *Q_2, *Q_3] on Quotes list view

    # Edit existing custom filter
    When I edit custom filter 'New Filter 1' on the Quotes list view with the following values:
      | fieldName                  | filter_operator | filter_value |
      | quote_stage                | is any of       | Delivered    |
      | date_quote_expected_closed | after           | 10/19/2020   |
      | name                       | exactly matches | Q_2          |

    # Verify list view content
    Then I should see [*Q_2] on Quotes list view
    And I should not see [*Q_1, *Q_3, *Q_4] on Quotes list view


  @custom_filter_hide_apply @e2e
  Scenario: Multiple custom list view filters > Hide / Apply
    Given Quotes records exist:
      | *name | date_quote_expected_closed | quote_stage     | payment_terms |
      | Q_1   | 2020-10-19T19:20:22+00:00  | On Hold         | Net 15        |
      | Q_2   | 2020-10-20T19:20:22+00:00  | Delivered       | Net 30        |
      | Q_3   | 2020-10-20T19:20:22+00:00  | Closed Accepted | Net 30        |
      | Q_4   | 2020-10-20T19:20:22+00:00  | On Hold         | Net 30        |

    # Add first custom filter
    When I add custom filter 'New Filter 1' on the Quotes list view with the following values:
      | fieldName                  | filter_operator | filter_value |
      | quote_stage                | is any of       | On Hold      |
      | date_quote_expected_closed | is equal to     | 10/20/2020   |

    # Verify list view content
    Then I should see [*Q_4] on Quotes list view
    And I should not see [*Q_1, *Q_2, *Q_3] on Quotes list view

    # Hide first custom filter
    And I hide custom filter 'New Filter 1' on the Quotes list view

    # Verify list view content
    Then I should see [*Q_1, *Q_2, *Q_3, *Q_4] on Quotes list view

    # Add second custom filter
    When I add custom filter 'New Filter 2' on the Quotes list view with the following values:
      | fieldName                  | filter_operator | filter_value |
      | quote_stage                | is not any of   | Delivered    |
      | date_quote_expected_closed | is equal to     | 10/20/2020   |
      | name                       | starts with     | Q_           |

    # Hide second custom filter
    And I hide custom filter 'New Filter 2' on the Quotes list view

    # Apply first custom filter
    When I apply custom filter 'New Filter 1' on the Quotes list view

    # Verify list view content
    Then I should see *Q_4 in #QuotesList.ListView
    And I should not see [*Q_1, *Q_2, *Q_3] on Quotes list view

    # Apply second custom filter
    When I apply custom filter 'New Filter 2' on the Quotes list view

    # Verify list view content
    Then I should see [*Q_3, *Q_4] on Quotes list view
    And I should not see [*Q_1, *Q_2] on Quotes list view


  @custom_filter_delete @e2e
  Scenario: Custom list view filter > Delete
    Given Accounts records exist:
      | *name | account_type | industry   |
      | A_1   | Analyst      | Consulting |
      | A_2   | Competitor   | Education  |
      | A_3   | Customer     | Consulting |
      | A_4   | Analyst      |            |

    # Add Custom filter
    When I add custom filter 'Account Filter 1' on the Accounts list view with the following values:
      | fieldName    | filter_operator | filter_value |
      | account_type | is any of       | Analyst      |
      | industry     | is not empty    |              |

    # Verify list view content
    Then I should see [*A_1] on Accounts list view
    And I should not see [*A_2, *A_3, *A_4] on Accounts list view

    # Delete custom filter
    When I delete custom filter 'New Filter 1' on the Accounts list view

    # Verify list view content after filter is deleted
    Then I should see [*A_1, *A_2, *A_3, *A_4] on Accounts list view


  @custom_filter_reset @e2e @ENT-only
  Scenario: Custom list view filter > Reset
    Given RevenueLineItems records exist:
      | *name | date_closed               | likely_case | best_case | sales_stage        | quantity |
      | R_1   | 2018-10-19T19:20:22+00:00 | 300         | 350       | Prospecting        | 5        |
      | R_2   | 2018-11-19T19:20:22+00:00 | 350         | 400       | Needs Analysis     | 5        |
      | R_3   | 2018-12-19T19:20:22+00:00 | 400         | 400       | Negotiation/Review | 4        |
      | R_4   | 2018-12-19T19:20:22+00:00 | 400         | 500       | Negotiation/Review | 3        |

    # Add Custom filter
    When I add custom filter 'RLI Filter 1' on the RevenueLineItems list view with the following values:
      | fieldName   | filter_operator | filter_value          |
      | likely_case | is greater than | 300                   |
      | best_case   | is less than    | 500                   |
      | date_closed | is between      | 01/01/2018,12/31/2018 |

    # Verify list view content
    Then I should see [*R_2, *R_3] on RevenueLineItems list view
    And I should not see [*R_1, *R_4] on RevenueLineItems list view

    # Reset custom filter
    When I reset custom filter 'New Filter 1' on the RevenueLineItems list view with the following values:
      | fieldName   | filter_operator             | filter_value       |
      | likely_case | is greater than or equal to | 300                |
      | best_case   | is less than or equal to    | 500                |
      | sales_stage | is any of                   | Negotiation/Review |

    # Verify list view content
    Then I should see [*R_3, *R_4] on RevenueLineItems list view
    And I should not see [*R_1, *R_2] on RevenueLineItems list view
