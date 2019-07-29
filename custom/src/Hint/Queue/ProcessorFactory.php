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

use Sugarcrm\Sugarcrm\custom\Hint\Iss\Commands;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor\AccountAddProcessor;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor\AccountDeleteAllProcessor;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor\AccountDeleteProcessor;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor\AccountUpdateProcessor;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor\InstanceInitProcessor;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor\InstanceResyncProcessor;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor\ProcessorInterface;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor\SimpleEventProcessor;

class ProcessorFactory
{
    const TYPE_TO_COMMAND_MAP = [
        EventTypes::INSTANCE_INIT => Commands::ISS_RECORD_NEW_INSTANCE,
        EventTypes::INSTANCE_RESYNC => Commands::ISS_SYNCHRONIZE_INSTANCE,

        EventTypes::ACCOUNT_ADD_ONE => Commands::ISS_ADD_ACCOUNT,
        EventTypes::ACCOUNT_DELETE_ONE => Commands::ISS_DELETE_ACCOUNT,
        EventTypes::ACCOUNT_DELETE_ALL => Commands::ISS_DELETE_ACCOUNT_ALL,
        EventTypes::ACCOUNT_UPDATE => Commands::ISS_UPDATE_ACCOUNT_ALL,

        EventTypes::ACCOUNTSET_ADD_ONE => Commands::ISS_ADD_ACCOUNTSET,
        EventTypes::ACCOUNTSET_DELETE => Commands::ISS_DELETE_ACCOUNTSET,
        EventTypes::ACCOUNTSET_DELETE_ALL => Commands::ISS_DELETE_ACCOUNTSETS,
        EventTypes::ACCOUNTSET_UPDATE => Commands::ISS_UPDATE_ACCOUNTSET,

        EventTypes::ACCOUNTSET_ADD_TARGET => Commands::ISS_ADD_TARGET_TO_ACCOUNTSET,
        EventTypes::ACCOUNTSET_DELETE_TARGET => Commands::ISS_DELETE_TARGET_FROM_ACCOUNTSET,

        EventTypes::TARGET_ADD => Commands::ISS_ADD_TARGET,
        EventTypes::TARGET_DELETE_ALL => Commands::ISS_DELETE_TARGETS,
        EventTypes::TARGET_UPDATE => Commands::ISS_UPDATE_TARGET,
    ];

    public static $CACHE = [];

    /**
     * Get processor instance
     *
     * @param $type
     * @return callable
     */
    public function getProcessor($type): callable
    {
        if (isset(self::$CACHE[$type])) {
            return self::$CACHE[$type];
        }

        if (isset(self::TYPE_TO_COMMAND_MAP[$type])) {
            self::$CACHE[$type] = $this->createProcessor($type);

            return self::$CACHE[$type];
        }

        throw new \RuntimeException(sprintf('Processor for type "%s" not found', $type));
    }

    /**
     * Processor factory
     * @param $type
     * @return ProcessorInterface
     */
    protected function createProcessor($type): ProcessorInterface
    {
        $command = self::TYPE_TO_COMMAND_MAP[$type];

        // we use switch to pass package scanner checks
        switch ($type) {
            case EventTypes::INSTANCE_INIT:
                return new InstanceInitProcessor($command);
            case EventTypes::INSTANCE_RESYNC:
                return new InstanceResyncProcessor($command);

            case EventTypes::ACCOUNT_ADD_ONE:
                return new AccountAddProcessor($command);
            case EventTypes::ACCOUNT_DELETE_ONE:
                return new AccountDeleteProcessor($command);
            case EventTypes::ACCOUNT_DELETE_ALL:
                return new AccountDeleteAllProcessor($command);
            case EventTypes::ACCOUNT_UPDATE:
                return new AccountUpdateProcessor($command);

            case EventTypes::ACCOUNTSET_ADD_ONE:
            case EventTypes::ACCOUNTSET_DELETE:
            case EventTypes::ACCOUNTSET_DELETE_ALL:
            case EventTypes::ACCOUNTSET_UPDATE:
            case EventTypes::ACCOUNTSET_ADD_TARGET:
            case EventTypes::ACCOUNTSET_DELETE_TARGET:
            case EventTypes::TARGET_ADD:
            case EventTypes::TARGET_DELETE_ALL:
            case EventTypes::TARGET_UPDATE:
                return new SimpleEventProcessor($command);

            default:
                throw new \InvalidArgumentException(sprintf('Not supported event type: "%s"', $type));
        }
    }
}
