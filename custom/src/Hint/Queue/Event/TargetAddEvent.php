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

use Sugarcrm\Sugarcrm\custom\Hint\Queue\EventTypes;

class TargetAddEvent extends QueueEvent
{
    /**
     * TargetAddEvent constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // expected event data fields
        $fields = ['targetId', 'type', 'credentials'];

        parent::__construct(array_intersect_key($data, array_flip($fields)));

        if (count(array_keys($this->data)) !== count($fields)) {
            $this->logger->alert(sprintf('Invalid event data: %s', $this));
        }
    }

    /**
     * Get event type
     * @return string
     */
    public function getEventType(): string
    {
        return EventTypes::TARGET_ADD;
    }
}
