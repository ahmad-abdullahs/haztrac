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

use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountOwnerAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountOwnerDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetAddTagEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetDeleteTagEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetTypeUpdateEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountTagAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountTagDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\FavoriteAccountAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\FavoriteAccountDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\QueueEventInterface;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\UserDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\UserEmailUpdateEvent;

class EventConverter
{
    const TYPE_TO_CLASS_MAP = [
        EventTypes::FAVORITE_ADD => FavoriteAccountAddEvent::class,
        EventTypes::FAVORITE_DELETE => FavoriteAccountDeleteEvent::class,
        EventTypes::ACCOUNT_DELETE => AccountDeleteEvent::class,
        EventTypes::ACCOUNT_OWNER_ADD => AccountOwnerAddEvent::class,
        EventTypes::ACCOUNT_OWNER_DELETE => AccountOwnerDeleteEvent::class,
        EventTypes::ACCOUNT_TAG_ADD => AccountTagAddEvent::class,
        EventTypes::ACCOUNT_TAG_DELETE => AccountTagDeleteEvent::class,
        EventTypes::USER_DELETE => UserDeleteEvent::class,
        EventTypes::USER_EMAIL_UPDATE => UserEmailUpdateEvent::class,
        EventTypes::ACCOUNTSET_ADD => AccountsetAddEvent::class,
        EventTypes::ACCOUNTSET_TYPE_UPDATE => AccountsetTypeUpdateEvent::class,
        EventTypes::ACCOUNTSET_ADD_TAG => AccountsetAddTagEvent::class,
        EventTypes::ACCOUNTSET_DELETE_TAG => AccountsetDeleteTagEvent::class,
    ];

    /**
     * Converts events to new format
     *
     * @param array $events
     * @return array
     */
    public function convert(array $events): array
    {
        $newEvents = [];

        $oldEventTypes = array_keys(self::TYPE_TO_CLASS_MAP);
        foreach ($events as $event) {
            if (!in_array($event['type'], $oldEventTypes, true)) {
                $newEvents[] = $event;
                continue;
            }

            $oldEvent = $this->createEvent($event['type'], $event['data']);
            foreach ($oldEvent->toQueueRows() as $row) {
                // we inherit some data from old event
                $newEvents[] = array_merge($event, [
                    'type' => $row['type'],
                    'data' => json_encode($row['data'], JSON_UNESCAPED_SLASHES),
                ]);
            }
        }

        return $newEvents;
    }

    /**
     * Event factory
     * @param string $type
     * @param string $data
     * @return QueueEventInterface
     */
    protected function createEvent($type, $data): QueueEventInterface
    {
        $class = self::TYPE_TO_CLASS_MAP[$type];
        $eventData = json_decode($data, true);

        // we use switch to pass package scanner checks
        switch ($class) {
            case FavoriteAccountAddEvent::class:
                return new FavoriteAccountAddEvent($eventData);
            case FavoriteAccountDeleteEvent::class:
                return new FavoriteAccountDeleteEvent($eventData);
            case AccountDeleteEvent::class:
                return new AccountDeleteEvent($eventData);
            case AccountOwnerAddEvent::class:
                return new AccountOwnerAddEvent($eventData);
            case AccountOwnerDeleteEvent::class:
                return new AccountOwnerDeleteEvent($eventData);
            case AccountTagAddEvent::class:
                return new AccountTagAddEvent($eventData);
            case AccountTagDeleteEvent::class:
                return new AccountTagDeleteEvent($eventData);
            case UserDeleteEvent::class:
                return new UserDeleteEvent($eventData);
            case UserEmailUpdateEvent::class:
                return new UserEmailUpdateEvent($eventData);
            case AccountsetAddEvent::class:
                return new AccountsetAddEvent($eventData);
            case AccountsetTypeUpdateEvent::class:
                return new AccountsetTypeUpdateEvent($eventData);
            case AccountsetAddTagEvent::class:
                return new AccountsetAddTagEvent($eventData);
            case AccountsetDeleteTagEvent::class:
                return new AccountsetDeleteTagEvent($eventData);
            default:
                throw new \InvalidArgumentException(sprintf('Not supported event class: "%s"', $class));
        }
    }
}
