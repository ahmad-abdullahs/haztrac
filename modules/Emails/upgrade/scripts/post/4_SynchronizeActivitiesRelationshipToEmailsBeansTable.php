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

class SugarUpgradeSynchronizeActivitiesRelationshipToEmailsBeansTable extends UpgradeDBScript
{
    /**
     * This upgrade script should run after all new modules are installed so that we are certain we have the most
     * up-to-date list of modules.
     *
     * {@inheritdoc}
     * @see SugarUpgradeNewModules::$order SugarUpgradeNewModules runs with 4100.
     */
    public $order = 4101;

    /**
     * {@inheritdoc}
     *
     * Any modules with the Activities relationship might have beans that are parents of emails. These parent
     * relationships must be synchronized to the emails_beans table. This upgrade script finds relationships that are
     * not synchronized to emails_beans and repairs it.
     *
     * This upgrade script only runs when upgrading from a version prior to 8.0.
     */
    public function run()
    {
        if (!version_compare($this->from_version, '8.0', '<')) {
            $this->log("from_version ({$this->from_version}) is not less than 8.0");
            return;
        }

        $modulesWithActivitiesRelationship = $this->getModulesWithActivitiesRelationship();
        $totalEmails = 0;

        do {
            $emails = $this->getEmails($modulesWithActivitiesRelationship);
            $rows = $this->getRowsToInsert($emails);
            $this->linkEmailsToParents($rows);
            $totalEmails += count($emails);
        } while (!empty($emails));

        $this->log("{$totalEmails} emails were added to an activities relationship");
    }

    /**
     * Returns an array of all modules with an Activities relationship.
     *
     * The link name <module>_activities_emails will be used when the Activities relationship is created using Module
     * Builder, before the module is deployed. The link name <module>_activities_1_emails will be used when the
     * Activities relationship is created using Studio.
     *
     * @return array
     */
    protected function getModulesWithActivitiesRelationship()
    {
        $modules = [];
        $email = BeanFactory::newBean('Emails');

        foreach (array_keys($GLOBALS['beanList']) as $module) {
            $moduleLowercase = strtolower($module);
            $activitiesLinkNames = [
                // Studio-generated link name.
                "{$moduleLowercase}_activities_1_emails",
                // Module Builder-generated link name.
                "{$moduleLowercase}_activities_emails",
            ];

            $bean = BeanFactory::newBean($module);
            $linkName = $bean instanceof SugarBean ? $email->findEmailsLink($bean) : false;

            // We only care about activities links. Presumably, all other links have been persisted as expected.
            if ($linkName && in_array($linkName, $activitiesLinkNames)) {
                $this->log("{$module} has an activities link named {$linkName}");
                $modules[] = $module;
            }
        }

        return $modules;
    }

    /**
     * Returns an array of all emails that have a parent whose module is found in $parentModules and whose parent
     * relationship is not synchronized to the emails_beans table.
     *
     * @param array $parentModules
     * @return array
     */
    protected function getEmails(array $parentModules)
    {
        $this->log('Finding emails that need to be added to an activities relationship');

        $emails = [];
        $idsByModule = [];

        foreach ($parentModules as $parentModule) {
            $idsByModule[$parentModule] = [];
        }

        try {
            $parentType = "'" . implode("','", $parentModules) . "'";
            $sql = 'SELECT emails.id, emails.parent_type, emails.parent_id FROM emails WHERE ' .
                $GLOBALS['db']->getNotEmptyFieldSQL('emails.parent_id') .
                " AND emails.parent_type IN ({$parentType}) AND " .
                'emails.deleted=0 AND NOT EXISTS (SELECT emails_beans.id FROM emails_beans WHERE ' .
                'emails_beans.email_id=emails.id AND emails_beans.bean_module=emails.parent_type AND ' .
                'emails_beans.bean_id=emails.parent_id AND emails_beans.deleted=0)';
            $result = $this->db->limitQuery($sql, 0, 100000);

            while ($row = $this->db->fetchByAssoc($result)) {
                $emails[$row['id']] = [
                    'id' => $row['id'],
                    'parent_type' => $row['parent_type'],
                    'parent_id' => $row['parent_id'],
                ];
                $idsByModule[$row['parent_type']][] = $row['id'];
            }
        } catch (Exception $e) {
            $this->log('Error: ' . $e->getMessage());
        }

        foreach ($idsByModule as $module => $ids) {
            $this->log('Found ' . count($ids) . " emails with parent_type={$module}: " . implode(', ', $ids));
        }

        return $emails;
    }

    /**
     * Get all of the rows to insert into the emails_beans table.
     *
     * @param array $emails The emails to link.
     * @return array
     */
    private function getRowsToInsert(array $emails)
    {
        $rows = [];

        foreach ($emails as $email) {
            $rows[] = $this->getRowToInsert($email);
        }

        return $rows;
    }

    /**
     * Get the values to insert into the emails_beans table.
     *
     * @param array $email Contains data about the email to link to its parent record.
     * @return string
     */
    private function getRowToInsert(array $email)
    {
        $row = [
            $this->db->quoted(\Sugarcrm\Sugarcrm\Util\Uuid::uuid1()),
            $this->db->quoted($email['id']),
            $this->db->quoted($email['parent_type']),
            $this->db->quoted($email['parent_id']),
            $this->db->quoted(TimeDate::getInstance()->nowDb()),
            0,
        ];

        return '(' . implode(',', $row) . ')';
    }

    /**
     * Save the Activities relationships to the database.
     *
     * @param array $rows The rows to insert into the emails_beans table.
     */
    private function linkEmailsToParents(array $rows)
    {
        $totalRows = count($rows);

        if ($totalRows === 0) {
            $this->log('No emails to link to their parent records');
            return;
        }

        $this->log("Linking {$totalRows} emails to their parent records");

        try {
            $sql = 'INSERT INTO emails_beans (id,email_id,bean_module,bean_id,date_modified,deleted) VALUES ' .
                implode(',', $rows);
            $affectedRows = $this->executeUpdate($sql);
            $failures = $totalRows - $affectedRows;

            if ($affectedRows > 0) {
                $this->log("Successfully linked {$affectedRows} emails to their parent records");
            }

            if ($failures > 0) {
                $this->log("Failed to link {$failures} emails to their parent records");
            }
        } catch (Exception $e) {
            $this->log('Error: ' . $e->getMessage());
        }
    }
}
