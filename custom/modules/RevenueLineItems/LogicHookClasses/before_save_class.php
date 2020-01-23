<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    function before_save_method($bean, $event, $arguments) {
        // If RLI is going to be created for the first time set the rli_as_template_c to 0.
        // In case of update do nothing...
        if (!isset($bean->fetched_row['id'])) {
            //new record
            $bean->rli_as_template_c = 0;
        }

        if (isset($_REQUEST['__sugar_url'])) {
            $requestURL = explode('/', $_REQUEST['__sugar_url']);

            if ($requestURL[1] == 'Accounts' && empty($requestURL[4])) { // 1. Means RLI is created in Accounts along with Account creation and then linked to Account
                $bean->rli_as_template_c = 1;
            } else if ($requestURL[1] == 'Accounts' && $requestURL[4] == 'revenuelineitems') { // 2. Means RLI is created in Accounts through the subpanel create button
                $bean->rli_as_template_c = 1;
            } else if (isset($_REQUEST['addToParam']) && is_array($_REQUEST['addToParam'])) { // 3. Means RLI is copied in Accounts through the subpanel copy button
                if ($_REQUEST['addToParam']['copy_from_account'] == true) {
                    $bean->rli_as_template_c = 1;
                }
            }
            // 4. Means RLI is created in Opportunity along with Opportunity creation and linked to Account
            if ($requestURL[1] == 'Opportunities' && empty($requestURL[4])) {
                $bean->rli_as_template_c = 1;
            } else if ($requestURL[1] == 'Opportunities' && $requestURL[4] == 'revenuelineitems') { // 2. Means RLI is created in Opportunities through the subpanel create button
                $bean->rli_as_template_c = 1;
            } else if (isset($_REQUEST['addToParam']) && is_array($_REQUEST['addToParam'])) { // 3. Means RLI is copied in Opportunities through the subpanel copy button
                if ($_REQUEST['addToParam']['copy_from_opp'] == true) {
                    $bean->rli_as_template_c = 1;
                }
            }
        }
    }

}
