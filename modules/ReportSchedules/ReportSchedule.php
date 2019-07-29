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
 * Class ReportSchedule
 */
class ReportSchedule extends Basic
{
    /**
     * @inheritdoc
     */
    public $module_name = 'ReportSchedules';

    /**
     * @inheritdoc
     */
    public $module_dir = 'ReportSchedules';

    /**
     * @inheritdoc
     */
    public $object_name = 'ReportSchedule';

    /**
     * @inheritdoc
     */
    public $table_name = 'report_schedules';

    /**
     * {@inheritDoc}
     * @see SugarBean::bean_implements()
     */
    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }

    /**
     * {@inheritDoc}
     * @see SugarBean::save($check_notify)
     */
    public function save($check_notify = false)
    {
        $this->schedule_type = 'pro';
        if (!empty($this->date_start)) {
            if ($this->isUpdate()) {
                // if either intrval or start date time changes
                if ($this->time_interval != $this->fetched_row['time_interval']
                    || $this->date_start != $this->fetched_row['date_start']) {
                    $this->next_run = $this->getNextRunDate($this->date_start, $this->time_interval);
                }
            } else {
                $this->next_run = $this->getNextRunDate($this->date_start, 0);
            }
        }
        return parent::save($check_notify);
    }

    /**
     * Add filter schedule_type = 'pro' to filter api.
     * {@inheritDoc}
     * @see SugarBean::fetchFromQuery($query, $fields, $options)
     */
    public function fetchFromQuery(SugarQuery $query, array $fields = array(), array $options = array())
    {
        $query->where()->equals('schedule_type', 'pro');
        return parent::fetchFromQuery($query, $fields, $options);
    }

    /**
     * Legacy code to save a schedule
     *
     * @param $id
     * @param $user_id
     * @param $report_id
     * @param $date_start
     * @param $interval
     * @param $active
     * @param $schedule_type
     * @return String
     *
     * TODO Remove once advanced scheduler is converted to sidecar
     */
    public function save_schedule($id, $user_id, $report_id, $date_start, $interval, $active, $schedule_type)
    {
        global $timedate;
        $origDateStart = $date_start;
        $date_modified = $timedate->nowDb();
        if (strlen(trim($origDateStart)) == 0) {
            $date_start_str = 'NULL';
        } else {
            $date_start_str = $this->db->quoted($origDateStart);
        }

        if (empty($id)) {
            $id = create_guid();

            if (empty($date_start)) {
                $date_start = $timedate->nowDb();
            }

            $next_run_date = $this->getNextRunDate($date_start, 0);

            $query = <<<QUERY
INSERT INTO {$this->table_name} (
    id, user_id, report_id, date_start, next_run, time_interval, active, date_modified, schedule_type
)
VALUES (
    {$this->db->quoted($id)},
    {$this->db->quoted($user_id)},
    {$this->db->quoted($report_id)},
    $date_start_str,
    {$this->db->quoted($next_run_date)},
    {$this->db->quoted($interval)},
    {$this->db->quoted($active)},
    {$this->db->quoted($date_modified)},
    {$this->db->quoted($schedule_type)}
)
QUERY;
        } else {
            $query = <<<QUERY
UPDATE
    $this->table_name
SET
    time_interval = {$this->db->quoted($interval)},
    date_start = $date_start_str,
    active = {$this->db->quoted($active)},
    date_modified = {$this->db->quoted($date_modified)},
    schedule_type = {$this->db->quoted($schedule_type)}
QUERY;
            if (!empty($date_start) && $active) {
                $next_run_date = $this->getNextRunDate($date_start, $interval);
                $query .= ", next_run = " . $this->db->quoted($next_run_date);
            }
            $query .= " WHERE id = " . $this->db->quoted($id);
        }
        $this->db->query($query, true, "error saving schedule");

        return $id;
    }

    /**
     * Get the datetime when the schedule will run next
     *
     * @param $date_start
     * @param $interval
     * @return string
     */
    public function getNextRunDate($date_start, $interval)
    {
        global $timedate;
        $time = time();

        $date_start = $timedate->fromDb($date_start)->ts;

        if ($interval > 0) {
            // Start Dates are not Respected for Scheduled Reports
            while ($date_start <= $time) {
                $date_start += $interval;
            }
        }

        return $timedate->fromTimestamp($date_start)->asDb();
    }

    /**
     * Converts datetime values from the database type
     * NOTE that this is currently hardcoded as this whole module should
     * be converted to using SugarBeans, which would make this obsolete
     * @param $row
     * @return converted row
     */
    protected function fromConvertReportScheduleDBRow($row)
    {
        if (!$row) {
            return false;
        }
        foreach ($row as $name => $value) {
            switch ($name) {
                case 'date_start':
                case 'next_run':
                case 'date_modified':
                    $row[$name] = $this->db->fromConvert($row[$name], 'datetime');
                    // no break
                default:
                    break;
            }
        }
        return $row;
    }

    /**
     * Get all schedules for a user
     *
     * @param string $id
     * @return array
     */
    public function get_users_schedule($id = '')
    {
        if (empty($id)) {
            global $current_user;
            $id = $current_user->id;
        }
        $return_array = array();
        $query = "SELECT * FROM $this->table_name WHERE user_id='$id'";
        $results = $this->db->query($query);
        while ($row = $this->db->fetchByAssoc($results)) {
            $return_array[$row['report_id']] = $this->fromConvertReportScheduleDBRow($row);
        }
        return $return_array;
    }

    /**
     * Get user's report schedule for specified report
     *
     * @param $report_id
     * @param string $user_id
     * @return converted
     */
    public function get_report_schedule_for_user($report_id, $user_id = '')
    {
        if (empty($user_id)) {
            global $current_user;
            $user_id = $current_user->id;
        }
        $query = sprintf(
            'SELECT * FROM %s WHERE report_id = %s AND user_id = %s AND deleted = 0',
            $this->table_name,
            $this->db->quoted($report_id),
            $this->db->quoted($user_id)
        );
        $results = $this->db->query($query);
        $row = $this->db->fetchByAssoc($results);
        return $this->fromConvertReportScheduleDBRow($row);
    }

    /**
     * Get all schedules for specified report
     *
     * @param $report_id
     * @return array
     * @deprecated
     */
    public function get_report_schedule($report_id)
    {
        $query = sprintf(
            'SELECT * FROM %s WHERE report_id = %s AND deleted = 0',
            $this->table_name,
            $this->db->quoted($report_id)
        );
        $results = $this->db->query($query);
        $return_array = array();
        while ($row = $this->db->fetchByAssoc($results)) {
            $return_array[] = $this->fromConvertReportScheduleDBRow($row);
        }
        return $return_array;
    }

    /**
     * Handles failed reports by deactivating them and sending email notifications to owner and subscribed user
     */
    public function handleFailedReports()
    {
        $schedules_to_deactivate = $this->getSchedulesToDeactivate();
        foreach ($schedules_to_deactivate as $schedule) {
            LoggerManager::getLogger()->info('Deactivating report schedule ' . $schedule['id']);
            $this->deactivate($schedule['id']);

            $owner = BeanFactory::retrieveBean('Users', $schedule['owner_id']);
            $scheduleId = $this->db->quoted($schedule['id']);
            $query = <<<QUERY
SELECT
    user_id
FROM
    reportschedules_users
WHERE
    reportschedule_id = $scheduleId AND deleted = 0
QUERY;
            $subscriber = array();
            $result = $this->db->query($query);
            while ($row = $this->db->fetchByAssoc($result)) {
                $subscriber[] = BeanFactory::retrieveBean('Users', $row['user_id']);
            }

            $utils = new ReportsUtilities();
            $utils->sendNotificationOfDisabledReport($schedule['report_id'], $owner, $subscriber, $schedule['name']);
        }
    }

    /**
     * Finds scheduled reports to be deactivated due to previous failure
     *
     * @return array
     */
    protected function getSchedulesToDeactivate()
    {
        $failure = SchedulersJob::JOB_FAILURE;

        $query = <<<QUERY
SELECT
    rs.id,
    rs.report_id,
    r.name,
    r.assigned_user_id owner_id
FROM
    $this->table_name rs
    INNER JOIN (
        SELECT DISTINCT jq.job_group report_id, jq.execute_time
        FROM job_queue jq
        INNER JOIN (
            SELECT
                max(execute_time) mt,
                job_group
            FROM job_queue
            WHERE target = 'class::SugarJobSendScheduledReport'
            GROUP BY job_group
        ) last
        ON last.mt = jq.execute_time AND last.job_group = jq.job_group
        WHERE resolution = '{$failure}'
    ) j
    ON j.report_id = rs.report_id AND j.execute_time > rs.date_modified
        INNER JOIN saved_reports r
        ON r.id = rs.report_id
WHERE
    r.deleted = 0
        AND rs.deleted = 0
        AND rs.active = 1
QUERY;

        $reports = array();
        $result = $this->db->query($query);
        while ($row = $this->db->fetchByAssoc($result)) {
            $reports[] = $row;
        }

        return $reports;
    }

    /**
     * @param string $userId
     * @param string $scheduleType
     * @return string
     */
    protected function getQuery($userId = '', $scheduleType = 'pro')
    {
        $timedate = TimeDate::getInstance();
        $where = '';
        if (!empty($userId)) {
            if ($scheduleType == 'pro') {
                $where = 'AND reportschedules_users.user_id = ' . $this->db->quoted($userId);
            } else {
                $where = 'AND user_id = ' . $this->db->quoted($userId);
            }
        }
        $time = $timedate->nowDb();
        if ($scheduleType == 'pro') {
            $query = "SELECT $this->table_name.id AS id, $this->table_name.report_id AS report_id, " .
                "$this->table_name.date_start AS date_start, $this->table_name.date_modified AS date_modified, " .
                "$this->table_name.next_run AS next_run, reportschedules_users.user_id AS user_id " .
                "FROM $this->table_name " .
                "JOIN reportschedules_users on reportschedules_users.reportschedule_id = $this->table_name.id " .
                "JOIN saved_reports on saved_reports.id=$this->table_name.report_id " .
                "JOIN users on users.id = reportschedules_users.user_id " .
                "WHERE saved_reports.deleted = 0 AND " .
                "$this->table_name.next_run < '$time' $where AND " .
                "$this->table_name.deleted = 0 AND " .
                "$this->table_name.active = 1 AND " .
                "$this->table_name.schedule_type = " . $this->db->quoted($scheduleType) . " AND " .
                "users.status = 'Active' AND users.deleted = 0 " .
                "AND reportschedules_users.deleted = 0 " .
                "ORDER BY $this->table_name.next_run ASC";
        } else {
            $query = "SELECT report_schedules.id AS id, report_schedules.report_id AS report_id, " .
                "report_schedules.date_start AS date_start,  report_schedules.date_modified AS date_modified, " .
                "report_schedules.next_run AS next_run, report_schedules.user_id AS user_id " .
                "FROM $this->table_name \n".
                "join saved_reports on saved_reports.id=$this->table_name.report_id \n".
                "join users on users.id = report_schedules.user_id".
                " WHERE saved_reports.deleted=0 AND \n" .
                "$this->table_name.next_run < '$time' $where AND \n".
                "$this->table_name.deleted=0 AND \n".
                "$this->table_name.active=1 AND " .
                "$this->table_name.schedule_type=" . $this->db->quoted($scheduleType) . " AND\n".
                "users.status='Active' AND users.deleted='0'".
                "ORDER BY $this->table_name.next_run ASC";
        }
        return $query;
    }

    /**
     * Gets a list of report schedules that need to send emails
     *
     * @param string $user_id
     * @param string $schedule_type
     * @return array
     */
    public function get_reports_to_email($user_id = '', $schedule_type = "pro")
    {
        $query = $this->getQuery($user_id, $schedule_type);

        $results = $this->db->query($query);
        $return_array = array();
        while ($row = $this->db->fetchByAssoc($results)) {
            $return_array[] = $this->fromConvertReportScheduleDBRow($row);
        }
        return $return_array;
    }

    /**
     * Gets a list of report schedules that need to send emails (used for advanced reports)
     *
     * @param string $user_id
     * @param string $schedule_type
     * @return array
     */
    public function get_ent_reports_to_email($user_id = '', $schedule_type = "ent")
    {
        $where = '';
        if (!empty($user_id)) {
            $where = "AND user_id='$user_id'";
        }
        $time = gmdate($GLOBALS['timedate']->get_db_date_time_format(), time());
        $query = "SELECT report_schedules.* FROM $this->table_name \n".
            "join report_maker on report_maker.id=$this->table_name.report_id \n".
            "join users on users.id = report_schedules.user_id".
            " WHERE report_maker.deleted=0 AND \n" .
            "$this->table_name.next_run < '$time' $where AND \n".
            "$this->table_name.deleted=0 AND \n".
            "$this->table_name.active=1 AND " .
            "$this->table_name.schedule_type='".$schedule_type."' AND\n".
            "users.status='Active' AND users.deleted='0'".
            "ORDER BY $this->table_name.next_run ASC";
        $results = $this->db->query($query);
        $return_array = array();
        while ($row = $this->db->fetchByAssoc($results)) {
            $return_array[$row['report_id']] = $this->fromConvertReportScheduleDBRow($row);
        }
        return $return_array;
    }

    /**
     * Update the next_run field by adding the interval to the time
     * Used once reports are emailed and we want to keep track of the next time
     * we need to send
     *
     * @param $schedule_id
     * @param $next_run
     * @param $interval
     */
    public function update_next_run_time($schedule_id, $next_run, $interval)
    {
        global $timedate;
        $last_run = $timedate->fromDb($next_run)->ts;
        $time = time();
        while ($last_run <= $time) {
            $last_run += $interval;
        }
        $next_run = $timedate->fromTimestamp($last_run)->asDb();
        $this->db->getConnection()
            ->executeUpdate(
                "UPDATE {$this->table_name} SET next_run = ? WHERE id = ?",
                [$next_run, $schedule_id]
            );
    }

    /**
     * Deactivates the given schedule
     *
     * @param string $id Schedule ID
     */
    public function deactivate($id)
    {
        $query = "UPDATE $this->table_name SET active = 0 WHERE id = " . $this->db->quoted($id);
        $this->db->query($query);
    }

    /**
     * Checks if Scheduler "Run Report Generation Scheduled Tasks"
     * is active
     *
     * @return boolean true if the scheduler is active, false otherwise
     */
    public function isReportSchedulerActive()
    {
        // Look for the Scheduler by 'job', since name is localized
        $fields = array(
            'job' => 'function::processQueue',
            'status' => 'Active',
        );

        $scheduler = new Scheduler();
        $scheduler = $scheduler->retrieve_by_string_fields($fields);

        return !empty($scheduler);
    }

    /**
     * Returns report schedule properties
     *
     * @param string $id Report schedule ID
     *
     * @return array
     */
    public function getInfo($id)
    {
        $query = "SELECT report_id, next_run, time_interval
        FROM {$this->table_name}
        WHERE id = " . $this->db->quoted($id);
        $result = $this->db->query($query);
        $row = $this->db->fetchByAssoc($result);
        $row = $this->fromConvertReportScheduleDBRow($row);

        return $row;
    }
}
