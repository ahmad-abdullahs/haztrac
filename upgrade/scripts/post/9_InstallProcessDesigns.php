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
 * Clear the bad default values in the pmse_bpm_flow table.
 */
class SugarUpgradeInstallProcessDesigns extends UpgradeScript
{
    /**
     * Set to a value BEFORE RemoveFiles so that the file remover can
     * handle files from this process
     * @var integer
     */
    public $order = 9090;
    public $type = self::UPGRADE_DB;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (version_compare($this->from_version, '9.0.0', '<')) {
            // Get the installer
            $bpi = new BusinessProcessInstaller;

            // Prepare the upgrade then run the installer
            $bpi->prepareUpgrade()->install();

            // Get the installed files and add them to the deleter
            $this->fileToDelete($bpi->getInstalledFiles(), $this);

            // Log what happened
            foreach ($bpi->getInstallTotalsLog() as $entry) {
                $this->log($entry);
            }
        }
    }
}
