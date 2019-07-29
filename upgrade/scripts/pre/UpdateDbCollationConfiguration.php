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
 * Updates the dbconfigoption.collation configuration from one that works with utf8 to one that works with utf8mb4 for
 * MySQL databases.
 */
class SugarUpgradeUpdateDbCollationConfiguration extends UpgradeScript
{
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if (version_compare($this->from_version, '8.1.0', '>=')) {
            return;
        }

        // This upgrade applies to MySQL only.
        if ($this->db->dbType !== 'mysql') {
            return;
        }

        $collation = 'utf8mb4_general_ci';
        $currentCollation = $this->db->getOption('collation');

        if (empty($currentCollation)) {
            // The admin has not defined a collation. Use the default collation.
            $this->log('No change to the collation configuration is necessary');
            return;
        }

        // Is the current collation one of the allowed collations?
        $allowedCollations = $this->getAllowedCollations();
        $this->log('Allowed collations: ' . implode(', ', $allowedCollations));

        if (in_array($currentCollation, $allowedCollations)) {
            $this->log("Collation '{$currentCollation}' can be used with the utf8mb4 charset");
            return;
        }

        // Can the current collation be mapped to one of the allowed collations?
        $mappedCollation = preg_replace('/^utf8_(.*)$/', 'utf8mb4_${1}', $currentCollation);

        if (in_array($mappedCollation, $allowedCollations)) {
            $collation = $mappedCollation;
        } else {
            $this->log("Collation '{$mappedCollation}' cannot be used with the utf8mb4 charset");
            $this->log("Defaulting to collation '{$collation}'");
        }

        // Save the configuration with the new collation.
        if ($currentCollation !== $collation) {
            $this->log("Changing the collation from '{$currentCollation}' to '{$collation}'");
            $config = new Configurator();
            $config->config['dbconfigoption']['collation'] = $collation;
            $config->saveConfig();
        } else {
            $this->log('No change to the collation configuration is necessary');
        }
    }

    /**
     * Lists allowed collations for the "utf8mb4" character set.
     *
     * @return array
     */
    protected function getAllowedCollations()
    {
        $collations = [];

        try {
            $sql = "SHOW COLLATION WHERE Charset='utf8mb4'";
            $result = $this->db->getConnection()->executeQuery($sql);

            while ($row = $result->fetch()) {
                $collations[] = $row['Collation'];
            }
        } catch (Exception $e) {
            $this->log('Unable to retrieve the allowed collations: ' . $e->getMessage());
        }

        return $collations;
    }
}
