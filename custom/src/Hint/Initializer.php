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
namespace Sugarcrm\Sugarcrm\custom\Hint;

use Sugarcrm\Sugarcrm\custom\Hint\Job\UserInitJob;
use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger as HintLogger;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\InstanceInitEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\InstanceResyncEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\TargetAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\QueueTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Initializer implements LoggerAwareInterface
{
    use LoggerAwareTrait, QueueTrait;


    /**
     * Initializer constructor.
     */
    public function __construct()
    {
        $this->eventQueue = $this->getEventQueue();
        $this->setLogger(new HintLogger());
    }

    /**
     * Init new instance
     */
    public function init()
    {
        $this->logger->info('Started new instance init process');

        // 1. init instance event
        $this->eventQueue->recordEvent(new InstanceInitEvent(), []);

        // 2. init new users
        $this->initUsers();

        $this->logger->info('Finished new instance init process');
    }

    /**
     * Init cloned instance:
     */
    public function initClonedInstance()
    {
        $this->logger->info('Started cloned instance init process');

        // 1. clean event queue
        $this->eventQueue->cleanQueue();

        // 2. init instance event
        $this->eventQueue->recordEvent(new InstanceInitEvent());

        // 3. process existing targets
        $this->initTargets();

        // 4. process existing accountsets
        $this->initAccountsets();

        // 5. init new users
        $this->initUsers();

        $this->logger->info('Finished cloned instance init process');
    }

    /**
     * Resync instance
     */
    public function resync()
    {
        $this->logger->info('Started instance resync process');

        // 1. clean event queue
        $this->eventQueue->cleanQueue();

        // 2. resync instance event
        $this->eventQueue->recordEvent(new InstanceResyncEvent());

        // 3. process existing targets
        $this->initTargets();

        // 4. process existing accountsets
        $this->initAccountsets();

        // 5. init new users
        $this->initUsers();

        $this->logger->info('Finished instance resync process');
    }

    /**
     * Goes through all existing targets and puts them back to the queue
     */
    protected function initTargets()
    {
        $offsetStep = 100;
        $offset = 0;

        while (true) {
            $seed = \BeanFactory::newBean('HintNotificationTargets');
            $query = new \SugarQuery();
            $query->select([
                ['id', 'target_id'],
                'type',
                'credentials',
                ['assigned_user_id', 'user_id'],
            ]);
            $query->from($seed, ['alias' => 'targets']);
            $query->join('assigned_user_link', [
                'joinType' => 'INNER',
            ]);
            $query->orderBy('date_entered', 'ASC');
            $query->offset($offset);
            $query->limit($offsetStep);


            $rows = $query->execute();

            // no valid targets - stop processing
            if (!$rows) {
                return;
            }

            $offset += $offsetStep;

            // map sql result set to TARGET_ADD event payloads
            $data = [];
            foreach ($rows as $row) {
                $row = array_change_key_case($row, CASE_LOWER);
                $data[] = array_merge($row, [
                    // event queue expects decoded data
                    'credentials' => json_decode($row['credentials'], true),
                ]);
            }

            // queue TARGET_ADD events with proper payload and user context
            foreach ($data as $eventData) {
                $eventData = array_merge(['targetId' => $eventData['target_id']], $eventData);
                $context = ['user_id' => $eventData['user_id']];
                $this->eventQueue->recordEvent(new TargetAddEvent($eventData), $context);
            }
        }
    }


    /**
     * Goes through all existing accountsets and puts them back to the queue
     */
    protected function initAccountsets()
    {
        $offsetStep = 100;
        $offset = 0;

        while (true) {
            $seed = \BeanFactory::newBean('HintAccountsets');

            $idQuery = new \SugarQuery();
            $idQuery->select(['id']);
            $idQuery->from($seed);
            $idQuery->orderBy('date_entered', 'ASC');
            $idQuery->offset($offset);
            $idQuery->limit($offsetStep);

            $ids = array_column($idQuery->execute(), 'id');

            // no valid accountsets - stop processing
            if (!$ids) {
                return;
            }

            $offset += $offsetStep;

            $query = new \SugarQuery();
            $query->from($seed, ['alias' => 'accountsets']);
            $query->join('assigned_user_link', [
                'joinType' => 'INNER',
                'alias' => 'users'
            ]);
            $query->join('notification_targets', [
                'joinType' => 'left',
                'alias' => 'targets'
            ]);
            $query->join('tag_link', [
                'joinType' => 'left',
                'alias' => 'tags'
            ]);
            // we define join aliases before select
            $query->select([
                // accountset fields
                ['id', 'accountset_id'],
                'type',
                'category',
                ['assigned_user_id', 'user_id'],
                // related target and tag ids
                ['targets.id', 'target_id'],
                ['tags.id', 'tag_id'],
            ]);
            $query->where()->in('accountsets.id', $ids);

            $rows = $query->execute();

            // no valid accountsets - stop processing
            if (!$rows) {
                return;
            }

            // map sql result set (denormalized data) to ACCOUNTSET_ADD event payloads
            $data = [];
            foreach ($rows as $row) {
                $row = array_change_key_case($row, CASE_LOWER);
                $id = $row['accountset_id'];

                // prepare pure event payload (accountset + empty arrays of related ids)
                if (!isset($data[$id])) {
                    $data[$id] = array_merge(
                        array_intersect_key($row, array_flip(['accountset_id', 'type', 'category', 'user_id'])),
                        ['targetIds' => [], 'tagIds' => []]
                    );
                }

                // add related ids
                if ($row['target_id']) {
                    $data[$id]['targetIds'][] = $row['target_id'];
                }

                if ($row['tag_id']) {
                    $data[$id]['tagIds'][] = $row['tag_id'];
                }
            }

            // queue ACCOUNTSET_ADD events with proper payload and user context
            foreach ($data as $eventData) {
                $eventData = array_merge(['accountsetId' => $eventData['accountset_id']], $eventData);
                $context = ['user_id' => $eventData['user_id']];
                $this->eventQueue->recordEvent(new AccountsetAddEvent($eventData), $context);
            }
        }
    }

    /**
     * Finds users with no accountsets and delegates further
     * processing to UserInitJob
     */
    protected function initUsers()
    {
        $ids = $this->getNotInitializedUserIds();
        $scheduler = $this->getUserInitScheduler();
        if ($ids && $scheduler) {

            // delete existing user init jobs
            $jobQueueTable = \BeanFactory::getBean('SchedulersJobs')->getTableName();
            \DBManagerFactory::getConnection()->delete($jobQueueTable, [
                'name' => UserInitJob::NAME,
            ]);

            foreach (array_chunk($ids, UserInitJob::ID_CHUNK_SIZE) as $chunk) {
                $job = $scheduler->createJob();
                $job->status = \SchedulersJob::JOB_STATUS_QUEUED;
                $job->resolution = \SchedulersJob::JOB_PENDING;
                $job->data = json_encode($chunk);
                $job->save();
            }
        }
    }

    /**
     * Returns ids of all users who do NOT have an accountset
     * @return array
     * @throws \SugarQueryException
     */
    protected function getNotInitializedUserIds()
    {
        $accountset = \BeanFactory::newBean('HintAccountsets');
        $subquery = new \SugarQuery();
        $subquery->select(['assigned_user_id']);
        $subquery->distinct(true);
        $subquery->from($accountset);

        $user = \BeanFactory::newBean('Users');
        $query = new \SugarQuery();
        $query->select(['id']);
        // this one results to warning due to "notIn" not checking param types
        // $query->from($user)->where()->notIn('id', $subquery);
        $query->from($user)->where()->condition('id', 'NOT IN', $subquery);

        return array_column($query->execute(), 'id');
    }

    /**
     * Returns user init scheduler
     * @return \Scheduler|null
     * @throws \SugarQueryException
     */
    protected function getUserInitScheduler()
    {
        $job = sprintf('class::%s', UserInitJob::class);
        $seed = \BeanFactory::newBean('Schedulers');

        $query = new \SugarQuery();
        $query->from($seed)->where()->equals('job', $job);

        $schedulers = $seed->fetchFromQuery($query, ['id', 'name', 'job']);

        return array_shift($schedulers);
    }
}
