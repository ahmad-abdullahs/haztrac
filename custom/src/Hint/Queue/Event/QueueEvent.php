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
namespace Sugarcrm\Sugarcrm\custom\Hint\Queue\Event;

use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger as HintLogger;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

abstract class QueueEvent implements QueueEventInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var array
     */
    protected $data;


    /**
     * QueueEvent constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;

        $this->setLogger(new HintLogger());
    }

    /**
     * Converts event to format compatible with event queue
     * @return array
     */
    public function toQueueRows(): array
    {
        return [
            [
                'type' => $this->getEventType(),
                'data' => $this->data,
            ],
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s ( %s )', get_class($this), json_encode($this->data, JSON_UNESCAPED_SLASHES));
    }

    /**
     * Gets the first available value from the list
     * @param array $data
     * @param array $fields
     * @return mixed|null
     */
    protected function getDefinedValue(array $data, array $fields = [])
    {
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                return $data[$field];
            }
        }

        return null;
    }
}
