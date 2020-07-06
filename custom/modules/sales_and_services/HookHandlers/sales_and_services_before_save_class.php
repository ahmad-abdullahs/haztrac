<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class sales_and_services_before_save_class {

    function before_save_method($bean, $event, $arguments) {
        global $db, $timedate;
        // If user puts the S&S staus to Pending clean out the pdf_template_printer_widget field
        // and delete all the linked queue_workorder records.
        if ($bean->print_status_c != $bean->fetched_row['print_status_c'] && $bean->print_status_c == "Pending") {
            $bean->pdf_template_printer_widget = "";

            $sql = <<<SQL
                    SELECT 
                    queue_workorder.id AS id
                FROM
                    queue_workorder
                        LEFT JOIN
                    sales_and_services_queue_workorder_1_c ON queue_workorder.id = sales_and_services_queue_workorder_1_c.sales_and_services_queue_workorder_1queue_workorder_idb
                WHERE
                    sales_and_services_queue_workorder_1sales_and_services_ida = '{$bean->id}'
                        AND queue_workorder.deleted = 0
                        AND sales_and_services_queue_workorder_1_c.deleted = 0;
SQL;
            $res = $db->query($sql);
            while ($row = $db->fetchByAssoc($res)) {
                $queue_workorderBean = BeanFactory::retrieveBean('queue_workorder', $row['id'], array(
                            'disable_row_level_security' => true
                ));
                if (!empty($queue_workorderBean->id)) {
                    // Delete the record
                    $queue_workorderBean->mark_deleted($queue_workorderBean->id);
                    $queue_workorderBean->save();
                }
            }
        }

        // Update the Account Terms field for future transactions if sales and service account terms are changes
        // update these terms in accounts if you gives the confirmation ...
        if ($bean->allowAccountTermsUpdate == true || $bean->allowAccountTermsUpdate == 1) {
            if (!empty($bean->accounts_sales_and_services_1accounts_ida)) {
                $sql = "UPDATE accounts_cstm 
                    SET 
                        account_terms_c = '{$bean->account_terms_c}'
                    WHERE
                        id_c = '{$bean->accounts_sales_and_services_1accounts_ida}'";
                $db->query($sql);
            }
        }
    }

}
