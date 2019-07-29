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
 * Upgrade existing report schedules.
 */
class SugarUpgradePopulateReportSchedules extends UpgradeScript
{
    public $order = 9901;
    public $type = self::UPGRADE_DB;

    /**
     *
     * Execute upgrade tasks
     * @see UpgradeScript::run()
     */
    public function run()
    {
        if (version_compare($this->from_version, '8.1.0', '>=')) {
            // do nothing if upgrading from 8.1.0 or newer
            return;
        }
        $this->log("Upgrading report schedules");
        $sql = 'SELECT rs.id, rs.user_id, u.user_name, rs.date_modified, sr.name as report_name, t.id as team_id, ts.id as team_set_id
                FROM report_schedules rs
                LEFT JOIN users u on rs.user_id = u.id
                LEFT JOIN saved_reports sr on sr.id = rs.report_id
                LEFT JOIN teams t on t.associated_user_id = rs.user_id
                LEFT JOIN team_sets ts on ts.id = t.id
                WHERE rs.schedule_type = \'pro\' and rs.deleted = 0';
        $q = $this->db->query($sql);
        while ($row = $this->db->fetchByAssoc($q, false)) {
            // in some rare cases, teamset may not exist, eg, a demo user in fresh install
            if (empty($row['team_set_id'])) {
                $teamset = new TeamSet();
                $team_set_id = $teamset->addTeams($row['team_id']);
                $this->log('Created teamset: ' . $team_set_id . ' for team: ' . $row['team_id']);
            } else {
                $team_set_id = $row['team_set_id'];
            }
            $update = sprintf(
                "UPDATE report_schedules
                 SET name = %s, assigned_user_id = %s, modified_user_id = %s, created_by = %s, team_id = %s, team_set_id = %s, date_entered = %s
                 WHERE id = %s",
                $this->db->quoted($row['report_name'] . ' - Scheduled for : ' . $row['user_name']),
                $this->db->quoted($row['user_id']),
                $this->db->quoted($row['user_id']),
                $this->db->quoted($row['user_id']),
                $this->db->quoted($row['team_id']),
                $this->db->quoted($team_set_id),
                $this->db->quoted($row['date_modified']),
                $this->db->quoted($row['id'])
            );
            $this->db->query($update);
            // link user
            $insert = sprintf(
                "INSERT INTO reportschedules_users VALUES (%s, %s, %s, %s, %s)",
                $this->db->quoted(create_guid()),
                $this->db->quoted($row['id']),
                $this->db->quoted($row['user_id']),
                $this->db->quoted($row['date_modified']),
                0
            );
            $this->db->query($insert);
        }
        $sql = 'SELECT count(*) FROM report_schedules WHERE name IS NOT NULL';
        $count = $this->db->getOne($sql);
        $this->log("Number of report schedules upgraded = $count");
    }
}
