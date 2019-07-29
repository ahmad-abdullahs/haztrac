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

abstract class AccountEvent extends QueueEvent
{
    /**
     * Extracts account data from event data
     *
     * @return array
     */
    protected function getAccountData()
    {
        return [
            'accountId' => $this->getDefinedValue($this->data, ['accountId', 'id']),
            'name' => $this->getDefinedValue($this->data, ['name', 'accountName']),
            'website' => $this->getDefinedValue($this->data, ['website', 'accountWebsite']),
        ];
    }

    /**
     * Get accountset ids by user id and accountset type
     * @param $userId
     * @param $type
     * @return array
     * @throws \SugarQueryException
     */
    protected function getAccountsetIdsByUserIdAndType(string $userId, string $type): array
    {
        if (!$userId || !$type) {
            return [];
        }

        $query = new \SugarQuery();
        $query->select(['id']);
        $query
            ->from(\BeanFactory::newBean('HintAccountsets'))
            ->where()
            ->equals('assigned_user_id', $userId)
            ->equals('type', $type);

        $rows = $query->execute();

        return array_column($rows, 'id');
    }

    /**
     * Get accountset ids by tag id
     * @param $tagId
     * @return array
     */
    protected function getAccountsetIdsByTagId(string $tagId): array
    {
        if (!$tagId) {
            return [];
        }

        try {
            $tag = $this->getTag($tagId);
            if ($tag && $tag->load_relationship('hint_accountsets_link')) {
                // we need just ids which are accessible right after "load_relationship"
                return array_column($tag->hint_accountsets_link->rows, 'id');
            }
        } catch (\Throwable $e) {
            $this->logger->alert(sprintf('Problem getting accountset ids for tag: %s', $e->getMessage()));
        }

        return [];
    }

    /**
     * Get tag by id
     * @param $id
     * @return mixed
     */
    protected function getTag($id)
    {
        return \BeanFactory::retrieveBean('Tags', $id);
    }
}
