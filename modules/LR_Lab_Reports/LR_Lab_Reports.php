<?PHP
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
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/LR_Lab_Reports/LR_Lab_Reports_sugar.php');
class LR_Lab_Reports extends LR_Lab_Reports_sugar {
    public function save($check_notify = false) {
        $ret = parent::save($check_notify);

        $this->updateTransporters();

        $this->setPreviewURL();

        return $ret;
    }

    private function updateTransporters() {
        global $db;

        $res = $db->query(
            "DELETE FROM ht_manifest_lr_lab_reports_1_c WHERE ht_manifest_lr_lab_reports_1lr_lab_reports_idb = '{$this->id}'");
        
        if (!empty($this->manifests)) {
            if (is_string($this->manifests)) {
                $this->manifests = json_decode($this->manifests, true);
            }

            if (!empty($this->manifests)) {
                $insertSQLs = array();
                foreach ($this->manifests as $manifests) {
                    $manifestId = $manifests['id'];

                    $insertSQLs[] =<<<SQL
                        SELECT
                            UUID() as 'id',
                            NOW() as 'date_modified',
                            '0' as 'deleted',
                            '{$this->id}' as 'ht_manifest_lr_lab_reports_1lr_lab_reports_idb',
                            '{$manifestId}' as 'ht_manifest_lr_lab_reports_1ht_manifest_ida'
SQL;
                }

                // preparing Insert SQL for relationships
                $insertSQL =<<<SQL
                    INSERT INTO ht_manifest_lr_lab_reports_1_c (
                        id,
                        date_modified,
                        deleted,
                        ht_manifest_lr_lab_reports_1lr_lab_reports_idb,
                        ht_manifest_lr_lab_reports_1ht_manifest_ida
                    )
SQL;
                $db->query($insertSQL . implode(' UNION ', $insertSQLs));
            }
        }
    }

    private function setPreviewURL() {
        $this->lab_report_preview_c = 'https://docs.google.com/viewer?url=https%3A%2F%2Fsugar.haztrac.com%2F%3FentryPoint%3DLab_Report_Preview%26report_id%3D' . $this->id . '&embedded=true&chrome=false&dov=1';

        $this->db->query("UPDATE {$this->table_name}_cstm SET lab_report_preview_c='$this->lab_report_preview_c' WHERE id_c='{$this->id}'");
    }
}