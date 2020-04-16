<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class handlePrinterQueue extends SugarApi {

    public function registerApiRest() {
        return array(
            'handlePrinterQueueDecleration' => array(
                //request type
                'reqType' => 'POST',
                //endpoint path
                'path' => array('sales_and_services', '?', 'handlePrinterQueueRoute'),
                //endpoint variables
                'pathVars' => array('module', 'record', 'action'),
                //method to call
                'method' => 'handlePrinterQueueMethod',
                'jsonParams' => array(),
                //short help string to be displayed in the help documentation
                'shortHelp' => '',
            ),
            'SubmitToPrinterDecleration' => array(
                //request type
                'reqType' => 'POST',
                //endpoint path
                'path' => array('sales_and_services', '?', 'SubmitToPrinter'),
                //endpoint variables
                'pathVars' => array('module', 'record', 'action'),
                //method to call
                'method' => 'SubmitToPrinterMethod',
                'jsonParams' => array(),
                //short help string to be displayed in the help documentation
                'shortHelp' => '',
            ),
        );
    }

    public function SubmitToPrinterMethod(ServiceBase $api, array $args) {
        // Call the handlePrinterQueueMethod, because user might have not clicked the print Queue before
        // So we need to create the workorder items first and then the manifest stuff...
        global $timedate;
        $args['print_status_c'] = 'Printed';
        $args['print_date'] = $timedate->nowDbDate();
        if ($this->handlePrinterQueueMethod($api, $args)) {
            $parentId = $args['modelId'];
            $isManifestRequired = $args['isManifestRequired'];
            $on_fly_manifest_name = $args['fields']['on_fly_manifest_name'];
            $on_fly_manifest_id = $args['fields']['on_fly_manifest_id'];
            $on_fly_manifest_number = $args['fields']['on_fly_manifest_number'];
            $primaryTeamId = $args['fields']['primaryTeamId'];

//            $sAndSBean = BeanFactory::retrieveBean('sales_and_services', $parentId);
//            if ($sAndSBean) {
//                // Set the print Status ...
//                $sAndSBean->print_status_c = 'Printed';
//                $sAndSBean->save();
//            }

            if ($isManifestRequired) {
                // Get the primary team and update the manifest number...
                $teamBean = BeanFactory::retrieveBean('Teams', $primaryTeamId);
                // Remove the 3 alphabets from the end of the string.
                $str = $on_fly_manifest_number;
                $str = substr($str, 0, strlen($str) - 3);
                $strPaddedLen = strlen($str);
                // Interment the numeric part by 1.
                $str = $str + 1;
                // Pad the pre zeros to keep the string length same
                $str = str_pad($str, $strPaddedLen, "0", STR_PAD_LEFT);
                // Concatenate back the alphabetic portion
                $str = $str . substr($on_fly_manifest_number, -3);

                $teamBean->active_manifest_number = $str;
                $teamBean->save();
            }

            return $str;
        }
    }

    public function handlePrinterQueueMethod(ServiceBase $api, array $args) {
        $parentId = $args['modelId'];
        $pdf_template_printer_widget = $args['fields']['pdf_template_printer_widget'];
        $pdf_template_printer_widget = json_decode(html_entity_decode($pdf_template_printer_widget), ENT_QUOTES);

        $printStatus = 'Queued';
        $printDate = '';
        if (!empty($args['print_status_c'])) {
            $printStatus = 'Printed';
        }
        if (!empty($args['print_date'])) {
            $printDate = $args['print_date'];
        }

        $sAndSBean = BeanFactory::retrieveBean('sales_and_services', $parentId);
        if ($sAndSBean) {
            // Update the Sales and Services record and then create the queue_workorder records
            // and link those records to S&S.
            $salesAndServiceName = $sAndSBean->name;
            $accountId = $sAndSBean->accounts_sales_and_services_1accounts_ida;

            $sAndSBean->pdf_template_printer_widget = $args['fields']['pdf_template_printer_widget'];
            $sAndSBean->print_status_c = $printStatus;
            // Set the print Status as well...
            $sAndSBean->save();

            // Remove all the existing ones before craeting the new ones...
            $this->removeTheExistingWorkOrders($parentId);

            foreach ($pdf_template_printer_widget as $pdf_template_printer_row) {
                $newID = create_guid();
                $pdfTemplateId = $pdf_template_printer_row['pdf_template_printer_widget_name_id'];
                $pdfTemplateName = $pdf_template_printer_row['pdf_template_printer_widget_name'];
                $printerName = $pdf_template_printer_row['pdf_template_printer_widget_printer'];
                $printQuantity = $pdf_template_printer_row['pdf_template_printer_widget_quantity'];
                $lineNumber = $pdf_template_printer_row['pdf_template_printer_widget_line_number'];
                $pdfTemplateType = $pdf_template_printer_row['pdf_template_printer_widget_pdf_template_type'];

                $queue_workorderBean = BeanFactory::newBean('queue_workorder');
                $queue_workorderBean->new_with_id = true;
                $queue_workorderBean->id = $newID;

                $queue_workorderBean->name = $pdfTemplateName . ' - ' . $printerName . ' - ' . $salesAndServiceName;
                $queue_workorderBean->sales_and_services_queue_workorder_1sales_and_services_ida = $parentId;
                $queue_workorderBean->account_id_c = $accountId;
                $queue_workorderBean->pdf_template_id = $pdfTemplateId;
                $queue_workorderBean->selected_printer = $printerName;
                $queue_workorderBean->quantity = $printQuantity;
                $queue_workorderBean->module_type = 'sales_and_services';
                $queue_workorderBean->print_status = $printStatus;
                $queue_workorderBean->print_date = $printDate;
                $queue_workorderBean->line_number = $lineNumber;
                $queue_workorderBean->pdf_template_type = $pdfTemplateType;

                $queue_workorderBean->assigned_user_id = 1;
                $queue_workorderBean->modified_user_id = 1;
                $queue_workorderBean->created_by = 1;
                $queue_workorderBean->team_id = 1;
                $queue_workorderBean->team_set_id = 1;

                $queue_workorderBean->save();
            }
            return true;
        }
        return false;
    }

    function removeTheExistingWorkOrders($parentId) {
        global $db;
        $workOrderIds = $this->getWorkOrderIds($parentId);
        if (!empty($workOrderIds)) {
            $query = "UPDATE queue_workorder SET deleted=1 WHERE id IN( '" . implode("','", $workOrderIds) . "' )";
            $db->query($query, true, "Deleting workorders");
        }
    }

    function getWorkOrderIds($parentId) {
        global $db;
        $workOrderIds = array();

        $sql = <<<SQL
            SELECT 
                sales_and_services_queue_workorder_1queue_workorder_idb
            FROM
                sales_and_services_queue_workorder_1_c
            WHERE
                sales_and_services_queue_workorder_1sales_and_services_ida = '$parentId'
                    AND deleted = 0;
SQL;

        $res = $db->query($sql);
        if ($res->num_rows > 0) {
            while ($row = $db->fetchByAssoc($res)) {
                array_push($workOrderIds, $row['sales_and_services_queue_workorder_1queue_workorder_idb']);
            }
        }

        return $workOrderIds;
    }

}
