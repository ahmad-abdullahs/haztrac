<?php

use Doctrine\DBAL\Connection;
use Sugarcrm\Sugarcrm\Audit\Formatter as AuditFormatter;
use Sugarcrm\Sugarcrm\DependencyInjection\Container;

require_once 'modules/Audit/Audit.php';

// Overrided this to format the multienum-relate field for sales and services module
class CustomAudit extends Audit
{
    public function getAuditLog(SugarBean $bean)
    {
        global $timedate;

        if (!$bean->is_AuditEnabled()) {
            return array();
        }

        $auditTable = $bean->get_audit_table_name();

        $query = "SELECT atab.*, ae.source, ae.type AS event_type, usr.user_name AS created_by_username
                  FROM {$auditTable} atab
                  LEFT JOIN audit_events ae ON (ae.id = atab.event_id)
                  LEFT JOIN users usr ON (usr.id = atab.created_by) 
                  WHERE  atab.parent_id = ?
                  ORDER BY atab.date_created DESC, atab.id DESC";

        $db = DBManagerFactory::getInstance();

        $stmt = $db->getConnection()->executeQuery($query, [$bean->id]);
        if (empty($stmt)) {
            return array();
        }

        $fieldDefs = $this->fieldDefs;
        $return = array();

        $aclCheckContext = array('bean' => $bean);
        $rows = [];
        while ($row = $stmt->fetch()) {
            if (!SugarACL::checkField($bean->module_dir, $row['field_name'], 'access', $aclCheckContext)) {
                continue;
            }

            // Code added to format the Multi relate field
            if($bean->module_dir == 'sales_and_services' && $row['field_name'] == 'sales_and_service_assets_and_objects' && (!empty($row['before_value_string']) || !empty($row['after_value_string']))){
                $row['before_value_string'] = $this->processObjects($row['before_value_string'], $bean);
                $row['after_value_string'] = $this->processObjects($row['after_value_string'], $bean);
            }

            //convert date
            $dateCreated = $timedate->fromDbType($db->fromConvert($row['date_created'], 'datetime'), "datetime");
            $row['date_created'] = $timedate->asIso($dateCreated);

            $row['source'] = json_decode($row['source'], true);

            $viewName = array_search($row['field_name'], Team::$nameTeamsetMapping);
            if ($viewName) {
                $row['field_name'] = $viewName;
                $return[] = $this->handleTeamSetField($row);
                continue;
            }

            if ($this->handleRelateField($bean, $row)) {
                $return[] = $row;
                continue;
            }

            // look for opportunities to relate ids to name values.
            if (!empty($this->genericAssocFieldsArray[$row['field_name']]) ||
                !empty($this->moduleAssocFieldsArray[$bean->object_name][$row['field_name']])
            ) {
                foreach ($fieldDefs as $field) {
                    if (in_array($field['name'], array('before_value_string', 'after_value_string'))) {
                        $row[$field['name']] =
                            $this->getNameForId($row['field_name'], $row[$field['name']]);
                    }
                }
            }

            $rows[] = $this->formatRowForApi($row);
        }

        Container::getInstance()->get(AuditFormatter::class)->formatRows($rows);
        $rows = array_merge($rows,$return);

        // Parsing and manipulating the final data
        if($bean->module_dir == 'sales_and_services'){
            foreach($rows as $i => $auditRow){
                if($auditRow['field_name'] == 'sales_and_service_assets_and_objects'){
                    $rows[$i]['data_type'] = 'varchar';
                    $rows[$i]['before'] = !empty($auditRow['before']) ? implode(", ", $auditRow['before']) : "";
                    $rows[$i]['after'] = !empty($auditRow['after']) ? implode(", ", $auditRow['after']) : "";
                }
            }
        }

        return $rows;
    }

    public function processObjects($values, $bean)
    {
        $values = unencodeMultienum($values);
        if(!empty($values)){
            $query = new SugarQuery();
            $query->from(BeanFactory::newBean('HT_Assets_and_Objects'));
            $query->where()->in('id', $values);
            $query->select('name');
            $data = $query->execute();
            $names = array_column($data, 'name');
            return implode(", ", $names);

        }
        return $values;
    }
}