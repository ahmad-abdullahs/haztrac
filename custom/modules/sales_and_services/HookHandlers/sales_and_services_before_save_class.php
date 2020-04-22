<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class sales_and_services_before_save_class {

    function before_save_method($bean, $event, $arguments) {
        // If user puts the S&S staus to Pending clean out the pdf_template_printer_widget field
        // and delete all the linked queue_workorder records.
        if ($bean->print_status_c != $bean->fetched_row['print_status_c'] && $bean->print_status_c == "Pending") {
            $bean->pdf_template_printer_widget = "";

            global $db, $timedate;
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
    }

}
