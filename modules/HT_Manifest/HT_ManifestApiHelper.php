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
        global $db, $sugar_config;

        $res = $db->query($sql);
        while ($row = $db->fetchByAssoc($res)) {
            $ret['transporter'][] = $row;
        }

        $sql = <<<SQL
                SELECT 
                    mv_attachments.id,
                    mv_attachments.file_ext,
                    mv_attachments.filename,
                    mv_attachments.category_id,
                    mv_attachments.is_locked
                FROM
                    ht_manifest
                        LEFT JOIN
                    mv_attachments ON mv_attachments.parent_id = ht_manifest.id
                WHERE
                    ht_manifest.deleted = 0
                        AND mv_attachments.deleted = 0
                        AND ht_manifest.id = '{$bean->id}'
                ORDER BY category_id ASC
                LIMIT 1
SQL;

        $res = $db->query($sql);
        $ret['preview_doc_id'] = 'report-preview.jpg';
        //********************************************************************
        //********************************************************************
        //********************************************************************
        //********************************************************************
        //********************************************************************
        //********************************************************************
        //********************************************************************
        //********************************************************************
        $ret['ht_manifest_preview_c'] = "{$sugar_config['site_url']}/pdfs/report-preview.jpg#zoom=60";
        $ret['fileExist'] = false;
        while ($row = $db->fetchByAssoc($res)) {
            if (!empty($row['id']) && !empty($row['file_ext'])) {
                $ret['preview_doc_id'] = $row['id'] . '.' . $row['file_ext'];
                $ret['is_locked'] = ($row['is_locked'] == 1) ? true : false;
                $ret['document_id'] = $row['id'];
                if (file_exists("pdfs/{$ret['preview_doc_id']}")) {
                    $ret['ht_manifest_preview_c'] = "{$sugar_config['site_url']}/pdfs/{$ret['preview_doc_id']}#zoom=60";

                    if ($row['file_ext'] == 'pdf') {
                        $ret['popOutFullViewLink'] = "#bwc/index.php?entryPoint=openpdf&id={$row['id']}&module=mv_Attachments";
                    } else {
                        $ret['popOutFullViewLink'] = "{$sugar_config['site_url']}/rest/v11_4/mv_Attachments/{$row['id']}/file/uploadfile?force_download=0&1586557374461=1&platform=base";
                    }

                    $ret['fileExist'] = true;
                }
            }
        }

        return $ret;
    }

}
