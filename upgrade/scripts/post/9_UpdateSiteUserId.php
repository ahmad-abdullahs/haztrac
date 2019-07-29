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
 * Update site_id in config table and site_user_id in users table.
 */
class SugarUpgradeUpdateSiteUserId extends UpgradeDBScript
{
    public $order = 9999;

    /**
     * Execute upgrade tasks
     * This script adds site_id in config table and site_user_id in users table.
     * @see UpgradeScript::run()
     */
    public function run()
    {
        if (version_compare($this->from_version, '9.0.0', '>=')) {
            // do nothing if upgrading from 9.0.0 or newer
            return;
        }

        $this->log('Updating site_user_id in users table');
        $result = $this->db->query("SELECT id FROM users");

        while ($row = $this->db->fetchByAssoc($result, false)) {
            $site_user_id = getSiteHash($row['id']);
            $sql = "UPDATE users SET site_user_id = ? WHERE id = ?";
            $this->executeUpdate($sql, [$site_user_id, $row['id']]);
        }

        $this->log('Updating site_id in config table');
        $license = $this->db->quoted('license');
        $key = $this->db->quoted('key');
        $result = $this->db->query("SELECT value FROM config WHERE category = $license AND name = $key");

        if ($row = $this->db->fetchByAssoc($result, false)) {
            $site_id = getSiteHash($row['value']);
            $sql = sprintf(
                'INSERT INTO config (category, name, value) VALUES (%s, %s, %s)',
                $this->db->quoted('site'),
                $this->db->quoted('id'),
                $this->db->quoted($site_id)
            );
            $this->db->query($sql);
        }
    }
}
