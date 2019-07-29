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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Queue;

use Sugarcrm\Sugarcrm\Dbal\Connection;
use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Document;
use Sugarcrm\Sugarcrm\Elasticsearch\Container;

/**
 *
 * Queue Manager
 *
 */
class QueueManager
{
    const FTS_QUEUE = 'fts_queue';
    const JOB_QUEUE = 'job_queue';
    const PROCESSED_NEW = '0';
    const PROCESSED_DONE = '1';
    const DEFAULT_BUCKET_ID = -1;

    /**
     * @var \Sugarcrm\Sugarcrm\Elasticsearch\Container
     */
    protected $container;

    /**
     * @var \DBManager
     */
    protected $db;

    /**
     * Maximum amount of records we retrieve from database queue as defined in
     * `$sugar_config['search_engine']['max_bulk_query_threshold']`.
     * @var integer
     */
    protected $maxBulkQueryThreshold = 15000;

    /**
     * Maximum amount of records we cleanup from database queue as defined in
     * `$sugar_config['search_engine']['max_bulk_delete_threshold']`.
     * @var integer
     */
    protected $maxBulkDeleteThreshold = 3000;

    /**
     * Grace time when postponing consumer jobs as defined in
     * `$sugar_config['search_engine']['postpone_job_time']`.
     * @var integer
     */
    protected $postponeJobTime = 120;

    /**
     * number of beans to batch retrieve related data for elastic document
     * `$sugar_config['search_engine']['num_of_records_in_batch']`.
     * @var integer
     */
    protected $numOfRecordsToRetrieveFromDBInBatch = 500;

    /**
     * In memory queue for processed queue record ids
     * @var array
     */
    protected $deleteFromQueue = array();

    /**
     * Ctor
     * @param array $config See `$sugar_config['search_engine']`
     */
    public function __construct(array $config, Container $container, \DBManager $db = null)
    {
        if (!empty($config['max_bulk_query_threshold'])) {
            $this->maxBulkQueryThreshold = (int) $config['max_bulk_query_threshold'];
        }
        if (!empty($config['max_bulk_delete_threshold'])) {
            $this->maxBulkDeleteThreshold = (int) $config['max_bulk_delete_threshold'];
        }
        if (!empty($config['postpone_job_time'])) {
            $this->maxBulkDeleteThreshold = (int) $config['postpone_job_time'];
        }
        if (!empty($config['num_of_records_in_batch'])) {
            $this->numOfRecordsToRetrieveFromDBInBatch = (int) $config['num_of_records_in_batch'];
        }

        $this->container = $container;
        $this->db = $db ?: \DBManagerFactory::getInstance();
    }

    /**
     * check bucketId, return true if bucketId is self::DEFAULT_PROCESSOR_ID
     * @param int $bucketId
     * @return bool
     */
    private function isDefaultBucketId(int $bucketId) : bool
    {
        return $bucketId === self::DEFAULT_BUCKET_ID;
    }

    /**
     * Queue all beans for given modules.
     * @param array $modules
     */
    public function reindexModules(array $modules)
    {
        // clear the whole queue when all modules are selected
        $this->resetAndCleanupQueue($modules);
        $this->queueModules($modules);
        $this->createScheduler();
    }

    /**
     * reset and clean up queue
     * @param array $modules
     */
    public function resetAndCleanupQueue(array $modules)
    {
        $allModules = $this->container->metaDataHelper->getAllEnabledModules();
        sort($allModules);
        sort($modules);

        // clear the whole queue when all modules are selected
        if ($allModules === $modules) {
            $this->resetQueue();
        } else {
            $this->resetQueue($modules);
        }

        $this->cleanupQueue();
    }

    /**
     * Although the queue can be used at any given point in time, we want to
     * be able to be notified from the scheduler when nothing is left in the
     * queue. This is our sign to do some housekeeping regarding bulk indexing
     * operations like refresh_interval and/or replica tuning.
     *
     * Both the non-replica reindex settings as well as refresh_interval should
     * be carefully configured when using live reindexing as both values will
     * only be restored when the queue is reported as empty. Optionally if due
     * to circumstances the queue doesn't get empty (i.e. async modules, or
     * live reindexing) CLI commands are available for prematurely force the
     * proper refresh_interval/replica settings.
     */
    public function reportIndexingDone()
    {
        $this->container->indexManager->reportIndexingDone();
    }

    /**
     * disable refresh interval and replica
     */
    protected function reportIndexingStart(array $modules = [])
    {
        $this->container->indexManager->reportIndexingStart($modules);
    }

    /**
     * Ensure a scheduler job exists to process the queued beans. If one
     * already exists we do not touch anything expect activate it as it
     * might be intentionally altered by the administrator.
     */
    public function createScheduler()
    {
        $schedulerClass = \SugarAutoLoader::customClass('Sugarcrm\\Sugarcrm\\Elasticsearch\\Queue\\Scheduler');
        $schedulerExec = "class::\\{$schedulerClass}";
        $scheduler = $this->getNewBean('Schedulers');

        $sq = new \SugarQuery();
        $sq->select('id');
        $sq->from($scheduler)->where()->equals('job', $schedulerExec);

        $result = $scheduler->fetchFromQuery($sq);

        if (empty($result)) {
            $scheduler->name = 'Elasticsearch Queue Scheduler';
            $scheduler->job = $schedulerExec;
            $scheduler->job_interval = '*/1::*::*::*::*';
            $scheduler->status = 'Active';
            $scheduler->date_time_start = '2001-01-01 00:00:01';
            $scheduler->date_time_end = '2037-12-31 23:59:59';
            $scheduler->catch_up = '0';
            $this->getLogger()->info("Create elastic queue scheduler");
        } else {
            $scheduler = array_shift($result);
            $scheduler->status = 'Active';
            $this->getLogger()->info("Elasticsearch queue scheduler already exists, activating");
        }

        $scheduler->save();
    }

    /**
     * Create consumer job for given module
     * @param string $module
     */
    public function createConsumer($module)
    {
        $jobClass = \SugarAutoLoader::customClass('Sugarcrm\\Sugarcrm\\Elasticsearch\\Queue\\ConsumerJob');
        $jobExec = "class::\\{$jobClass}";
        $job = $this->getNewBean('SchedulersJobs');

        foreach ([\SchedulersJob::JOB_STATUS_QUEUED, \SchedulersJob::JOB_STATUS_RUNNING] as $status) {
            $sq = new \SugarQuery();
            $sq->select('id');
            $sq->from($job)->where()
                ->equals('target', $jobExec)
                ->starts('data', $module)
                ->equals('status', $status);
            $sq->limit(1);
            $result = $job->fetchFromQuery($sq, ['id']);
            if (!empty($result)) {
                $this->getLogger()->info("Elastic consumer for $module already present");
                return;
            }
        }

        // No job is found for this module, let's create one.
        $job->name = 'Elasticsearch Queue Consumer';
        $job->target = $jobExec;
        $job->data = $module;
        $job->job_delay = $this->postponeJobTime;
        $job->assigned_user_id = $GLOBALS['current_user']->id;

        $this->submitNewJob($job);

        $this->getLogger()->info("Create elastic consumer for $module");
    }

    /**
     * Queue list of beans
     * @param \SugarBean[] $beans
     */
    public function queueBeans(array $beans)
    {
        foreach ($beans as $bean) {
            if (!$bean instanceof \SugarBean) {
                continue;
            }
            $this->queueBean($bean);
        }
    }

    /**
     * Add single bean to queue.
     * @param \SugarBean $bean
     */
    public function queueBean(\SugarBean $bean)
    {
        if (!$this->container->metaDataHelper->isModuleEnabled($bean->module_name)) {
            return;
        }
        $this->insertRecord($bean->id, $bean->module_name);
    }

    /**
     * Queue list of documents
     * @param \Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Document[] $documents
     */
    public function queueDocuments(array $documents)
    {
        foreach ($documents as $document) {
            if (!$document instanceof Document) {
                continue;
            }
            $this->queueDocument($document);
        }
    }

    /**
     * Add single document to queue. It's preferrable to use `queueBean`
     * instead, however in certain use cases beans are already converted into
     * documents so we need a way to be able to queue those documents in a
     * lightweight fasion. Note that when queueing a record only the bean
     * id is actually recorded and the current data on the document is
     * disposed of.
     *
     * @param Document $document
     */
    public function queueDocument(Document $document)
    {
        // Make sure we have an id and module name
        $id = $document->getId();
        $module = $document->getType();

        if (empty($id) || empty($module)) {
            return;
        }

        if (!$this->container->metaDataHelper->isModuleEnabled($module)) {
            return;
        }
        $this->insertRecord($id, $module);
    }

    /**
     * Remove all queued items for given modules. If no modules are specified
     * everything is cleared from the queue table - use with caution !
     * @param array $modules List of modules to clear
     */
    public function resetQueue(array $modules = array())
    {
        $sql = sprintf('DELETE FROM %s ', self::FTS_QUEUE);
        if ($modules) {
            $modules = array_map(array($this->db, 'quoted'), $modules);
            $sql .= sprintf(' WHERE bean_module IN (%s)', implode(',', $modules));
        }
        $this->db->query($sql);
    }

    /**
     * Remove records from queue for modules which are not enabled.
     */
    public function cleanupQueue()
    {
        $remove = array();
        $sql = sprintf('SELECT DISTINCT bean_module FROM %s', self::FTS_QUEUE);
        $result = $this->db->query($sql);
        while ($row = $this->db->fetchByAssoc($result)) {
            $data = $row['bean_module'];
            if (empty($data)) {
                continue;
            }
            if (!$this->container->metaDataHelper->isModuleEnabled($data)) {
                $remove[] = $data;
            }
        }

        if (!empty($remove)) {
            $this->resetQueue($remove);
        }
    }

    /**
     * Parse the data from the query.
     * @param $module string the name of the module
     * @param $row array the row returned from Query
     * @return \SugarBean
     */
    protected function processQueryRow($module, $row)
    {
        // Don't perform a full bean retrieve, rely on the generated query.
        // Related fields need to be handled separately.
        $bean = $this->getNewBean($module);

        //TODO: MAR-4889 will remove this hack.
        if ($bean instanceof \Email) {
            $bean->disableSynchronizingEmailParticipants = true;
        }

        $bean->populateFromRow($bean->convertRow($row));

        //TODO: MAR-4889 will remove this hack.
        if ($bean instanceof \Email) {
            $bean->disableSynchronizingEmailParticipants = false;
        }

        return $bean;
    }

    /**
     * do elsstic indexing
     * @param \SugarBean $bean
     * @param string $ftsId
     */
    protected function indexBean(\SugarBean $bean, string $ftsId)
    {
        // Index the bean and flag for removal when successful
        if ($this->container->indexer->indexBean($bean, true, true)) {
            $this->batchDeleteFromQueue($ftsId, $bean->getModuleName());
        }
    }

    /**
     * Consume records from database queue for given module
     * @param string $module
     * @param int $bucketId
     * @return array
     */
    public function consumeModuleFromQueue(string $module, int $bucketId = self::DEFAULT_BUCKET_ID) : array
    {
        // make sure the module is fts enabled
        if (!$this->container->metaDataHelper->isModuleEnabled($module)) {
            return array(false, 0, 0, "Module $module not enabled");
        }

        $start = time();
        $errorMsg = '';
        $success = true;

        $query = $this->generateQueryModuleFromQueue($this->getNewBean($module), $bucketId);
        $data = $query->execute();
        $beans = [];
        $ftsIds = [];
        foreach ($data as $row) {
            // setup erased_fields
            if (!isset($row['erased_fields'])) {
                $row['erased_fields'] = null;
            }
            $bean = $this->processQueryRow($module, $row);
            $ftsIds[$bean->id] = $row['fts_id'];

            // init tags and favorites
            $bean->fetchedFtsData['tags'] = [];
            $bean->fetchedFtsData['user_favorites'] = [];

            $beans[$bean->id] = $bean;
        }

        // batch retrieve tags, emails, and favorites
        $processed = $this->batchRetrieveRelatedDataAndIndexBeans($module, $beans, $ftsIds);

        // flush ids from queue if any left
        if (!empty($this->deleteFromQueue)) {
            $this->flushDeleteFromQueue($module);
        }

        $duration = time() - $start;
        return array($success, $processed, $duration, $errorMsg);
    }

    /**
     * Get a list of modules for which records are queued
     * @return array
     */
    public function getQueuedModules(int $bucketId = self::DEFAULT_BUCKET_ID) : array
    {
        $modules = array();
        $sql = sprintf(
            'SELECT DISTINCT bean_module FROM %s WHERE processed = %s',
            self::FTS_QUEUE,
            $this->isDefaultBucketId($bucketId) ? self::PROCESSED_NEW : $bucketId
        );
        $result = $this->db->query($sql);
        while ($row = $this->db->fetchByAssoc($result)) {
            $module = $row['bean_module'];
            if ($this->container->metaDataHelper->isModuleEnabled($module)) {
                $modules[] = $module;
            } else {
                // remove module from queue as there is no use to have them
                $this->resetQueue(array($module));
            }
        }
        return $modules;
    }

    /**
     * Get count for given module
     * @param string $module Module name
     * @return integer
     */
    public function getQueueCountModule(string $module, int $bucketId = self::DEFAULT_BUCKET_ID)
    {
        $sql = sprintf(
            "SELECT count(bean_id) FROM %s WHERE processed = %s AND bean_module = %s",
            self::FTS_QUEUE,
            $this->isDefaultBucketId($bucketId) ? self::PROCESSED_NEW : $bucketId,
            $this->db->quoted($module)
        );
        if ($result = $this->db->getOne($sql)) {
            return $result;
        }
        return 0;
    }

    /**
     * Insert single record into queue table
     * @param string $id
     * @param string $module
     */
    protected function insertRecord($id, $module)
    {
        // TODO - avoid duplicate beans for performance - upsert ?
        $sql = sprintf(
            'INSERT INTO %s (id, bean_id, bean_module, date_modified, date_created)
            VALUES (%s, %s, %s, %s, %s)',
            self::FTS_QUEUE,
            $this->db->getGuidSQL(),
            $this->db->quoted($id),
            $this->db->quoted($module),
            $this->db->now(),
            $this->db->now()
        );
        $this->db->query($sql);
    }

    /**
     * Submit job into job queue
     * @param \SchedulersJob $job
     */
    protected function submitNewJob(\SchedulersJob $job)
    {
        $queue = new \SugarJobQueue();
        $queue->submitJob($job);
    }

    /**
     * Helper function to create new sugar beans
     * @param string $module
     * @return \SugarBean
     */
    protected function getNewBean($module)
    {
        return \BeanFactory::newBean($module);
    }

    /**
     * Queue all records for given modules.
     * @param array $modules
     */
    protected function queueModules(array $modules)
    {
        foreach ($modules as $module) {
            $this->db->query($this->generateQueryModuleToQueue($module));
        }
    }

    /**
     * Generate SQL query to insert records into the queue for givem nodule
     * @param string $module
     * @return string
     */
    protected function generateQueryModuleToQueue($module)
    {
        $seed = $this->getNewBean($module);
        $sql = sprintf(
            'INSERT INTO %s (id, bean_id, bean_module, date_modified, date_created)
            SELECT %s, m.id bean_id, %s, %s, %s
            FROM %s m WHERE m.deleted = 0 ',
            self::FTS_QUEUE,
            $this->db->getGuidSQL(),
            $this->db->quoted($module),
            $this->db->now(),
            $this->db->now(),
            $seed->table_name
        );
        return $sql;
    }

    /**
     * Generate SQL query
     * @param \SugarBean
     * @param int $bucketId
     * @return \SugarQuery
     */
    protected function generateQueryModuleFromQueue(\SugarBean $bean, int $bucketId = self::DEFAULT_BUCKET_ID)
    {
        // Get all bean fields
        $beanFields = array_keys(
            $this->container->indexer->getBeanIndexFields($bean->module_name, true)
        );

        $beanFields[] = 'id';
        $beanFields[] = 'deleted';

        $sq = new \SugarQuery();
        // disable team security
        // adde erased fields
        $sq->from($bean, ['add_deleted' => false, 'team_security' => false, 'erased_fields' => true]);
        $sq->select($beanFields);
        $sq->limit($this->maxBulkQueryThreshold);

        // join fts_queue table
        if ($this->isDefaultBucketId($bucketId)) {
            $sq->joinTable(self::FTS_QUEUE)->on()
                ->equalsField(self::FTS_QUEUE . '.bean_id', 'id');
        } else {
            $sq->joinTable(self::FTS_QUEUE)->on()
                ->equalsField(self::FTS_QUEUE . '.bean_id', 'id')
                ->equals(self::FTS_QUEUE . '.processed', $bucketId);
        }

        $additionalFields = array(
            array(self::FTS_QUEUE . '.id', 'fts_id'),
            array(self::FTS_QUEUE . '.processed', 'fts_processed'),
        );

        $sq->select($additionalFields);

        return $sq;
    }

    /**
     * processing beans, to do batch retrieve related data and index beans
     * @param string $module
     * @param array $beans
     * @param array $ftsIds
     * @return int
     */
    protected function batchRetrieveRelatedDataAndIndexBeans(string $module, array $beans, array $ftsIds) : int
    {
        $count = count($beans);
        $start = 0;
        $processed = 0;

        // break beans into groups for batch processing
        while ($count > 0) {
            $slicedBeans = array_slice($beans, $start, $this->numOfRecordsToRetrieveFromDBInBatch, true);
            if (empty($slicedBeans)) {
                break;
            }
            $count -= $this->numOfRecordsToRetrieveFromDBInBatch;
            $start += $this->numOfRecordsToRetrieveFromDBInBatch;

            // fill up related data
            $this->batchRetrieveRelatedData($module, $slicedBeans);

            // index beans
            foreach ($slicedBeans as $bean) {
                // processing index
                $this->indexBean($bean, $ftsIds[$bean->id]);
                $processed++;
            }
        }

        return $processed;
    }

    /**
     * batch retrieve related data for beans
     * @param string $module, module name
     * @param array $beans
     * @return array
     */
    protected function batchRetrieveRelatedData(string $module, array $beans)
    {
        if (empty($beans)) {
            return $beans;
        }
        $this->batchRetrieveEmails($module, $beans);
        $this->batchRetrieveTags($module, $beans);
        $this->batchRetrieveFavorites($module, $beans);
        return $beans;
    }

    /**
     * batch retrieve associated emails
     * @param string $module
     * @param array $beans
     * @return array
     */
    protected function batchRetrieveEmails(string $module, array $beans)
    {
        // do secondary query to get emails
        $seed = \BeanFactory::newBean($module);
        $fieldHandler = \SugarFieldHandler::getSugarField('email');
        $fieldHandler->runSecondaryQuery('email', $seed, $beans);
        return $beans;
    }

    /**
     * batch retrieve associated tag ids
     * @param string $module
     * @param array $beans
     * @return array
     */
    protected function batchRetrieveTags(string $module, array $beans)
    {
        $ids = array_keys($beans);
        // do secondary query to retrieve tags
        if (!empty($ids)) {
            $query = "SELECT tag_id, bean_id
            FROM tag_bean_rel
            WHERE bean_module = ?
                AND bean_id IN (?)
                AND deleted = 0";
            $stmt = $this->db->getConnection()->executeQuery(
                $query,
                [$module, $ids],
                [null, Connection::PARAM_STR_ARRAY]
            );

            while ($row = $stmt->fetch()) {
                $id = $row['bean_id'];
                $beans[$id]->fetchedFtsData['tags'][] = $row['tag_id'];
            }
        }
        return $beans;
    }

    /**
     * batch retrieve assigned_user_ids for favorites
     * @param string $module
     * @param array $beans
     * @return array
     */
    protected function batchRetrieveFavorites(string $module, array $beans)
    {
        $ids = array_keys($beans);

        if (!empty($ids)) {
            $query = "SELECT assigned_user_id, record_id
            FROM sugarfavorites 
            WHERE module = ?  
               AND record_id IN (?) 
               AND deleted = 0";

            $stmt = $this->db->getConnection()->executeQuery(
                $query,
                [$module, $ids],
                [null, Connection::PARAM_STR_ARRAY]
            );

            while ($row = $stmt->fetch()) {
                $id = $row['record_id'];
                $beans[$id]->fetchedFtsData['user_favorites'][] = $row['assigned_user_id'];
            }
        }
        return $beans;
    }

    /**
     * Batch given record id to be removed from queue and flush queue
     * when necessary.
     * @param string $id
     * @param string $module
     */
    protected function batchDeleteFromQueue($id, $module = null)
    {
        $this->deleteFromQueue[] = $id;
        if (count($this->deleteFromQueue) >= $this->maxBulkDeleteThreshold) {
            $this->flushDeleteFromQueue($module);
        }
    }

    /**
     * Flush records from queue tracked in `$this->deleteFromQueue`
     * @param sring $module
     */
    protected function flushDeleteFromQueue($module = null)
    {
        $moduleClause = $module ? sprintf('bean_module = %s AND', $this->db->quoted($module)) : '';
        $idClause = implode(',', array_map(array($this->db, 'quoted'), $this->deleteFromQueue));
        $sql = sprintf(
            'DELETE FROM %s WHERE %s id IN (%s)',
            self::FTS_QUEUE,
            $moduleClause,
            $idClause
        );
        $this->db->query($sql);
        $this->db->commit();
        $this->deleteFromQueue = array();
    }

    /**
     * Try to pause the queue, returns false if not possible.
     * @return boolean
     */
    public function pauseQueue()
    {
        /*
         * TODO
         * - check if any consumers are running, if so return false nothing we can do to stop them
         * - clear all consumers from job_queue, once scheduler is activated again it will pick up again
         * - inactivate scheduler
         */
        return true;
    }

    /**
     * Consume all records from database queue, option to process $bucketId
     * @param int $bucketId
     * @return int, number of records have been processed
     */
    public function consumeQueue(int $bucketId = self::DEFAULT_BUCKET_ID) : int
    {
        $total = 0;
        foreach ($this->getQueuedModules($bucketId) as $module) {
            list($sucess, $processed, $duration, $errorMsg) = $this->consumeModuleFromQueue($module, $bucketId);
            $total += $processed;
        }

        if ($this->isDefaultBucketId($bucketId)) {
            // set elastic
            $this->reportIndexingDone();
        }
        return $total;
    }

    /**
     * Check if there are more records to consume
     * @param $bucketId
     * @return boolean
     */
    protected function hasMoreRecords(int $bucketId) : bool
    {
        // check the count for each module
        foreach ($this->getQueuedModules($bucketId) as $module) {
            if ($this->getQueueCountModule($module, $bucketId) > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * loop through Queue to process all data in the queue
     * @return int
     */
    public function consumeAllDataFromQueue(int $bucketId) : int
    {
        $total = 0;
        while ($this->hasMoreRecords($bucketId)) {
            $total += $this->consumeQueue($bucketId);
        }

        return $total;
    }

    /**
     * reset Queue and create data in FTS_QUEUE table
     * @param array $modules
     * @param int $bucketSize
     */
    public function createQueueForBuckets(array $modules, int $bucketSize)
    {
        $this->resetAndCleanupQueue($modules);
        foreach ($modules as $module) {
            $this->db->query($this->generateQueryModuleToQueueForBuckets($module, $bucketSize));
        }
        // force to commit right way
        $this->db->commit();
    }

    /**
     * Generate SQL query to insert records into the queue for givem nodule, also assign bucket Id for parallel processing
     * @param string $module
     * @return string
     */
    protected function generateQueryModuleToQueueForBuckets(string $module, int $bucketSize)
    {
        $seed = $this->getNewBean($module);
        $sql = sprintf(
            'INSERT INTO %s (id, bean_id, bean_module, date_modified, date_created, processed)
            SELECT %s, m.id bean_id, %s, %s, %s, %s
            FROM %s m WHERE m.deleted = 0 ',
            QueueManager::FTS_QUEUE,
            $this->db->getGuidSQL(),
            $this->db->quoted($module),
            $this->db->now(),
            $this->db->now(),
            $this->db->getDbRandomNumberFunction(1, $bucketSize),
            $seed->table_name
        );
        return $sql;
    }

    /**
     * Get logger object
     * @return \Sugarcrm\Sugarcrm\Elasticsearch\Logger
     */
    protected function getLogger()
    {
        return $this->container->logger;
    }
}
