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
 * Repair datetime columns which is not supported by DBManager out of the box
 */
class SugarUpgradeRepairDateTimes extends UpgradeScript
{
    public $order = 2120;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        global $beanList;
        global $db;
        global $dictionary;

        if (version_compare($this->from_version, '8.1.0', '>=')) {
            return;
        }

        switch ($db->dbType) {
            case 'mssql':
            case 'ibm_db2':
                break;
            default:
                return;
        }

        $tablesToRepair = [];

        foreach ($beanList as $module => $_) {
            $bean = BeanFactory::newBean($module);

            if (!$bean instanceof SugarBean) {
                continue;
            }

            $fieldDefinitions = $bean->getFieldDefinitions();

            if (!is_array($fieldDefinitions)) {
                continue;
            }

            $this->analyze($db, $bean->getTableName(), $fieldDefinitions, $tablesToRepair);
            $this->analyze($db, $bean->get_custom_table_name(), $fieldDefinitions, $tablesToRepair);
        }

        foreach ($dictionary as $definition) {
            if (!isset($definition['table']) || !isset($definition['fields'])) {
                continue;
            }

            $this->analyze($db, $definition['table'], $definition['fields'], $tablesToRepair);
        }

        ksort($tablesToRepair);

        foreach ($tablesToRepair as $table => $definition) {
            $this->repair($db, $table, $definition);
        }
    }

    private function analyze(DBManager $db, string $table, array $definitions, array &$tablesToRepair) : void
    {
        if (isset($tablesToRepair[$table])) {
            return;
        }

        $this->log(sprintf('Analyzing %s', $table));

        if (!$db->tableExists($table)) {
            $this->log(sprintf('Table %s does not exist', $table));
            return;
        }

        $definitions = array_intersect_key($definitions, $db->get_columns($table));
        $definitions = array_filter($definitions, function (array $definition) {
            switch ($definition['type']) {
                case 'datetime':
                case 'datetimecombo':
                case 'timestamp':
                    return true;
            }

            return false;
        });

        if (count($definitions) < 1) {
            $this->log(sprintf('No datetime columns found in %s', $table));

            return;
        }

        ksort($definitions);

        $tablesToRepair[$table] = $definitions;
    }

    private function repair(DBManager $db, string $table, array $definitions) : void
    {
        $this->log(sprintf('Repairing %s (%s)', $table, implode(', ', array_keys($definitions))));

        // SQL Server implementation of DBManager cannot handle multiple definitions at once
        foreach ($definitions as $definition) {
            $db->alterColumn($table, $definition);
        }
    }
}
