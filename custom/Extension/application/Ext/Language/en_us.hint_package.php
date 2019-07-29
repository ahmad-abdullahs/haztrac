<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * App Config
 */
$app_list_strings['moduleList']['HintAccountsets'] = 'HintAccountsets';
$app_list_strings['moduleList']['HintNotificationTargets'] = 'HintNotificationTargets';

/**
 * Select2 field values
 */
$app_list_strings['stage2_preferences_type'] = [
    'owner' => 'My Accounts',
    'favorites' => 'Favorite Accounts',
    'tags' => 'Accounts tagged'
];

$app_list_strings['stage2_preferences_category'] = [
    'All' => 'All News',
    'General' => 'General',
    'Finance' => 'Financial',
    'People' => 'Personnel',
    'Press Releases' => 'Press Releases',
    'Other' => 'Other'
];

/**
 * Standard Translations
 */
$app_strings['LBL_HINT_COMPANY_SIZE'] = 'Company Size';
$app_strings['LBL_HINT_COMPANY_INDUSTRY'] = 'Industry';
$app_strings['LBL_HINT_COMPANY_INDUSTRY_TAGS'] = 'Industry Tags';
$app_strings['LBL_HINT_COMPANY_LOCATION'] = 'Company Location';
$app_strings['LBL_HINT_COMPANY_DESCRIPTION'] = 'Company Description';
$app_strings['LBL_HINT_COMPANY_FOUNDED_YEAR'] = 'Year Founded';
$app_strings['LBL_HINT_COMPANY_FACEBOOK'] = 'Company Facebook';
$app_strings['LBL_HINT_COMPANY_TWITTER'] = 'Company Twitter';
$app_strings['LBL_HINT_COMPANY_LOGO'] = 'Company Logo Link';
$app_strings['LBL_HINT_COMPANY_WEBSITE'] = 'Company Website';
$app_strings['LBL_HINT_PHOTO'] = 'Photo Link';
$app_strings['LBL_HINT_JOB_2'] = 'Previous Jobs';
$app_strings['LBL_HINT_EDUCATION'] = 'Education';
$app_strings['LBL_HINT_EDUCATION_2'] = 'Education Additional';
$app_strings['LBL_HINT_TWITTER'] = 'Twitter Link';
$app_strings['LBL_HINT_FACEBOOK'] = 'Facebook Link';
$app_strings['LBL_HINT_COMPANY_NAICS_CODE_LABEL'] = 'NAICS Code';
$app_strings['LBL_HINT_COMPANY_SIC_CODE_LABEL'] = 'SIC Code';
$app_strings['LBL_HINT_COMPANY_FISCAL_YEAR_END'] = 'FY End';
$app_strings['LBL_HINT_COMPANY_ANNUAL_REVENUE'] = 'Annual Rev';
$app_strings['LBL_HINT_PHONE_1'] = 'Phone 1';
$app_strings['LBL_HINT_PHONE_2'] = 'Phone 2';
$app_strings['LBL_HINT_PANEL'] = 'Hint';
$app_strings['LBL_HINT_JOIN_TABLE'] = 'Join table';
$app_strings['LBL_HINT_COMPANY_WEBSITE'] = 'Company Website';
$app_strings['LBL_HINT_FULL_NAME'] = 'Full Name';
$app_strings['LBL_HINT_JOB_TITLE'] = 'Job Title';

$app_strings['LBL_HINT_LOADING'] = 'Loading ...';
$app_strings['LBL_HINT_VALUE_ERASED'] = ' Value Erased ';
$app_strings['LBL_HINT_VALUE_ERASED_TOOLTIP'] = 'This information was erased via data privacy request';

$app_strings['LBL_HINT_CONFIG_TITLE'] = 'Hint Layout';
$app_strings['LBL_HINT_CONFIG_BASIC_PREVIEW'] = 'Basic layout preview';
$app_strings['LBL_HINT_CONFIG_TAB_ACCOUNTS'] = 'Accounts';
$app_strings['LBL_HINT_CONFIG_TAB_CONTACTS'] = 'Contacts';
$app_strings['LBL_HINT_CONFIG_TAB_LEADS'] = 'Leads';
$app_strings['LBL_HINT_CONFIG_EXPANDED_PREVIEW'] = 'Expanded layout preview';
$app_strings['LBL_HINT_CONFIG_DIRECTIONS'] = 'Directions';
$app_strings['LBL_HINT_CONFIG_DIR_PAR1'] = 'To configure default fields to be displayed for the hint ';
$app_strings['LBL_HINT_CONFIG_DIR_PAR2'] = 'Add or delete fields from field selector.';
$app_strings['LBL_HINT_CONFIG_DIR_PAR3'] = 'Rearrange field order by dragging and dropping.';
$app_strings['LBL_HINT_CONFIG_DIR_PAR4A'] = 'The default basic layout fields are: Size, Industry, Location, Annual Revenue, Description';
$app_strings['LBL_HINT_CONFIG_DIR_PAR5A'] = 'The default expanded layout fields are: NAICS Code, SIC Code, FY End, Year Founded, Company Facebook, Company Twitter, Industry Tags';
$app_strings['LBL_HINT_CONFIG_DIR_PAR4B'] = 'The default basic layout fields are: Office Phone, Email';
$app_strings['LBL_HINT_CONFIG_DIR_PAR5B'] = 'The default expanded layout fields are: Education, Previous Jobs, Facebook Link, Twitter Link';
$app_strings['LBL_HINT_CONFIG_RESTORE_TEXT'] = 'Restore default fields using this link: ';
$app_strings['LBL_HINT_CONFIG_RESTORE_BUTTON'] = 'Restore Defaults';
$app_strings['LBL_HINT_CONFIG_FIELD_SELECTOR'] = 'Field Selector';
$app_strings['LBL_HINT_RESYNC_NOTIFICATION_TITLE'] = 'Warning';
$app_strings['LBL_HINT_RESYNC_NOTIFICATION_DESCRIPTION'] = 'Caution: You are about to sync with the Hint Insights service. Any pending email digest stories will be lost, and existing news will be cleared from the Insights dashlet. Notifications of all types will resume after the sync completes.';

$app_strings['LBL_HINT_ACCOUNT_CHANGE_TITLE'] = 'Suggested companies related to your {{_moduleSingular}} are listed below. Select company data to display.';
$app_strings['LBL_HINT_NO_ACCOUNT_SELECTED'] = 'No account is selected';

$app_strings['LBL_HINT_EMAIL_IMPORT_TITLE'] = 'Multiple emails found, select emails to import: ';

$app_strings['LBL_HINT_HELP_MESSAGE1'] = 'Based on the data entered, hint was not able to find a match in the system.';
$app_strings['LBL_HINT_HELP_MESSAGE2'] = 'Best results in hint can be found with a person\'s name and email address.';
$app_strings['LBL_HINT_HELP_MESSAGE3'] = 'Best results in hint can be found with the company website url.';
$app_strings['LBL_HINT_HELP_DEFAULT_MESSAGE1A'] = "Enter your {{_moduleSingular}}'s company name and website and hint will search for additional data.";
$app_strings['LBL_HINT_HELP_DEFAULT_MESSAGE1B'] = "Enter your {{_moduleSingular}}'s name and email address and hint will search for additional data.";

$app_strings['LBL_HINT_HISTORY_NONE'] = 'No data available for historical view';
$app_strings['LBL_HINT_HISTORY_TITLE'] = 'Activity History';

$app_strings['LBL_HINT_PREVIEW_TITLE'] = 'Data enrichment';
$app_strings['LBL_HINT_PREVIEW_LICENSE_EXPIRED'] = 'The license for your SugarCRM Hint service has expired. Contact your SugarCRM admin to renew your license.';
$app_strings['LBL_HINT_PREVIEW_QUESTION'] = 'Want to see what SugarCRM Hint can do for you and your company? Contact your SugarCRM admin to add Hint.';
$app_strings['LBL_HINT_PREVIEW_NO_ACCOUNT_INFO'] = 'Account infomation not found';
$app_strings['LBL_HINT_PREVIEW_TOOLTIP_TITLE'] = 'Enriched data found - click to save all enriched data to your record.';
$app_strings['LBL_HINT_PREVIEW_CLICK_TO_SAVE'] = 'Click to save enriched data to your record.';

$app_strings['LBL_HINT_CONTACTS_TITLE'] = 'Related Contacts';
$app_strings['LBL_HINT_CONTACTS_NONE'] = 'No related contacts';

$app_strings['LBL_HINT_NEWS'] = 'News';
$app_strings['LBL_HINT_GENERAL'] = 'General';
$app_strings['LBL_HINT_ALL_NEWS'] = 'All News';
$app_strings['LBL_HINT_FILTER_NEWS'] = 'Filter News';
$app_strings['LBL_HINT_FINANCIAL_NEWS'] = 'Financial';
$app_strings['LBL_HINT_PERSONNEL_NEWS'] = 'Personnel';
$app_strings['LBL_HINT_PRESS_RELEASES'] = 'Press Releases';
$app_strings['LBL_HINT_OTHER_NEWS'] = 'Other';
$app_strings['LBL_HINT_NEWS_PLACEHOLDER'] = 'Search news articles';
$app_strings['LBL_HINT_NEWS_ALERT'] = 'Hint Insights';
$app_strings['LBL_HINT_NEWS_NONE'] = 'No news available';
$app_strings['LBL_NEW_NOTIFICATIONS'] = 'New notifications';

$app_strings['LBL_HINT_FOR'] = 'For';
$app_strings['LBL_HINT_WITH'] = 'with';
$app_strings['LBL_HINT_SHOW_ME'] = 'Show me: ';
$app_strings['LBL_HINT_NOTIFY_ME_BY'] = 'Notify me by: ';

$app_strings['LBL_NOTIFICATIONS_TITLE'] = 'Hint Insights Preference Center';
$app_strings['LBL_NOTIFICATIONS_KEY_TITLE'] = 'Preference Option Key';
$app_strings['LBL_HINT_PREFERENCES'] = 'Preferences';
$app_strings['LBL_HINT_MINIMUM_PREFERENCES'] = 'Delete disabled, minimum of one preference statement required';
$app_strings['LBL_HINT_MAXIMUM_PREFERENCES'] = 'Add disabled, you have reached maximum of preference statements';

$app_strings['LBL_NOTIFICATIONS_KEY_TITLE_DASHLET'] = 'Include in Hint Insights dashlet';
$app_strings['LBL_NOTIFICATIONS_KEY_TITLE_BROWSER'] = 'Pop-up as desktop notification';
$app_strings['LBL_NOTIFICATIONS_KEY_DESCR_BROWSER'] = 'Notifications must be enabled on all browsers and on all desktop computers to consistently receive notifications.';
$app_strings['LBL_NOTIFICATIONS_KEY_DESCR_BROWSER_DISABLED'] = 'Some browsers, like Internet Explorer, do not support notifications. Notifications cannot be enabled when using a browser that does not support notifications.';
$app_strings['LBL_NOTIFICATIONS_KEY_TITLE_EMAIL'] = 'Send instant email alert for each notification';
$app_strings['LBL_NOTIFICATIONS_KEY_TITLE_DAILY'] = 'Send a daily email digest';
$app_strings['LBL_NOTIFICATIONS_KEY_TITLE_WEEKLY'] = 'Send a weekly email digest';

$app_strings['LBL_NOTIFICATIONS_ERROR_MESSAGE_FAILEDSYNC'] = 'Preferences could not be saved. Check your system connection and try again.';
$app_strings['LBL_NOTIFICATIONS_ERROR_MESSAGE_MISSING_REQUIRED'] = 'Some required fields are missing a value. Please check your preferences and ensure that all required fields are filled in.';

$app_strings['LBL_HINT_PUSH_MESSAGES_PERMISSION'] = 'You are about to enable browser notifications for Hint Insights. Click Confirm to proceed. Your browser will then ask you for permission to allow receiving notification events.';
$app_strings['LBL_HINT_PUSH_ERROR'] = 'Push Notifications plugin has been registered for {{options.type}} without its dependencies. The plugin will not work as intended, please be sure that you provide a path to the worker file and a method for saving the subscription on the server.';
