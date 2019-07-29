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

class SugarUpgradeFixParentTypeForKB extends UpgradeDBScript
{
    public $order = 9000;

    /**
     * {@inheritdoc}
     *
     * Change parent_type from KBContentsAttachments to KBContents.
     */
    public function run()
    {
        // This upgrade script only runs when upgrading from a version prior to 8.2.0.
        if (version_compare($this->from_version, '8.2.0', '<')) {
            $sql = "UPDATE notes SET parent_type = 'KBContents' WHERE parent_type = 'KBContentsAttachments' AND deleted = 0";
            $this->executeUpdate($sql);
        }
    }
}
