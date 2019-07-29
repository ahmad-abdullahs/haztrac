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
 * Class to fix old style report defs during upgrade
 */
class SugarUpgradeUpdateReportDef extends UpgradeScript
{
    public $order = 9100;
    public $type = self::UPGRADE_CUSTOM;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (version_compare($this->from_version, '7.10.0.0', '<')) {
            $this->updateReports();
        }
    }

    /**
     *
     * Get all the reports, update the report def and save
     */
    public function updateReports()
    {
        $sql = 'SELECT id, name, content FROM saved_reports WHERE deleted = 0';
        $q = $this->db->query($sql);
        while ($row = $this->db->fetchByAssoc($q, false)) {
            // Running through the Report constructor sanitizes the report def
            $oldContent = $row['content'];
            $report = new Report($oldContent);

            // No need to save if there aren't any changes
            if ($oldContent === $report->report_def_str) {
                continue;
            }

            $update = sprintf(
                "UPDATE saved_reports SET content = %s WHERE id = %s",
                $this->db->quoted($report->report_def_str),
                $this->db->quoted($row['id'])
            );
            $this->db->query($update);
            $this->log('Updated report definition for Report: ' . $row['name']);
        }
    }
}
