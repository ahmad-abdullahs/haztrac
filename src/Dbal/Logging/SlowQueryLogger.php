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

namespace Sugarcrm\Sugarcrm\Dbal\Logging;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;

/**
 * Logs queries into sugarcrm log
 */
final class SlowQueryLogger implements SQLLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Query execution time threshold in milliseconds
     *
     * @var int
     */
    private $threshold;

    /**
     * @var float
     */
    private $start;

    /**
     * @var array
     */
    private $query = array();

    public function __construct(LoggerInterface $logger, int $threshold)
    {
        $this->logger = $logger;
        $this->threshold = $threshold;
    }

    /**
     * {@inheritDoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->start = microtime(true);
        $this->query = [$sql, ['params' => $params, 'types' => $types]];
    }

    /**
     * {@inheritDoc}
     */
    public function stopQuery()
    {
        $executionTime = microtime(true) - $this->start;

        if ($executionTime * 1000 >= $this->threshold) {
            [$sql, $params] = $this->query;

            $this->logger->alert(sprintf(
                'Slow Query (time: %.3f s): %s',
                $executionTime,
                $sql
            ), $params);
        }
    }
}
