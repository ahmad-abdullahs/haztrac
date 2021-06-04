<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once 'custom/modules/LR_Lab_Reports/HookHandlers/LR_Lab_ReportsRelationshipHooks.php';

class HT_ManifestRelationshipHooks {

    function after_save($bean, $event, $arguments) {
        if (!empty($arguments['dataChanges']['rli_galon_total'])) {
            global $db;
            if ($bean->load_relationship('ht_manifest_lr_lab_reports_1')) {
                $LR_Lab_ReportsRelationshipHooks = new LR_Lab_ReportsRelationshipHooks();
                $relatedLabReports = $bean->ht_manifest_lr_lab_reports_1->getBeans(array(), array('disable_row_level_security' => true));
                foreach ($relatedLabReports as $labReportBean) {
                    $labReportBean->manifest_galon_total = $LR_Lab_ReportsRelationshipHooks->recalculateManifestGalonTotal($labReportBean);
                    $updateQuery = "UPDATE lr_lab_reports 
                    SET 
                        manifest_galon_total = '{$labReportBean->manifest_galon_total}'
                    WHERE
                        id = '{$labReportBean->id}'";
                    $db->query($updateQuery);
                }
            } else {
                $GLOBALS['log']->fatal('Relationship is not loaded.');
            }
        }
    }

    function before_save($bean, $event, $arguments) {
        if (!empty($bean->link_lr_lab_report_id)) {
            // Add relationship
            if ($bean->load_relationship('ht_manifest_lr_lab_reports_1')) {
                $bean->ht_manifest_lr_lab_reports_1->add($bean->link_lr_lab_report_id);
            }
        }
        $bean->link_lr_lab_report_id = '';
    }

}
