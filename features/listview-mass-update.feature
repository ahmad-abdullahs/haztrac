# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@modules @Quotes @Leads
Feature: Quotes module mass update verification
  As a Sugar user, I need to be able to mass update Quote records

  Background:
    Given I am logged in

  @quotes_mass_updates @e2e
  Scenario: Quotes > List View > Mass Update > Cancel
    Given Quotes records exist:
      | *name | date_quote_expected_closed | quote_stage | payment_terms |
      | Q_1   | 2020-10-19T19:20:22+00:00  | On Hold     | Net 15        |
      | Q_2   | 2020-10-20T19:20:22+00:00  | Delivered   | Net 30        |

    # Cancel Mass Update
    When I cancel mass update of all Quotes with the following values:
      | fieldName                  | value           |
      | quote_stage                | Closed Accepted |
      | date_quote_expected_closed | 12/31/2020      |

    # Verify that selected fields are not updated for *Q_1 record
    Then Quotes *Q_1 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/19/2020 |
      | quote_stage                | On Hold    |

    # Verify that selected fields are not updated for *Q_2 record
    And Quotes *Q_2 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/20/2020 |
      | quote_stage                | Delivered  |


  @quotes_mass_updates @e2e
  Scenario: Quotes > List View > Mass Update > All Records
    Given Quotes records exist:
      | *name | date_quote_expected_closed | quote_stage | payment_terms |
      | Q_1   | 2020-10-19T19:20:22+00:00  | On Hold     | Net 15        |
      | Q_2   | 2020-10-19T19:20:22+00:00  | Delivered   | Net 30        |
      | Q_3   | 2020-10-19T19:20:22+00:00  | Confirmed   | Net 15        |
    And Accounts records exist:
      | *name       |
      | New Account |

    # Perform Mass Update
    When I perform mass update of all Quotes with the following values:
      | fieldName                  | value           |
      | quote_stage                | Closed Accepted |
      | date_quote_expected_closed | 12/31/2020      |
      | shipping_account_name      | New Account     |

   # Verify that selected fields are updated for *Q_1 record
    Then Quotes *Q_1 should have the following values:
      | fieldName                  | value           |
      | date_quote_expected_closed | 12/31/2020      |
      | quote_stage                | Closed Accepted |
      | shipping_account_name      | New Account     |

   # Verify that selected fields are updated for *Q_2 record
    And Quotes *Q_2 should have the following values:
      | fieldName                  | value           |
      | date_quote_expected_closed | 12/31/2020      |
      | quote_stage                | Closed Accepted |
      | shipping_account_name      | New Account     |

   # Verify that selected fields are updated for *Q_3 record
    And Quotes *Q_3 should have the following values:
      | fieldName                  | value           |
      | date_quote_expected_closed | 12/31/2020      |
      | quote_stage                | Closed Accepted |
      | shipping_account_name      | New Account     |


  @quotes_mass_updates @e2e
  Scenario: Quotes > List View > Mass Update > Selected Records
    Given Quotes records exist:
      | *name | date_quote_expected_closed | quote_stage | payment_terms |
      | Q_1   | 2020-10-18T19:20:22+00:00  | On Hold     | Net 15        |
      | Q_2   | 2020-10-19T19:20:22+00:00  | Delivered   | Net 30        |
      | Q_3   | 2020-10-20T19:20:22+00:00  | Confirmed   | Net 15        |
      | Q_4   | 2020-10-21T19:20:22+00:00  | Closed Lost | Net 30        |
    And Accounts records exist:
      | *name       |
      | New Account |

    # Perform Mass Update
    When I perform mass update of Quotes [*Q_1, *Q_2, *Q_4] with the following values:
      | fieldName                  | value           |
      | quote_stage                | Closed Accepted |
      | date_quote_expected_closed | 12/31/2020      |
      | billing_account_name       | New Account     |

    # Verify that selected fields are updated for *Q_1 record
    Then Quotes *Q_1 should have the following values:
      | fieldName                  | value           |
      | date_quote_expected_closed | 12/31/2020      |
      | quote_stage                | Closed Accepted |
      | billing_account_name       | New Account     |

    # Verify that selected fields are updated for *Q_2 record
    And Quotes *Q_2 should have the following values:
      | fieldName                  | value           |
      | date_quote_expected_closed | 12/31/2020      |
      | quote_stage                | Closed Accepted |
      | billing_account_name       | New Account     |

    # Verify that selected fields are NOT !!! updated for *Q_3 record
    And Quotes *Q_3 should have the following values:
      | fieldName                  | value      |
      | date_quote_expected_closed | 10/20/2020 |
      | quote_stage                | Confirmed  |
      | billing_account_name       |            |

    # Verify that selected fields are updated for *Q_4 record
    And Quotes *Q_4 should have the following values:
      | fieldName                  | value           |
      | date_quote_expected_closed | 12/31/2020      |
      | quote_stage                | Closed Accepted |
      | billing_account_name       | New Account     |


  @leads_mass_updates @e2e
  Scenario: Leads > List View > Mass Update > All Records
    Given Leads records exist:
      | *   | first_name | last_name | account_name  | title             | email                             |
      | L_1 | lead1      | lead1     | Lead1 Account | Software Engineer | lead1.sugar@example.org (primary) |
      | L_2 | lead2      | lead2     | Lead2 Account | Software Engineer | lead2.sugar@example.org (primary  |
    Given Teams records exist:
      | *name |
      | East  |

    # Perform Mass Update
    When I perform mass update of all Leads with the following values:
      | fieldName   | value    |
      | status      | Assigned |
      | lead_source | Employee |
      | team_name   | East     |

    # Verify that selected fields are updated for *L_1 record
    Then Leads *L_1 should have the following values:
      | fieldName   | value                        |
      | status      | Assigned                     |
      | lead_source | Employee                     |
      | team_name   | Administrator,East (Primary) |

    # Verify that selected fields are updated for *L_2 record
    And Leads *L_2 should have the following values:
      | fieldName   | value                        |
      | status      | Assigned                     |
      | lead_source | Employee                     |
      | team_name   | Administrator,East (Primary) |

  @contacts_mass_updates @e2e
  Scenario: Contacts > List View > Mass Update > Selected Records
    And Contacts records exist:
      | *   | first_name | last_name |
      | C_1 | Bill       | Clinton   |
      | C_2 | George     | Bush      |
      | C_3 | Barak      | Obama     |
      | C_4 | Donald     | Trump     |

    And Accounts records exist:
      | *name       |
      | New Account |

    # Perform Mass Update
    When I perform mass update of Contacts [*C_1, *C_2, *C_4] with the following values:
      | fieldName    | value       |
      | account_name | New Account |

    # Verify that selected fields are updated for *C_1 record
    Then Contacts *C_1 should have the following values:
      | fieldName    | value       |
      | account_name | New Account |

       # Verify that selected fields are updated for *C_1 record
    Then Contacts *C_2 should have the following values:
      | fieldName    | value       |
      | account_name | New Account |

        # Verify that selected fields are updated for *C_1 record
    Then Contacts *C_3 should have the following values:
      | fieldName    | value |
      | account_name |       |

        # Verify that selected fields are updated for *C_1 record
    Then Contacts *C_4 should have the following values:
      | fieldName    | value       |
      | account_name | New Account |

  @rli_mass_updates @e2e
  Scenario: RevenueLineItems > List View > Mass Update > All
    Given RevenueLineItems records exist:
      | *name | date_closed               | likely_case | best_case | sales_stage | quantity |
      | RLI_1 | 2020-10-19T19:20:22+00:00 | 100         | 150       | Prospecting | 1        |
      | RLI_2 | 2020-10-19T19:20:22+00:00 | 200         | 250       | Prospecting | 2        |
      | RLI_3 | 2020-10-19T19:20:22+00:00 | 300         | 350       | Prospecting | 3        |
    And Opportunities records exist:
      | *name |
      | Opp_1 |
    And Accounts records exist related via accounts link to *Opp_1:
      | *name       |
      | New Account |

    # Perform Mass Update
    When I perform mass update of all RevenueLineItems with the following values:
      | fieldName        | value |
      | opportunity_name | Opp_1 |

    # Verify that selected fields are updated for *RLI_1 record
    Then RevenueLineItems *RLI_1 should have the following values:
      | fieldName        | value       |
      | opportunity_name | Opp_1       |
      | account_name     | New Account |

    # Verify that selected fields are updated for *RLI_2 record
    Then RevenueLineItems *RLI_2 should have the following values:
      | fieldName        | value       |
      | opportunity_name | Opp_1       |
      | account_name     | New Account |

    # Verify that selected fields are updated for *RLI_3 record
    Then RevenueLineItems *RLI_3 should have the following values:
      | fieldName        | value       |
      | opportunity_name | Opp_1       |
      | account_name     | New Account |
