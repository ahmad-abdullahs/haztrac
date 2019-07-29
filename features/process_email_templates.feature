# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
# Copyright (C) SugarCRM Inc. All rights reserved.

@modules @process_email_templates
Feature: pmse process email templates module verification.

Background:
      Given I am logged in
      And pmse_Emails_Templates records exist:
      | *name | base_module | assigned_user_id |
      | PET   | Accounts    | 1                |
      And I design pmse_Emails_Templates *PET

    @pet_add_field_placeholder @e2e
    Scenario Outline: Design a Process Email Template and add a placeholder for a field to the subject and content.
      When a placeholder is inserted in the subject *PET record from module <related_module_name>:
        | module   | field    | type   | related_module    |
        | <module> | <field>  | <type> | campaign_accounts |
      And a placeholder is inserted in the content *PET record from module <related_module_name>:
        | module   | field    | type   | related_module    |
        | <module> | <field>  | <type> | campaign_accounts |
      Then pmse_Emails_Templates *PET should have the values:
        | fieldName | value              |
        | subject   | <subject_result>   |
        | body_html | <body_html_result> |
      Examples:
       | module   | field   | type                   | subject_result                                                  | body_html_result                                                                    | related_module_name | related_module_content                         |
       | Accounts | website | Current Value          | {::Accounts::website::}                                         | <p>{::Accounts::website::}</p><p>&nbsp;</p>                                         | Accounts            |                                                |
       | Accounts | website | Old Value              | {::Accounts::website::old::}                                    | <p>{::Accounts::website::old::}</p><p>&nbsp;</p>                                    | Accounts            |                                                |
       | Accounts | website | Current and Old Values | {::Accounts::website::}{::Accounts::website::old::}             | <p>{::Accounts::website::}{::Accounts::website::old::}</p><p>&nbsp;</p>             | Accounts            |                                                |
       | Accounts | name    | Current Value          | {::campaign_accounts::name::}                                   | <p>{::campaign_accounts::name::}</p><p>&nbsp;</p>                                   | Campaigns           | Campaigns [*:1] (Campaigns: campaign_accounts) |
       | Accounts | name    | Old Value              | {::campaign_accounts::name::old::}                              | <p>{::campaign_accounts::name::old::}</p><p>&nbsp;</p>                              | Campaigns           | Campaigns [*:1] (Campaigns: campaign_accounts) |
       | Accounts | name    | Current and Old Values | {::campaign_accounts::name::}{::campaign_accounts::name::old::} | <p>{::campaign_accounts::name::}{::campaign_accounts::name::old::}</p><p>&nbsp;</p> | Campaigns           | Campaigns [*:1] (Campaigns: campaign_accounts) |

    @pet_add_link_placeholder @e2e
    Scenario Outline: Design a Process Email Template and add a placeholder for a link to the content.
      When a link placeholder is inserted in the content *PET record:
        | module_link   |
        | <module_link> |
      Then pmse_Emails_Templates *PET should have the values:
        | fieldName | value              |
        | body_html | <body_html_result> |
      Examples:
        | module_link                                    | body_html_result                                                       |
        | Accounts                                       | <p>{::href_link::Accounts::name::}</p><p>&nbsp;</p>                    |
        | Campaigns [*:1] (Campaigns: campaign_accounts) | <p>{::href_link::Accounts::campaign_accounts::name::}</p><p>&nbsp;</p> |
