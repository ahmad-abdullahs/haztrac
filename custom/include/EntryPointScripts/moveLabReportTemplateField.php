<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=moveLabReportTemplateField

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class moveLabReportTemplateField {

    public function __construct() {
        $this->execute();
    }

    private function execute() {
        global $db;
        $ids = array();

        $selectLabReportTemplates = "SELECT 
            id,
            lr_lab_repd2cdmplates_ida,
            lr_lab_reports_templates_lr_lab_reports_1lr_lab_reports_idb
        FROM
            lr_lab_reports_templates_lr_lab_reports_1_c
        WHERE
            lr_lab_reports_templates_lr_lab_reports_1lr_lab_reports_idb IN (SELECT 
                    id
                FROM
                    lr_lab_reports
                WHERE
                    deleted = 0)
                AND deleted = 0
        ORDER BY lr_lab_repd2cdmplates_ida;";

        $result = $db->query($selectLabReportTemplates);
        while ($row = $db->fetchByAssoc($result)) {
            $updateQuery = "UPDATE lr_lab_reports 
                        SET 
                            lr_lab_reports_analysis_templates = '^{$row['lr_lab_repd2cdmplates_ida']}^'
                        WHERE
                            id = '{$row['lr_lab_reports_templates_lr_lab_reports_1lr_lab_reports_idb']}';";
            $db->query($updateQuery);
            echo $updateQuery . "</br>";
        }
    }

}

$init = new moveLabReportTemplateField();
echo '<br>';
echo 'Script Executed!!';
echo '<br>';
