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
 * Applies the collation defined in the dbconfigoption.collation configuration -- or the default collation -- to all
 * database objects for consistency.
 */
class SugarUpgradeApplyDbCollation extends UpgradeScript
{
    public $order = 1010;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if (version_compare($this->from_version, '8.1.0', '>=')) {
            return;
        }

        if (!$this->db->supports('collation')) {
            $this->log('The database does not support collation');
            return;
        }

        $collation = $this->db->getOption('collation') ?? $this->db->getDefaultCollation();
        $this->log("Applying the '{$collation}' collation to the database and all existing tables");
        $this->db->setCollation($collation);
    }
}
