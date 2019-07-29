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
namespace Sugarcrm\Sugarcrm\custom\Hint\Config;

use Sugarcrm\Sugarcrm\custom\Hint\Logger;

class Config
{
    /**
     * @var \SugarConfig
     */
    protected $sugarConfig;

    /**
     * @var \Configurator
     */
    protected $configurator;


    /**
     * Config constructor.
     * @param \SugarConfig $sugarConfig
     */
    public function __construct(\SugarConfig $sugarConfig = null)
    {
        $this->sugarConfig = $sugarConfig ?? $this->getSugarConfig();
        $this->configurator = $this->getConfigurator();
    }

    /**
     * Get config value
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getValue($key, $default = null)
    {
        return $this->sugarConfig->get($key, $default);
    }

    /**
     * Set config value
     *
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function setValue($key, $value)
    {
        $this->configurator->config[$key] = $value;
        $this->configurator->handleOverride();

        // purge cache entries (cache refresh)
        $this->sugarConfig->clearCache($key);

        return $this->sugarConfig->get($key);
    }

    /**
     * Checks if Hint Insights is enabled
     * @return bool
     */
    public function isInsightsEnabled(): bool
    {
        return (bool)$this->getValue('hint.insights.enabled', true);
    }

    /**
     * Get logger config
     * @return array
     */
    public function getLoggerConfig(): array
    {
        $levelMapper = new Logger\LevelMapper();

        return [
            /*
             * Log level for SugarLogger "hint" channel (PSR format)
             * Defaults to SugarLogger level
             */
            'level' => $this->getValue('logger.channels.hint.level',
                $levelMapper->toPsr($this->getValue('logger.level', 'fatal'))
            ),
        ];
    }

    /**
     * Set logger config
     * @param array $config
     * @return array
     */
    public function setLoggerConfig(array $config = []): array
    {
        $loggerConfig = $this->getLoggerConfig();

        $level = $config['level'] ?? '';
        if ($level) {
            $levelMapper = new Logger\LevelMapper();
            $loggerConfig['level'] = $levelMapper->toPsr($level);
        }

        // respect manual changes
        $this->configurator->config['logger']['channels']['hint'] = array_merge(
            $this->getValue('logger.channels.hint', []),
            $loggerConfig
        );
        $this->configurator->handleOverride();

        // purge cache entries (cache refresh)
        $this->sugarConfig->clearCache('logger.channels.hint');
        $this->sugarConfig->clearCache('logger.channels.hint.level');

        return $loggerConfig;
    }

    /**
     * Unset logger config
     */
    public function unsetLoggerConfig(): void
    {
        unset($this->configurator->config['logger']['channels']['hint']);
        $this->configurator->handleOverride();

        // purge cache entries (cache refresh)
        $this->sugarConfig->clearCache('logger.channels.hint');
        $this->sugarConfig->clearCache('logger.channels.hint.level');
    }

    /**
     * Get event queue config
     * @return array
     */
    public function getQueueConfig(): array
    {
        return [
            /*
             * Max number of events we can process per QueueProcessor run
             * Defaults to 1000 rows. This value should be more than enough to fit
             * into 10MB payload size limit.
             */
            'fetch_bulk_size' => (int)$this->getValue('hint.insights.queue.fetch_bulk_size', 1000),

            /*
             * Max number of records we can insert to queue within 1 INSERT query
             * Defaults to 500 records. This value should be enough to fit into MySQL
             * max_allowed_packet (4194304):
             * 500 (rows) * (36 + 20 + (250 * 4) + 36 + 20 + 26) (chars/row) < 4194304
             *
             */
            'insert_bulk_size' => (int)$this->getValue('hint.insights.queue.insert_bulk_size', 500),

            /*
             * Max time an event can be in "processing" mode (seconds)
             * Defaults to 5 min
             */
            'max_processing_time' => (int)$this->getValue('hint.insights.queue.max_processing_time', 5 * 60),

            /*
             * Keeps entries from being removed from the queue so they can be retried again and again
             * Aka "dev mode" - defaults to false
             */
            'keep_rows' => (bool)$this->getValue('hint.insights.queue.keep_rows', false),
        ];
    }

    /**
     * Get sugar config
     * @return \SugarConfig
     */
    protected function getSugarConfig(): \SugarConfig
    {
        return \SugarConfig::getInstance();
    }

    /**
     * Get configurator
     * @return \Configurator
     */
    protected function getConfigurator(): \Configurator
    {
        return new \Configurator();
    }
}
