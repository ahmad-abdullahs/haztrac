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
use Sugarcrm\Sugarcrm\custom\Hint\Initializer;

class InitJob implements \RunnableSchedulerJob
{
    use ConfigTrait;

    /**
     * Job name
     */
    const NAME = 'Hint Init Job';

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
        // no scheduler means this job finished successfully some time ago
        if (empty($this->job->scheduler_id)) {
            return $this->job->succeedJob('Hint is initialized');
        }

        $scheduler = \BeanFactory::retrieveBean('Schedulers', $this->job->scheduler_id);
        if (!$scheduler || $scheduler->status !== 'Active') {
            return $this->job->succeedJob('No active scheduler');
        }

        // the 1st run
        if (empty($data)) {
            $this->job->data = json_encode([
                'unique_key' => $this->getUniqueKey(),
                'site_url' => $this->getSiteUrl(),
            ]);
            return $this->postpone('Postponing, no subscription');
        }

        // handling a valid installation case
        $data = json_decode($data, true);
        if ($this->getUniqueKey() === $data['unique_key']
            && $this->getSiteUrl() === $data['site_url']) {
            return $this->postpone('Postponing, nothing changed');
        }

        // run Hint init logic
        (new Initializer())->initClonedInstance();

        $scheduler->status = 'Inactive';
        $scheduler->save();

        return $this->job->succeedJob('Hint is initialized');
    }

    /**
     * Returns unique key
     *
     * @return string
     */
    protected function getUniqueKey()
    {
        return $this->getConfig()->getValue('unique_key', '');
    }

    /**
     * Returns site url
     *
     * @return string
     */
    protected function getSiteUrl()
    {
        return $this->getConfig()->getValue('site_url', '');
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
