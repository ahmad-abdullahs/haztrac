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
 * Update analytics settings
 */
class SugarUpgradeUpdateAnalyticsSettings extends UpgradeScript
{
    public $order = 3100;
    public $type = self::UPGRADE_CUSTOM;

    /**
     * This script updates analytics settings to enable Pendo for all pre-9.0.0 instances
     * even if another analytics tool such as Google Analytics is being used
     * @see UpgradeScript::run()
     */
    public function run()
    {
        if (version_compare($this->from_version, '9.0.0', '>=')) {
            // do nothing if upgrading from 9.0.0 or newer
            return;
        }

        $configurator = new Configurator();
        $configurator->config['analytics'] = array(
            'enabled' => true,
            'connector' => 'Pendo',
            'id' => '1dd345e9-b638-4bd2-7bfb-147a937d4728',
        );
        $configurator->handleOverride();
        $configurator->clearCache();
        SugarConfig::getInstance()->clearCache();
    }
}
