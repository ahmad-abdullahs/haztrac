<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class Teams_before_save_class {

    function before_save_method($bean, $event, $arguments) {
        if (isset($_REQUEST['team_printer_setting'])) {
            if (!empty($_REQUEST['team_printer_setting'][0])) {
                $printerSettings = array();
                foreach ($_REQUEST['team_printer_setting'][0]['pdf_template_type'] as $key => $val) {
                    if (!empty($val)) {
                        array_push($printerSettings, array(
                            "pdf_template_type" => $val,
                            "pdf_printer" => $_REQUEST['team_printer_setting'][0]['pdf_printer'][$key],
                        ));
                    }
                }

                $printerSettingsJson = json_encode($printerSettings);
                $bean->printer_setting = $printerSettingsJson;
            } else {
                $bean->printer_setting = '';
            }
        }
    }

}
