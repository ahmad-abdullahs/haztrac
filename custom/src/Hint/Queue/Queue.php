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
namespace Sugarcrm\Sugarcrm\custom\Hint\Queue;

use Doctrine\DBAL\Platforms\DB2Platform;
use Doctrine\DBAL\Platforms\OraclePlatform;
use Sugarcrm\Sugarcrm\custom\Hint\Config\ConfigTrait;
use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger as HintLogger;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\InstanceInitEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\QueueEventInterface;
use Sugarcrm\Sugarcrm\Dbal\Connection;
use Sugarcrm\Sugarcrm\Util\Uuid;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Queue implements LoggerAwareInterface
{
    use LoggerAwareTrait, ConfigTrait;

    /**
     * Queue instance
     *
     * @var static
     */
    private static $instance;

    /**
     * Sugacrm database connection
     *
     * @var Connection
     */
    private $db;

    /**
     * Queue config
     * @var array
     */
    private $queueConfig;


    /**
     * Returns single instance of the class
     *
     * @return static
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Queue constructor.
     */
    private function __construct()
    {
        $this->db = $this->getDbConnection();
        $this->queueConfig = $this->getConfig()->getQueueConfig();

        $this->setLogger(new HintLogger());
    }

    /**
     * @param QueueEventInterface $event
     * @param array $context
     * @return bool
     */
    public function recordEvent(QueueEventInterface $event, array $context = []): bool
    {
        $this->logger->debug(sprintf('Event queue: recording event "%s"', $event));
        try {
            $rowCount = 0;
            foreach (array_chunk($event->toQueueRows(), $this->queueConfig['insert_bulk_size']) as $chunk) {

                if (!$chunk) {
                    continue;
                }

                $platform = $this->db->getDatabasePlatform();
                if ($platform instanceof OraclePlatform) {
                    // InstanceInitEvent is emitted only once (either install or upgrade)
                    if ($event instanceof InstanceInitEvent) {
                        /*
                         * We can't use SEQUENCE.NEXTVAL in ORACLE multi inserts
                         * directly because of failing unique constraints. By we can define
                         * a function doing the same thing and call it there.
                         */
                        $nextNumberSql = $this->getAutoIncrementSQL('event_number');
                        $sql = <<<INC_FUNC_SQL
CREATE OR REPLACE FUNCTION hint_evt_queue_next RETURN NUMBER IS
BEGIN
  RETURN $nextNumberSql;
END;
INC_FUNC_SQL;
                        $this->db->exec($sql);
                    }

                    /*
                     * Oracle can insert 1 row only. But at the same time it supports
                     * INSERT ALL syntax which allows INSERTs from SELECT. Here we insert
                     * static values. But syntax allows INSERTs of selected columns too.
                     * The DUAL table is a special one-row, one-column table.
                     *
                     * INSERT ALL
                     *   INTO aaa ( a, b, c) VALUES ('1', '2', '3', nextval_func)
                     *   ...
                     *   INTO aaa ( a, b, c) VALUES ('1', '2', '3', nextval_func)
                     * SELECT * FROM dual
                     */
                    $query = 'INSERT ALL';
                    $values = $this->getInsertValues($chunk, $context, 'hint_evt_queue_next');
                    foreach ($values as $value) {
                        $query .= ' INTO hint_events_queue (id, type, data, user_id, group_ms, event_number, created) VALUES ' . $value;
                    }
                    $query .= ' SELECT * FROM dual';
                } elseif ($platform instanceof DB2Platform) {
                    /*
                     * DB2 has its own INSERT from SELECT syntax. But the following syntax
                     * is easier to read and understand without DB2 background as it's closer
                     * to the one from MySQL. Autoincrement fields require operating on sequences
                     * directly.
                     *
                     * INSERT INTO aaa ( a, b, c, d) VALUES
                     *   ('1', '2', '3', NEXTVAL FOR aaa_d_seq),
                     *   ...
                     *   ('1', '2', '3', NEXTVAL FOR aaa_d_seq)
                     */
                    $query = sprintf(
                        'INSERT INTO hint_events_queue (id, type, data, user_id, group_ms, event_number, created) VALUES %s',
                        implode(', ', $this->getInsertValues($chunk, $context, $this->getAutoIncrementSQL('event_number')))
                    );
                } else {
                    /*
                     * INSERT INTO aaa ( a, b, c) VALUES
                     *   ('1', '2', '3'),
                     *   ...
                     *   ('1', '2', '3')
                     */
                    $query = sprintf(
                        'INSERT INTO hint_events_queue (id, type, data, user_id, group_ms, created) VALUES %s',
                        implode(', ', $this->getInsertValues($chunk, $context))
                    );
                }

                $rowCount += $this->db->executeUpdate($query);
            }

            $this->logger->debug(sprintf('Event queue: %d records were added', $rowCount));

            return true;
        } catch (\Throwable $e) {
            $this->logger->alert(sprintf('Event queue: event recording failed: "%s", error: "%s"', $event, $e->getMessage()));

            return false;
        }
    }

    /**
     * Locks some queued events and returns them
     * @return array
     */
    public function getQueuedEvents(): array
    {
        $this->logger->info('Event queue: fetching events');

        try {
            /*
             * All further queries don't require transaction as the whole
             * method is executed from cron and doesn't suffer from concurrency
             * issues. We may get some INSERTs after "isQueueBusy" check. But
             * "locked" state of queue rows can't be changed from some other
             * place.
             */
            if ($this->isQueueBusy()) {
                return [];
            }

            /*
             * embedded SELECT is used to bypass
             * "This version of MySQL doesn't yet support 'LIMIT & IN/ALL/ANY/SOME subquery"
             */
            $subquery = <<<'SUBQUERY'
SELECT q.id, q.processing_instance, q.group_ms, q.event_number FROM hint_events_queue q
WHERE q.processing_instance IS NULL
ORDER BY q.group_ms ASC, q.event_number ASC
SUBQUERY;

            // apply cross db platform LIMIT to the query
            $subquery = $this->db->getDatabasePlatform()
                ->modifyLimitQuery($subquery, $this->queueConfig['fetch_bulk_size']);

            $lockQuery = <<<QUERY
UPDATE hint_events_queue SET processing_instance = ?, processing_start_time = ?
WHERE id IN (
    SELECT id FROM ($subquery) tmp
)
QUERY;

            // lock params
            $uniqueKey = $this->getConfig()->getValue('unique_key');
            $now = \TimeDate::getInstance()->nowDb();

            // no locked rows
            if (!$this->db->executeUpdate($lockQuery, [$uniqueKey, $now])) {
                return [];
            }

            // fetch required fields from locked rows
            $fetchQuery = <<<'QUERY'
SELECT q.type, q.data, q.processing_instance, q.group_ms, q.event_number FROM hint_events_queue q
WHERE q.processing_instance IS NOT NULL
ORDER BY q.group_ms ASC, q.event_number ASC
QUERY;

            $events = $this->db->fetchAll($fetchQuery);

            $this->logger->debug(sprintf('Event queue: %d events were fetched', count($events)));

            return $events;
        } catch (\Throwable $e) {
            $this->logger->alert(sprintf('Event queue: event fetching failed: "%s"', $e->getMessage()));

            return [];
        }
    }

    /**
     * Deletes all locked events from queue
     * NOTE: should be called when we have successfully processed all the events
     * @param array $events
     */
    public function finishedProcessingEvents(array $events = []): void
    {
        $this->logger->info('Event queue: removing processed events');

        if ($this->queueConfig['keep_rows']) {
            return;
        }

        $rowCount = $this->db->exec('DELETE FROM hint_events_queue WHERE processing_instance IS NOT NULL');

        $this->logger->debug(sprintf('Event queue: %d events were removed', $rowCount));
    }

    /**
     * Releases all locked events which haven't been processed for 5 min
     * making them available for further processing
     */
    public function resetStaleEvents(): void
    {
        $this->logger->info('Event queue: resetting stale events');

        $timeInterval = sprintf('-%d seconds', $this->queueConfig['max_processing_time']);
        $startTime = \TimeDate::getInstance()->getNow()->get($timeInterval)->asDb();

        $query = <<<'QUERY'
UPDATE hint_events_queue SET processing_instance = NULL, processing_start_time = NULL
WHERE processing_start_time < ?
QUERY;
        $rowCount = $this->db->executeUpdate($query, [$startTime]);

        $this->logger->debug(sprintf('Event queue: %d stale events were updated', $rowCount));
    }

    /**
     * Deletes all events from queue
     */
    public function cleanQueue(): void
    {
        $this->logger->info('Event queue: cleaning');

        if ($this->queueConfig['keep_rows']) {
            return;
        }

        $rowCount = $this->db->executeUpdate('DELETE FROM hint_events_queue');

        $this->logger->debug(sprintf('Event queue: %d events were removed', $rowCount));
    }

    /**
     * Checks if the queue is busy
     * @return bool
     */
    public function isQueueBusy(): bool
    {
        $query = 'SELECT 1 FROM hint_events_queue WHERE processing_instance IS NOT NULL';

        return (bool)$this->db->fetchColumn($query);
    }

    /**
     * Get db connection
     * @return Connection
     */
    protected function getDbConnection(): Connection
    {
        /*
         * Potentially it gives us a possibility to move queue to a
         * separate database or have a separate connection just for queue
         * specific queries
         *
         * see \DBManagerFactory::getInstance implementation
         */
        $instanceName = 'hint_events_queue';

        return \DBManagerFactory::getConnection($instanceName);
    }

    /**
     * Get "VALUES" parts of multi insert query
     * @param array $chunk
     * @param array $context
     * @param string $sequenceSql
     * @return array
     */
    protected function getInsertValues(array $chunk, array $context = [], string $sequenceSql = null): array
    {
        global $current_user;

        $userId = isset($context['user_id']) ? $context['user_id'] : $current_user->id;
        $now = \TimeDate::getInstance()->nowDb();
        $groupMs = microtime(true);

        // DB platforms supporting autoincrement via sequence require it on every insert
        $valuesFormat = $sequenceSql
            ? '(%s, %s, %s, %s, %s, %s, %s)'
            : '(%s, %s, %s, %s, %s, %s)';

        $values = [];
        foreach ($chunk as $row) {
            $data = json_encode($row['data'], JSON_UNESCAPED_SLASHES);

            $params = [];
            array_push($params,
                $this->db->quote(Uuid::uuid1()),
                $this->db->quote($row['type']),
                $this->db->quote($data),
                $this->db->quote($userId),
                $this->db->quote($groupMs)
            );
            if ($sequenceSql) {
                array_push($params, $sequenceSql);
            }
            array_push($params, $this->db->quote($now));

            $values[] = vsprintf($valuesFormat, $params);
        }

        return $values;
    }

    /**
     * Get DB specific autoincrement sql
     * @param string $column
     * @return string
     */
    protected function getAutoIncrementSQL(string $column): string
    {
        /*
         * We need to use sugar db manager here as it was used
         * on install to create sequence
         */
        return \DBManagerFactory::getInstance()->getAutoIncrementSQL('hint_events_queue', $column);
    }
}
