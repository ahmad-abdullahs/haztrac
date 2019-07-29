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

class SugarJobPerformActivityErasure implements RunnableSchedulerJob
{
    protected $job;

    /**
     * This method implements setJob from RunnableSchedulerJob. It sets the
     * SchedulersJob instance for the class.
     *
     * @param SchedulersJob $job the SchedulersJob instance set by the job queue
     */
    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }

    /**
     * Executes a job to add activity subscriptions.
     * @param string $data Json string containing associative array of DataPrivacy ids to process.
     * @return bool
     */
    public function run($data)
    {
        try {
            if (!empty($data)) {
                $data = json_decode(html_entity_decode($data), true);
                if (!empty($data) && !empty($data['dataPrivacyIds'])) {
                    $dataPrivacyIds = $data['dataPrivacyIds'];

                    Activity::disable();
                    $activityErasure = new ActivityErasure();
                    $activityErasure->process($dataPrivacyIds);
                    Activity::restoreToPreviousState();
                }
            }

            $this->job->succeedJob();

            return true;
        } catch (Exception $e) {
            $this->job->failJob($e->getMessage());
            return false;
        }
    }
}
