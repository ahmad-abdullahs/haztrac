<?php

class LR_Lab_ReportsApiHelper extends SugarBeanApiHelper
{
    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $ret = parent::formatForApi($bean, $fieldList, $options);

        // adding manifests
        $ret['manifests'] = array();

        $sql =<<<SQL
                SELECT
                    m.id as 'id',
                    m.name as 'name'
                FROM
                    ht_manifest_lr_lab_reports_1_c r
                INNER JOIN
                    ht_manifest m
                ON
                    r.ht_manifest_lr_lab_reports_1ht_manifest_ida = m.id AND m.deleted = '0'
                WHERE
                    r.deleted = '0' AND r.ht_manifest_lr_lab_reports_1lr_lab_reports_idb = '{$bean->id}'
SQL;
        global $db;

        $res = $db->query($sql);
        while ($row = $db->fetchByAssoc($res)) {
            $ret['manifests'][] = $row;
        }

        return $ret;
    }
}
