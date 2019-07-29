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

use Sugarcrm\Sugarcrm\ProcessManager;

/**
 * Class PMSEImporterFactory
 */
class PMSEImporterFactory
{
    /**
     * Get an instance of a PMSE Importer
     *
     * @param $type
     * @return \PMSEImporter
     */
    public static function getImporter(string $type = 'PMSEImporter')
    {
        if ($type === 'PMSEImporter') {
            return ProcessManager\Factory::getPMSEObject('PMSEImporter');
        }

        $type = self::formatImporterName($type);
        return ProcessManager\Factory::getPMSEObject($type . 'Importer');
    }

    /**
     * Convert from snake case to camel case
     *
     * @param string $name
     * @return string
     */
    private static function formatImporterName(string $name)
    {
        return str_replace('_', '', ucwords($name, '_'));
    }
}
