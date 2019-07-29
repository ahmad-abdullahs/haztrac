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

use Sugarcrm\Sugarcrm\DependencyInjection\Container;

class DataPrivacyHooks
{
    /**
     * The data privacy object needs to keep the fields_to_erase up to date when relationships are changed
     *
     * @param DataPrivacy $dp
     * @param string $event
     * @param array $params
     */
    public static function unlinkRecordsFromErase(DataPrivacy $dp, $event, $params = array())
    {
        $dp->relatedRecordRemoved($params['link'], $params['related_id']);
    }

    /**
     * Initiate the erasure process on the activity stream records associated with this Data Privacy object if it is a
     * 'Data Erasure' event, the DataPrivacy record is being Closed, and there are one or more Persons affected
     *
     * @param DataPrivacy $dp
     * @param string $event
     * @param array $params
     */
    public static function performActivityStreamErasure(DataPrivacy $dp, $event, $params = array())
    {
        if ($dp->type === 'Request to Erase Information' &&
            isset($dp->dataChanges) &&
            !empty($dp->dataChanges['status']) &&
            $dp->dataChanges['status']['before'] !== 'Closed' &&
            $dp->dataChanges['status']['after'] === 'Closed'
        ) {
            static::addToJobQueue($dp);
        }
    }

    /**
     * Append the DataPrivacy record id to an existing ActivityStreamErasure if one exists, is in the queued status and
     * is within the maximum number of DataPrivacy records allowed per job. Otherwise, create a new
     * ActivityStreamErasure job and set its execution delay appropriately.
     *
     * @param DataPrivacy $dp
     */
    protected static function addToJobQueue($dp)
    {
        $settings = Container::getInstance()->get(SugarConfig::class)->get('activity_streams');
        $maxDataPrivacyRecordsPerJob = (int)$settings['erasure_job_limit'];
        $delayedScheduleMinutes = (int)$settings['erasure_job_delay'];

        $systemUser = BeanFactory::newBean('Users');
        $systemUser->getSystemUser();

        $createNewJob = true;
        $exDateTime = null;
        $logMessage = '';
        $timedate = TimeDate::getInstance();
        $jobName = 'ActivityStreamErasure';
        $queued = SchedulersJob::JOB_STATUS_QUEUED;
        $delay = 60 * $delayedScheduleMinutes;

        // For efficiency, try to use a 'queued' job first if one exists that can accept more Data Privacy records.
        // Candidates are those that are at least 5 seconds from being ready to run in order to avoid a race condition.
        $executePending = $timedate->asDb($timedate->getNow()->modify('+5 seconds'));
        $sql = 'SELECT id, execute_time, data FROM job_queue WHERE name = ? AND status = ?' .
            ' AND deleted = 0 AND execute_time >= ? ORDER BY execute_time';
        $conn = $GLOBALS['db']->getConnection();
        $stmt = $conn->executeQuery($sql, [$jobName, $queued, $executePending]);
        while ($jobInfo = $stmt->fetch()) {
            $exDateTime = $jobInfo['execute_time'];
            $data = json_decode(html_entity_decode($jobInfo['data']), true);
            $dataPrivacyIds = $data['dataPrivacyIds'];
            if (count($dataPrivacyIds) < $maxDataPrivacyRecordsPerJob) {
                $dataPrivacyIds[] = $dp->id;
                $data = json_encode(array('dataPrivacyIds' => $dataPrivacyIds));

                $sql = 'UPDATE job_queue SET data = ? WHERE id = ?';
                $conn->executeUpdate($sql, [$data, $jobInfo['id']]);
                $createNewJob = false;
                $logMessage = "--- DATAPRIVACY:ActivityStream --- Updated Job: $jobName - id='{$jobInfo['id']}'";
                break;
            }
        }

        if ($createNewJob) {
            /* Create New Job and schedule it to run after delay */
            if (is_null($exDateTime)) {
                $dtm = $timedate->getNow();
            } else {
                $dtm = $timedate->fromDbType($GLOBALS['db']->fromConvert($exDateTime, 'datetime'), 'datetime');
            }
            $executeTime = $timedate->asDb($dtm->modify("+{$delay} seconds"));

            $dataPrivacyIds = array($dp->id);
            $data = ['dataPrivacyIds' => $dataPrivacyIds];
            $job = BeanFactory::newBean('SchedulersJobs');
            $job->name = 'ActivityStreamErasure';
            $job->target = 'class::SugarJobPerformActivityErasure';
            $job->data = json_encode($data);
            $job->retry_count = 0;
            $job->execute_time = $executeTime;
            $job->assigned_user_id = $systemUser->id;
            $jobQueue = new SugarJobQueue();
            $jobQueue->submitJob($job);

            $logMessage = "--- DATAPRIVACY:ActivityStream --- New Job: $jobName Created";
        }

        $GLOBALS['log']->debug($logMessage);
    }
}
