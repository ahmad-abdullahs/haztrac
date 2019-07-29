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

class AccountsetTypeUpdateEvent extends AccountsetEvent
{
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
        $accountset = $this->getAccountset($this->data['accountsetId'] ?? '');
        if (!$accountset) {
            return $rows;
        }

        // process old type
        $accounts = $this->getAccountsByType($this->data['oldType'] ?? '', [
            'user_id' => $accountset->assigned_user_id,
            'tag_ids' => $this->data['oldTagIds'] ?? [],
        ]);
        foreach ($accounts as $accountData) {
            $rows[] = [
                'type' => EventTypes::ACCOUNT_DELETE_ONE,
                'data' => array_merge(['accountsetId' => $accountset->id], $accountData),
            ];
        }

        // process new type
        $accounts = $this->getAccountsByType($this->data['newType'] ?? '', [
            'user_id' => $accountset->assigned_user_id,
            'tag_ids' => $this->data['newTagIds'] ?? [],
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
