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
 * Update OOB Reports
 */
class SugarUpgradeUpdateOOBReports extends UpgradeScript
{
    public $order = 4500;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        if (version_compare($this->from_version, '8.1.0', '>=')) {
            return;
        }
        require_once 'modules/Reports/SavedReport.php';
        require_once 'modules/Reports/SeedReports.php';
        create_default_reports(true);

        $this->newOOBReportsNotifications();
    }

    /**
     * A notification is created to all users informing them new OOB reports are available.
     */
    public function newOOBReportsNotifications()
    {
        $app_strings = return_application_language($GLOBALS['current_language']);

        $reports_module_url = "<a href='index.php#Reports'>" .
            $app_strings['LBL_NEW_OOB_REPORTS_NOTIFICATION_DESC_2'] . "</a>";
        $link = "http://www.sugarcrm.com/crm/product_doc.php?edition={$GLOBALS['sugar_flavor']}" .
            "&version={$GLOBALS['sugar_version']}&lang=en_us&module=Notify&route=stockReports";
        $documentation_url = "<a href='{$link}'>" . $app_strings['LBL_NEW_OOB_REPORTS_NOTIFICATION_DESC_4'] . "</a>";
        $description = $app_strings['LBL_NEW_OOB_REPORTS_NOTIFICATION_DESC_1'] . $reports_module_url . ". " .
            $app_strings['LBL_NEW_OOB_REPORTS_NOTIFICATION_DESC_3'] . $documentation_url . ".";

        $result = $this->db->query("SELECT id FROM users where deleted = 0 AND status = 'Active'");
        while ($row = $this->db->fetchByAssoc($result)) {
            $notification = BeanFactory::newBean('Notifications');
            $notification->name = $app_strings['LBL_NEW_OOB_REPORTS_NOTIFICATION_SUBJECT'];
            $notification->description = $description;
            $notification->severity = 'info';
            $notification->assigned_user_id = $row['id'];
            $notification->save();
        }
    }
}
