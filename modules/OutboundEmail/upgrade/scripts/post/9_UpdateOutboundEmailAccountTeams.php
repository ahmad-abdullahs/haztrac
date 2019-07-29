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
/**
 * Upgrade existing report schedules.
 */
class SugarUpgradeUpdateOutboundEmailAccountTeams extends UpgradeDBScript
{
    public $order = 9901;

    /**
     *
     * Execute upgrade tasks
     * This script adds teams to existing OutboundEmail accounts.
     * @see UpgradeScript::run()
     */
    public function run()
    {
        if (version_compare($this->from_version, '9.0.0', '>=')) {
            // do nothing if upgrading from 9.0.0 or newer
            return;
        }

        $query = new SugarQuery();
        $bean = BeanFactory::newBean('OutboundEmail');

        // all records
        $query->from($bean, array('team_security' => false, 'add_deleted' => false, 'alias' => 'oe'));

        // INNER join teams
        $query->joinTable('teams', ['alias' => 't'])
            ->on()->equalsField('t.associated_user_id', 'oe.user_id');

        // LEFT join team_Sets
        $query->joinTable('team_sets', ['alias' => 'ts', 'joinType' => 'LEFT'])
            ->on()->equalsField('ts.id', 't.id');

        $query->select(array(['oe.id', 'oe_id'], ['oe.type','oe_type'], ['t.id', 'team_id'], ['ts.id', 'team_set_id']));

        $rows = $query->execute('array', true);

        foreach ($rows as $row) {
            // for system accounts, team should be Global
            if ($row['oe_type'] === OutboundEmail::TYPE_SYSTEM) {
                $teamId = '1';
                $teamSetId = '1';
            } else {
                $teamId = $row['team_id'];
                // team set does not exist until the user creates a record using private team
                if (empty($row['team_set_id'])) {
                    $teamSetId = $row['team_id'];
                    // This ensures that the team set exists.
                    $teamSet = BeanFactory::newBean('TeamSets');
                    $teamSet->addTeams($teamId);
                } else {
                    $teamSetId = $row['team_set_id'];
                }
            }

            // update team and team_set
            $sql = "UPDATE outbound_email SET team_id = ?, team_set_id = ? WHERE id = ?";
            $this->executeUpdate($sql, [$teamId, $teamSetId, $row['oe_id']]);
        }
    }
}
