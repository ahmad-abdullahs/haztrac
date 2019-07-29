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
namespace Sugarcrm\Sugarcrm\custom\modules\Accounts;

use Sugarcrm\Sugarcrm\custom\Hint\LogicHook\LogicHook;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountOwnerAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountOwnerDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountTagAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountTagDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountUpdateEvent;

class HintAccountsHook extends LogicHook
{
    // account tag ids cache
    private static $tags = [];

    /**
     * @param \Account $bean
     * @param $event
     * @param $arguments
     */
    public function afterRelationshipAdd(\Account $bean, $event, $arguments)
    {
        if ($arguments['related_module'] === 'Tags'
            && $arguments['relationship'] === 'accounts_tags') {

            // to emit ACCOUNT_OWNER_ADD before ACCOUNT_TAG_ADD
            if (!$bean->isUpdate()) {
                self::$tags[$bean->id][] = $arguments['related_id'];
                return;
            }

            $accountData = $this->getAccountData($bean);
            $this->eventQueue->recordEvent(new AccountTagAddEvent(array_merge($accountData, [
                'tagId' => $arguments['related_id'],
            ])));

            return;
        }
    }

    /**
     * @param \Account $bean
     * @param $event
     * @param $arguments
     */
    public function afterRelationshipDelete(\Account $bean, $event, $arguments)
    {
        if ($arguments['related_module'] === 'Tags'
            && $arguments['relationship'] === 'accounts_tags') {

            $accountData = $this->getAccountData($bean);
            $this->eventQueue->recordEvent(new AccountTagDeleteEvent(array_merge($accountData, [
                'tagId' => $arguments['related_id'],
            ])));

            return;
        }
    }

    /**
     * @param $bean
     * @param $event
     * @param $arguments
     */
    public function afterSave(\Account $bean, $event, $arguments)
    {
        $accountData = $this->getAccountData($bean);

        // new record case
        if (!$arguments['isUpdate']) {
            $this->eventQueue->recordEvent(new AccountOwnerAddEvent(array_merge($accountData, [
                'userId' => $bean->assigned_user_id,
            ])));

            /**
             * Tag ids for a new account can be cached in after_relationship_add
             * hook. If there are any we add them to ACCOUNT_TAG_ADD payload and clean
             * the cache.
             */
            if (!empty(self::$tags[$bean->id])) {
                foreach (self::$tags[$bean->id] as $tagId) {
                    $this->eventQueue->recordEvent(new AccountTagAddEvent(array_merge($accountData, [
                        'tagId' => $tagId,
                    ])));
                }
                unset(self::$tags[$bean->id]);
            }

            return;
        }

        // updated record case
        $changes = $arguments['dataChanges'];

        // new owner
        if (array_key_exists('assigned_user_id', $changes)) {
            $this->eventQueue->recordEvent(new AccountOwnerDeleteEvent(array_merge($accountData, [
                'userId' => $changes['assigned_user_id']['before'],
            ])));
            $this->eventQueue->recordEvent(new AccountOwnerAddEvent(array_merge($accountData, [
                'userId' => $bean->assigned_user_id,
            ])));
        }

        // simple update
        if (array_key_exists('name', $changes) || array_key_exists('website', $changes)) {
            $oldName = array_key_exists('name', $changes) ? $changes['name']['before'] : $bean->name;
            $oldWebsite = array_key_exists('website', $changes) ? $changes['website']['before'] : $bean->website;
            $this->eventQueue->recordEvent(new AccountUpdateEvent(array_merge($accountData, [
                'oldName' => $oldName,
                'oldWebsite' => $oldWebsite,
            ])));
        }
    }

    /**
     * @param $bean
     * @param $event
     * @param $arguments
     */
    public function afterDelete(\Account $bean, $event, $arguments)
    {
        $accountData = $this->getAccountData($bean);
        $this->eventQueue->recordEvent(new AccountOwnerDeleteEvent(array_merge($accountData, [
            // user is unlinked earlier so "$bean->assigned_user_id" is empty
            'userId' => $bean->fetched_row['assigned_user_id'],
        ])));

        $this->eventQueue->recordEvent(new AccountDeleteEvent($accountData));
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
}
