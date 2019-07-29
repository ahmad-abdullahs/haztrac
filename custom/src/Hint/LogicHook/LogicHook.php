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
namespace Sugarcrm\Sugarcrm\custom\Hint\LogicHook;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Sugarcrm\Sugarcrm\custom\Hint\Config\ConfigTrait;
use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\QueueTrait;

abstract class LogicHook implements LoggerAwareInterface
{
    use LoggerAwareTrait, ConfigTrait, QueueTrait;


    /**
     * InsightsTrait constructor.
     */
    public function __construct()
    {
        $this->eventQueue = $this->getEventQueue();
        $this->config = $this->getConfig();
        $this->setLogger(new Logger());
    }
}
