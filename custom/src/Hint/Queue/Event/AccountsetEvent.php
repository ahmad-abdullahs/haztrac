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

use Sugarcrm\Sugarcrm\custom\modules\HintAccountsets\HintAccountsetTypes;

abstract class AccountsetEvent extends QueueEvent
{
    /**
     * Get accountset by id
     * @param $id
     * @return mixed
     */
    protected function getAccountset(string $id)
    {
        return \BeanFactory::retrieveBean('HintAccountsets', $id);
    }

    /**
     * Get accounts by type
     * @param string $type
     * @param array $context
     * @return array
     */
    protected function getAccountsByType(string $type, array $context): array
    {
        if (!$type) {
            return [];
        }

        $accounts = [];
        switch ($type) {
            case HintAccountsetTypes::OWNER:
                $accounts = $this->getAccountsByUserId($context['user_id'] ?? '');
                break;
            case HintAccountsetTypes::FAVORITES:
                $accounts = $this->getFavoriteAccountsByUserId($context['user_id'] ?? '');
                break;
            case HintAccountsetTypes::TAGS:
                $accounts = $this->getAccountsByTagIds($context['tag_ids'] ?? []);
                break;
            default:
                break;
        }

        return $accounts;
    }

    /**
     * @param $userId
     * @return array
     * @throws \SugarQueryException
     */
    protected function getAccountsByUserId(string $userId): array
    {
        if (!$userId) {
            return [];
        }

        $seed = \BeanFactory::newBean('Accounts');
        $query = new \SugarQuery();
        $query->select([['id', 'account_id'], 'name', 'website', 'assigned_user_id']);
        $query->from($seed, ['alias' => 'accounts'])
            ->where()
            ->equals('assigned_user_id', $userId);

        $accounts = [];
        foreach ($query->execute() as $row) {
            $row = array_change_key_case($row, CASE_LOWER);
            $accounts[] = [
                'accountId' => $row['account_id'],
                'name' => $row['name'],
                'website' => $row['website'],
            ];
        }

        return $accounts;
    }

    /**
     * @param $userId
     * @return array
     * @throws \SugarQueryException
     */
    protected function getFavoriteAccountsByUserId(string $userId): array
    {
        if (!$userId) {
            return [];
        }

        $seed = \BeanFactory::newBean('Accounts');
        $query = new \SugarQuery();
        $query->from($seed, ['alias' => 'accounts']);

        $favoritesJoin = $query->join('favorites', [
            'joinType' => 'INNER',
            'current_user_id' => $userId,
            'favorites' => true
        ]);
        $favsAlias = $favoritesJoin->joinName();

        // we define join aliases before select
        $query->select([
            ['accounts.id', 'account_id'], 'accounts.name', 'accounts.website',
            [$favsAlias . '.id', 'fav_account_id']
        ]);
        $query->where()->notNull($favsAlias . '.id');

        $accounts = [];
        foreach ($query->execute() as $row) {
            $row = array_change_key_case($row, CASE_LOWER);
            $accounts[] = [
                'accountId' => $row['account_id'],
                'name' => $row['name'],
                'website' => $row['website'],
            ];
        }

        return $accounts;
    }

    /**
     * @param array $tagIds
     * @return array
     * @throws \SugarQueryException
     */
    protected function getAccountsByTagIds(array $tagIds): array
    {
        if (!$tagIds) {
            return [];
        }

        $seed = \BeanFactory::newBean('Accounts');
        $query = new \SugarQuery();
        $query->from($seed, ['alias' => 'accounts']);

        $linkName = 'accounts_link';
        $tagsAlias = 'account_tags';
        $tag = \BeanFactory::newBean('Tags');
        if ($tag->load_relationship($linkName)) {
            $tag->accounts_link->buildJoinSugarQuery($query, [
                'joinTableAlias' => $tagsAlias,
                'joinType' => 'INNER',
                'ignoreRole' => false,
                'reverse' => true,
                'includeCustom' => false,
            ]);
            $query->join[$tagsAlias]->addLinkName($linkName);
        }

        // we define join aliases before select
        $query->select([
            ['id', 'account_id'], 'name', 'website',
            [$tagsAlias . '.id', 'account_tag_id']
        ]);

        if (count($tagIds) === 1) {
            $query->where()->equals($tagsAlias . '.id', $tagIds[0]);
        } else {
            $query->where()->in($tagsAlias . '.id', $tagIds);
        }

        $accounts = [];
        foreach ($query->execute() as $row) {
            $row = array_change_key_case($row, CASE_LOWER);
            $accounts[] = [
                'accountId' => $row['account_id'],
                'name' => $row['name'],
                'website' => $row['website'],
            ];
        }

        return $accounts;
    }
}
