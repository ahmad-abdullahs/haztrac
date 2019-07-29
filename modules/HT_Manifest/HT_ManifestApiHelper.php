<?php

class HT_ManifestApiHelper extends SugarBeanApiHelper
{
    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $ret = parent::formatForApi($bean, $fieldList, $options);

        // adding transporter
        $ret['transporter'] = array();

        $sql =<<<SQL
                SELECT
                    ao.id as 'id',
                    ao.name as 'name',
                    r.transfer_date as 'transfer_date'
                FROM
                    ht_manifest_ht_assets_and_objects_c r
                INNER JOIN
                    ht_assets_and_objects ao
                ON
                    r.ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb = ao.id AND ao.deleted = '0'
                WHERE
                    r.deleted = '0' AND r.ht_manifest_ht_assets_and_objectsht_manifest_ida = '{$bean->id}'
SQL;
        global $db;

        $res = $db->query($sql);
        while ($row = $db->fetchByAssoc($res)) {
            $ret['transporter'][] = $row;
        }

        return $ret;
    }
}
