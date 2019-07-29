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

use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger as HintLogger;
use Sugarcrm\Sugarcrm\custom\Hint\Manager as HintManager;
use Sugarcrm\Sugarcrm\custom\Hint\Iss\Manager as IssManager;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class QueueProcessor implements LoggerAwareInterface
{
    use LoggerAwareTrait, QueueTrait;

    /**
     * @var EventConverter
     */
    private $eventConverter;

    /**
     * @var ProcessorFactory
     */
    private $processorFactory;

    /**
     * @var IssManager
     */
    private $issManager;


    /**
     * EventQueueProcessor constructor.
     */
    public function __construct()
    {
        $this->eventQueue = $this->getEventQueue();
        $this->eventConverter = $this->getEventConverter();
        $this->processorFactory = $this->getProcessorFactory();
        $this->issManager = $this->getIssManager();
        $this->setLogger(new HintLogger());
    }

    /**
     * Processes queue items and sends results to ISS
     */
    public function processQueue()
    {
        $this->eventQueue->resetStaleEvents();

        $events = $this->eventQueue->getQueuedEvents();
        // nothing to process, exit early
        if (!$events) {
            return;
        }

        $issCommands = [];
        try {
            foreach ($this->eventConverter->convert($events) as $event) {
                $this->logger->info(sprintf('Got event "%s": %s', $event['type'], $event['data']));

                $eventData = json_decode($event['data'], true);
                $command = $this->processorFactory->getProcessor($event['type'])($eventData);
                $this->logger->debug('ISS command: ' . var_export($command, true));

                array_push($issCommands, $command);
            }

            $this->issManager->sendCommands($issCommands);

            // only when we have successfully processed all the events
            $this->eventQueue->finishedProcessingEvents();
        } catch (\Throwable $e) {
            $this->logger->alert(sprintf('Problem processing event queue, error: %s', $e->getMessage()));
        }
    }

    /**
     * Get processor factory
     * @return ProcessorFactory
     */
    protected function getProcessorFactory(): ProcessorFactory
    {
        return new ProcessorFactory();
    }

    /**
     * This is a temporary layer to handle old types of events (from 5.0.2) which
     * already exist in the queue. We can completely remove it after some releases.
     * @return EventConverter
     */
    protected function getEventConverter(): EventConverter
    {
        return new EventConverter();
    }

    /**
     * Get ISS manager
     * @return IssManager
     */
    protected function getIssManager(): IssManager
    {
        $hintManager = HintManager::instance();

        return new IssManager($hintManager->issServiceUrl);
    }
}
