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
namespace Sugarcrm\Sugarcrm\custom\Hint\Job;

use Sugarcrm\Sugarcrm\custom\Hint\Config\ConfigTrait;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\QueueProcessor;

class NewsJob implements \RunnableSchedulerJob
{
    use ConfigTrait;

    /**
     * Job name
     */
    const NAME = 'Hint News Job';

    /**
     * SchedulersJob job_delay (seconds)
     * @var int
     */
    const JOB_POSTPONE_TIMEOUT = 5 * 60;

    /**
     * @var \SchedulersJob
     */
    protected $job;

    /**
     * {@inheritdoc}
     */
    public function setJob(\SchedulersJob $job)
    {
        $this->job = $job;
    }

    /**
     * {@inheritdoc}
     */
    public function run($data)
    {
        if (!$this->getConfig()->isInsightsEnabled()) {
            return $this->postpone('Postponing, Hint insights package is disabled');
        }

        $this->getQueueProcessor()->processQueue();

        return $this->job->succeedJob('Hint event queue successfully processed');
    }

    /**
     * Get queue processor
     * @return QueueProcessor
     */
    protected function getQueueProcessor(): QueueProcessor
    {
        return new QueueProcessor();
    }

    /**
     * Postpones current job
     *
     * @param string $message
     * @param int $timeout
     * @return bool
     */
    private function postpone($message = '', $timeout = self::JOB_POSTPONE_TIMEOUT)
    {
        // to avoid infinite message concatenation
        $this->job->message = '';

        return $this->job->postponeJob($message, $timeout);
    }
}
