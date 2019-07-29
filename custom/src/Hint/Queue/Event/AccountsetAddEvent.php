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

class AccountsetAddEvent extends AccountsetEvent
{
    /**
     * AccountsetAddEvent constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // expected event data fields
        $fields = ['accountsetId', 'type', 'category', 'targetIds', 'tagIds'];

        // add optional fields
        $data['targetIds'] = $data['targetIds'] ?? [];
        $data['tagIds'] = $data['tagIds'] ?? [];

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
        return EventTypes::MIXED;
    }

    /**
     * Converts event to format compatible with event queue
     * @return array
     */
    public function toQueueRows(): array
    {
        $rows = [];

        // check accountset existence
        $accountset = $this->getAccountset($this->data['accountsetId']);
        if (!$accountset) {
            return $rows;
        }

        $eventData = array_intersect_key($this->data, array_flip(['type', 'accountsetId', 'category', 'targetIds']));
        $rows[] = [
            'type' => EventTypes::ACCOUNTSET_ADD_ONE,
            'data' => $eventData,
        ];

        // process items related to new accountset
        $accounts = $this->getAccountsByType($this->data['type'], [
            'user_id' => $accountset->assigned_user_id,
            'tag_ids' => $this->data['tagIds'],
        ]);
        foreach ($accounts as $accountData) {
            $rows[] = [
                'type' => EventTypes::ACCOUNT_ADD_ONE,
                'data' => array_merge(['accountsetId' => $accountset->id], $accountData),
            ];
        }

        return $rows;
    }
}
