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
namespace Sugarcrm\Sugarcrm\custom\modules\SugarFavorites;

use Sugarcrm\Sugarcrm\custom\Hint\LogicHook\LogicHook;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\FavoriteAccountAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\FavoriteAccountDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Queue;

class HintSugarFavoritesHook extends LogicHook
{
    /**
     * @param $bean
     * @param $event
     * @param $arguments
     */
    public function afterSave(\SugarFavorites $bean, $event, $arguments)
    {
        $this->processFavorite(FavoriteAccountAddEvent::class, $bean);
    }

    /**
     * @param $bean
     * @param $event
     * @param $arguments
     */
    public function afterRestore(\SugarFavorites $bean, $event, $arguments)
    {
        $this->processFavorite(FavoriteAccountAddEvent::class, $bean);
    }

    /**
     * @param $bean
     * @param $event
     * @param $arguments
     */
    public function beforeDelete(\SugarFavorites $bean, $event, $arguments)
    {
        $this->processFavorite(FavoriteAccountDeleteEvent::class, $bean);
    }

    /**
     * Adds favorite event to Hint event queue
     *
     * @param $eventClass
     * @param \SugarFavorites $favorite
     * @return bool
     */
    private function processFavorite($eventClass, \SugarFavorites $favorite)
    {
        $data = $this->getFavoriteEventData($favorite);
        if (!$data) {
            return;
        }

        // we use switch to pass package scanner checks
        switch ($eventClass) {
            case FavoriteAccountAddEvent::class:
                return $this->eventQueue->recordEvent(new FavoriteAccountAddEvent($data));
            case FavoriteAccountDeleteEvent::class:
                return $this->eventQueue->recordEvent(new FavoriteAccountDeleteEvent($data));
            default:
                throw new \InvalidArgumentException(sprintf('Not supported event class: "%s"', $eventClass));
        }
    }

    /**
     * Maps Account to ISS data (event queue record)
     *
     * @param \Account $account
     * @return array
     */
    protected function getAccountData(\Account $account)
    {
        return [
            'accountId' => $account->id,
            'name' => $account->name,
            'website' => $account->website,
        ];
    }

    /**
     * Get favorite event data
     *
     * @param \SugarFavorites $favorite
     * @return array
     */
    protected function getFavoriteEventData(\SugarFavorites $favorite)
    {
        global $current_user;

        // "module" here is \SugarFavorites field and not "module_name" from "basic" \SugarBean template
        if ($favorite->module === 'Accounts') {
            /* @var $account \Account */
            $account = $this->getAccount($favorite->record_id);
            if ($account) {
                $data = $this->getAccountData($account);

                return array_merge($data, [
                    // current user (not favorite assignee)
                    'userId' => $current_user->id,
                ]);
            }
        }

        return [];
    }

    /**
     * Get Account by id
     * @param $id
     * @return mixed
     */
    protected function getAccount($id)
    {
        return \BeanFactory::retrieveBean('Accounts', $id);
    }
}
