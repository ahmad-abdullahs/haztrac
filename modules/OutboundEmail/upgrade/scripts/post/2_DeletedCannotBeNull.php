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

class SugarUpgradeDeletedCannotBeNull extends UpgradeDBScript
{
    public $order = 2200;

    /**
     * {@inheritdoc}
     *
     * The deleted column was added to outbound_email in 7.10. The default value of 0 was applied to all existing rows
     * in all databases except for MSSQL/SQLServer. Having a NULL deleted column causes all sorts of havoc because the
     * application assumes that the system row can be loaded from the database at any time. This upgrade script will
     * correct this issue by always setting deleted to 0 if the application gets into a bad state.
     */
    public function run()
    {
        $sql = "UPDATE outbound_email SET deleted = ? WHERE deleted IS NULL";
        $this->executeUpdate($sql, [0]);
    }
}
