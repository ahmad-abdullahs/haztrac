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

class UserInitJob implements \RunnableSchedulerJob
{
    /**
     * Job name
     */
    const NAME = 'Hint User Init Job';

    // Max number of user ids per job
    const ID_CHUNK_SIZE = 100;

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
        $users = $this->getUsers($data);
        if (!$users) {
            return $this->job->failJob('Invalid data');
        }

        $processed = [];
        foreach ($users as $user) {
            \HintAccountset::createUserAccountset($user);
            $processed[] = $user->id;
        }

        return $this->job->succeedJob(sprintf('Processed users: %s', implode(', ', $processed)));
    }

    /**
     * Parses job data and returns an array of user ids
     *
     * @param $data
     * @return \User[]
     * @throws \SugarQueryException
     */
    private function getUsers($data)
    {
        $ids = json_decode($data);
        if (!$ids || !is_array($ids)) {
            return [];
        }

        $seed = \BeanFactory::newBean('Users');

        $query = new \SugarQuery();
        $query->from($seed)->where()->in('id', $ids);

        return $seed->fetchFromQuery($query, ['id']);
    }
}
