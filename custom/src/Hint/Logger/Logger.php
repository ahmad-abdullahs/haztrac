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
namespace Sugarcrm\Sugarcrm\custom\Hint\Logger;

use Sugarcrm\Sugarcrm\Logger\Factory as LoggerFactory;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\LoggerTrait;

class Logger implements LoggerInterface
{
    use LoggerTrait;

    // The name of sugar logger channel
    const CHANNEL_NAME = 'hint';

    /**
     * Underlying pure PSR-3 logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Sugar to PSR log level mapper
     *
     * @var LevelMapper
     */
    private $levelMapper;


    /**
     * Logger constructor.
     */
    public function __construct()
    {
        $this->logger = LoggerFactory::getLogger(self::CHANNEL_NAME);
        $this->levelMapper = new LevelMapper();
    }

    /**
     * Backward compatibility layer
     *
     * @param $method
     * @param $arguments
     */
    public function __call($method, $arguments)
    {
        $message = array_shift($arguments);

        $this->log($this->levelMapper->toPsr($method), $message);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = [])
    {
        $message = 'Hint: ' . $message;
        $this->logger->log($level, $message, $context);
    }

    /**
     * Get log level option
     * @return mixed
     */
    public static function getLogLevelOptions()
    {
        $levels = [];
        foreach (array_keys(LevelMapper::PSR_TO_SUGAR_MAP) as $level) {
            $levels[$level] = ucfirst($level);
        }

        return $levels;
    }
}
