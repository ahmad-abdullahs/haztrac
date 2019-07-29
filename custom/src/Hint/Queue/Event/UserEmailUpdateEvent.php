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
use Sugarcrm\Sugarcrm\custom\modules\HintNotificationTargets\NotificationTargetTypes;

class UserEmailUpdateEvent extends QueueEvent
{
    /**
     * Get processor type for this event
     * @return string
     */
    public function getEventType(): string
    {
        return EventTypes::TARGET_UPDATE;
    }

    /**
     * Converts event to format compatible with event queue
     * @return array
     */
    public function toQueueRows(): array
    {
        $rows = [];

        $targets = $this->getEmailTargetsByUserId($this->data['userId'] ?? '', ['id', 'credentials']);
        foreach ($targets as $target) {
            $credentials = json_decode($target['credentials'], true);
            $rows[] = [
                'type' => $this->getEventType(),
                'data' => [
                    'targetId' => $target['id'],
                    'credentials' => array_merge($credentials, [
                        'email' => $this->data['newEmailAddress'],
                        'timezone' => $this->data['newTimezone'],
                    ])
                ],
            ];
        }

        return $rows;
    }

    /**
     * @param $userId
     * @param array $fields
     * @return array
     * @throws \SugarQueryException
     */
    protected function getEmailTargetsByUserId(string $userId, array $fields = ['id', 'credentials']): array
    {
        if (!$userId) {
            return [];
        }

        $query = new \SugarQuery();

        if ($fields) {
            $query->select($fields);
        }

        $query->from(\BeanFactory::newBean('HintNotificationTargets'))
            ->where()
            ->equals('assigned_user_id', $userId)
            ->in('type', NotificationTargetTypes::getEmailTypes());

        return $query->execute();
    }
}
