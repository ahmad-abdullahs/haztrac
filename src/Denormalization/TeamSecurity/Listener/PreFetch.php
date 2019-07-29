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

namespace Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Listener;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Listener;

/**
 * Manages pre-fetched user team set cache
 */
final class PreFetch implements Listener
{
    /**
     * @var Connection
     */
    private $conn;

    /**
     * Constructor
     *
     * @param Connection $conn
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * {@inheritDoc}
     */
    public function userDeleted($userId)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function teamDeleted($teamId)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function teamSetCreated($teamSetId, array $teamIds)
    {
        $query = <<<'SQL'
SELECT DISTINCT user_id
  FROM team_memberships
 WHERE team_id IN(?)
   AND deleted = 0
SQL
        ;

        $stmt = $this->conn->executeQuery($query, [$teamIds], [Connection::PARAM_STR_ARRAY]);
        $stmt->setFetchMode(FetchMode::COLUMN);

        foreach ($stmt as $userId) {
            $this->clearCache($userId);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function teamSetDeleted($teamSetId)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function userAddedToTeam($userId, $teamId)
    {
        $this->clearCache($userId);
    }

    /**
     * {@inheritDoc}
     */
    public function userRemovedFromTeam($userId, $teamId)
    {
        $this->clearCache($userId);
    }

    /**
     * Clears prefetched team set cache for a given user
     *
     * @param string $userId
     *
     * @see TeamSet::getTeamSetIdsForUser()
     */
    private function clearCache(string $userId) : void
    {
        sugar_cache_clear('teamSetIdByUser' . $userId);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return sprintf('PreFetch()');
    }
}
