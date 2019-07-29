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

class SugarUpgradeSynchronizeTasksRelationshipToEmailsBeansTable extends UpgradeDBScript
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
     * Prior to 7.10, the relationship between Emails and Tasks did not include a requisite link on both sides of the
     * relationship because the Tasks module did not have a link back to Emails using the `emails_tasks_rel`
     * relationship. The `emails` link was added to Tasks in 7.10 to resolve this issue.
     *
     * Some emails' parent records might be tasks. Prior to 7.10, these parent relationships were failing to be
     * synchronized to the emails_beans table. This upgrade script finds relationships that are not synchronized to
     * emails_beans and repairs it.
     *
     * This upgrade script only runs when upgrading from a version prior to 8.0.
     */
    public function run()
    {
        if (!version_compare($this->from_version, '8.0', '<')) {
            $this->log("from_version ({$this->from_version}) is not less than 8.0");
            return;
        }

        $totalEmails = 0;

        do {
            $emails = $this->getEmails();
            $rows = $this->getRowsToInsert($emails);
            $this->linkEmailsToTasks($rows);
            $totalEmails += count($emails);
        } while (!empty($emails));

        $this->log("{$totalEmails} emails were linked with their parent tasks");
    }

    /**
     * Returns an array of all Emails beans that have a parent whose module is Tasks.
     *
     * @return array
     */
    protected function getEmails()
    {
        $emails = [];

        try {
            $sql = 'SELECT emails.id, emails.parent_type, emails.parent_id FROM emails WHERE ' .
                $GLOBALS['db']->getNotEmptyFieldSQL('emails.parent_id') .
                " AND emails.parent_type='Tasks' AND " .
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
            }
        } catch (Exception $e) {
            $this->log('Error: ' . $e->getMessage());
        }

        $ids = array_keys($emails);
        $this->log('Found ' . count($emails) . ' email(s) with parent_type=Tasks: ' . implode(', ', $ids));

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
     * Synchronize the Emails parent relationship to the emails_beans table for the tasks link.
     *
     * @param array $rows The rows to insert into the emails_beans table.
     */
    private function linkEmailsToTasks(array $rows)
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
