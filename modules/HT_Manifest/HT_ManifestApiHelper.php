<?php

class HT_ManifestApiHelper extends SugarBeanApiHelper {

    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $ret = parent::formatForApi($bean, $fieldList, $options);

        // Adding transporter data to Manifest Model
        $ret['transporter'] = array();

        $sql = <<<SQL
                SELECT 
                accounts.id AS 'id',
                accounts.name AS 'name',
                ht_manifest_accounts_1_c.transfer_date AS 'transfer_date'
            FROM
                ht_manifest_accounts_1_c ht_manifest_accounts_1_c
                    INNER JOIN
                accounts accounts ON ht_manifest_accounts_1_c.ht_manifest_accounts_1accounts_idb = accounts.id
                    AND accounts.deleted = '0'
            WHERE
                ht_manifest_accounts_1_c.deleted = '0'
                    AND ht_manifest_accounts_1_c.ht_manifest_accounts_1ht_manifest_ida =  '{$bean->id}'
SQL;
        global $db;

        $res = $db->query($sql);
        while ($row = $db->fetchByAssoc($res)) {
            $ret['transporter'][] = $row;
        }

        return $ret;
    }

}
