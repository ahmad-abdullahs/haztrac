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
namespace Sugarcrm\Sugarcrm\custom\modules\HintAccountsets;

use Sugarcrm\Sugarcrm\custom\Hint\LogicHook\LogicHook;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetAddEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetAddTagEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetAddTargetEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetDeleteTagEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetDeleteTargetEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetTypeUpdateEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\AccountsetUpdateEvent;

class HintAccountsetsHook extends LogicHook
{
    /**
     * @param \HintAccountset $bean
     * @param $event
     * @param $arguments
     */
    public function afterRelationshipAdd(\HintAccountset $bean, $event, $arguments)
    {
        // process tags
        if ($arguments['related_module'] === 'Tags' &&
            $arguments['relationship'] === 'hintaccountsets_tags') {

            /**
             * Accountset "type" was changed to "tags" (is handled in "after_save")
             *
             * ACCOUNTSET_UPDATE_TYPE is responsible for ACCOUNTSET_ADD_TAG logic in this case
             * EventProcessor will send some:
             * - ISS_DELETE_ACCOUNT commands for old type
             * - ISS_ADD_ACCOUNT commands for each added tag
             */
            if ($bean->isUpdate() && $bean->fetched_row['type'] !== $bean->type
                && $bean->type === HintAccountsetTypes::TAGS) {
                return;
            }

            /**
             * New accountset with some tags (is handled in "after_save")
             *
             * ACCOUNTSET_ADD is responsible for ACCOUNTSET_ADD_TAG logic in this case
             * EventProcessor will send some ISS_ADD_ACCOUNT commands for each added tag
             */
            if (!$bean->isUpdate()) {
                return;
            }

            // tag is added to existing accountset (ACCOUNTSET_ADD_TAG)
            $this->eventQueue->recordEvent(new AccountsetAddTagEvent([
                'accountsetId' => $bean->id,
                'tagId' => $arguments['related_id'],
            ]));

            return;
        }

        // process targets
        if ($arguments['link'] === 'notification_targets') {
            /**
             * New accountset with some targets (is handled in "after_save")
             *
             * ACCOUNTSET_ADD is responsible for ACCOUNTSET_ADD_TARGET logic in this case
             * EventProcessor will send an ISS_ADD_TARGET_TO_ACCOUNTSET command for each added target
             */
            if (!$bean->isUpdate()) {
                return;
            }

            // target is added to existing accountset (ACCOUNTSET_ADD_TARGET)
            $target = \BeanFactory::retrieveBean('HintNotificationTargets', $arguments['related_id']);
            if ($target) {
                $this->eventQueue->recordEvent(new AccountsetAddTargetEvent([
                    'accountsetId' => $bean->id,
                    'targetId' => $target->id,
                    'type' => $target->type,
                ]));
            }
        }
    }

    /**
     * @param \HintAccountset $bean
     * @param $event
     * @param $arguments
     */
    public function afterRelationshipDelete(\HintAccountset $bean, $event, $arguments)
    {
        // process tags
        if ($arguments['related_module'] === 'Tags'
            && $arguments['relationship'] === 'hintaccountsets_tags') {

            /**
             * Tag is deleted from accountset when accountset type is changed from "tags"
             * to something else
             *
             * ACCOUNTSET_UPDATE_TYPE is responsible for ACCOUNTSET_DELETE_TAG logic in this case
             * EventProcessor will send some ISS_DELETE_ACCOUNT commands for each deleted tag
             */
            if (\HintAccountset::inOperation('accountset_type_change')) {
                return;
            }

            // tag is deleted from accountset
            $this->eventQueue->recordEvent(new AccountsetDeleteTagEvent([
                'accountsetId' => $bean->id,
                'tagId' => $arguments['related_id'],
            ]));

            return;
        }

        // process targets
        if ($arguments['link'] === 'notification_targets') {

            // target is deleted from accountset
            $this->eventQueue->recordEvent(new AccountsetDeleteTargetEvent([
                'accountsetId' => $bean->id,
                'targetId' => $arguments['related_id'],
            ]));

            return;
        }
    }

    /**
     * @param \HintAccountset $bean
     * @param $event
     * @param $arguments
     */
    public function afterSave(\HintAccountset $bean, $event, $arguments)
    {
        // process changes to existing record
        if ($arguments['isUpdate']) {
            $this->afterUpdate($bean, $arguments);

            return;
        }

        // process a new record

        $accountsetData = [
            'accountsetId' => $bean->id,
            'type' => $bean->type,
            'category' => $bean->category,
            'targetIds' => [],
            'tagIds' => [],
        ];

        if ($bean->load_relationship('notification_targets')) {
            $bean->notification_targets->load();
            $accountsetData['targetIds'] = array_column($bean->notification_targets->rows, 'id');
        }

        if ($bean->type === HintAccountsetTypes::TAGS) {
            if ($bean->load_relationship('tag_link')) {
                $bean->tag_link->load();
                $accountsetData['tagIds'] = array_column($bean->tag_link->rows, 'id');
            }
        }

        $this->eventQueue->recordEvent(new AccountsetAddEvent($accountsetData));
    }

    /**
     * @param \HintAccountset $bean
     * @param $event
     * @param $arguments
     */
    public function afterDelete(\HintAccountset $bean, $event, $arguments)
    {
        $this->eventQueue->recordEvent(new AccountsetDeleteEvent([
            'accountsetId' => $bean->id,
        ]));
    }

    /**
     * @param \HintAccountset $bean
     * @param $arguments
     */
    private function afterUpdate(\HintAccountset $bean, $arguments)
    {
        // new accountset category
        if (!empty($arguments['dataChanges']['category'])) {
            $accountsetData = [
                'accountsetId' => $bean->id,
                'category' => $bean->category,
                'targetIds' => [],
            ];

            // load targets
            if ($bean->load_relationship('notification_targets')) {
                $bean->notification_targets->load();
                $accountsetData['targetIds'] = array_column($bean->notification_targets->rows, 'id');
            }

            $this->eventQueue->recordEvent(new AccountsetUpdateEvent($accountsetData));
        }

        // new accountset type
        if (!empty($arguments['dataChanges']['type'])) {
            \HintAccountset::enterOperation('accountset_type_change');

            $oldType = $arguments['dataChanges']['type']['before'];
            $newType = $arguments['dataChanges']['type']['after'];

            $accountsetData = [
                'accountsetId' => $bean->id,
                'oldType' => $oldType,
                'newType' => $newType,
                'oldTagIds' => [],
                'newTagIds' => [],
            ];

            if ($oldType === HintAccountsetTypes::TAGS) {
                if ($bean->load_relationship('tag_link')) {
                    $bean->tag_link->load();
                    $accountsetData['oldTagIds'] = array_column($bean->tag_link->rows, 'id');

                    // clean accountset
                    $bean->tag_link->delete($bean->id);
                }
            }

            if ($newType === HintAccountsetTypes::TAGS) {
                if ($bean->load_relationship('tag_link')) {
                    $bean->tag_link->load();
                    $accountsetData['newTagIds'] = array_column($bean->tag_link->rows, 'id');
                }
            }

            // update accountset type
            $this->eventQueue->recordEvent(new AccountsetTypeUpdateEvent($accountsetData));

            \HintAccountset::leaveOperation('accountset_type_change');
        }
    }
}
