<?php

class LR_Lab_ReportsApiHelper extends SugarBeanApiHelper {

    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $ret = parent::formatForApi($bean, $fieldList, $options);

        // This check can be added for the performance reasons, but this need to be
        // tested throughly. It will drastically increase the performance.
        // if(!empty($fieldList)){}
        // adding manifests
        $ret['manifests'] = array();
        $sql = <<<SQL
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
        global $db, $sugar_config;
        $res = $db->query($sql);
        while ($row = $db->fetchByAssoc($res)) {
            $ret['manifests'][] = $row;
        }

        $sql = <<<SQL
                SELECT 
                    mv_attachments.id,
                    mv_attachments.file_ext,
                    mv_attachments.filename,
                    mv_attachments.category_id
                FROM
                    lr_lab_reports
                        LEFT JOIN
                    mv_attachments ON mv_attachments.parent_id = lr_lab_reports.id
                WHERE
                    lr_lab_reports.deleted = 0
                        AND mv_attachments.deleted = 0
                        AND lr_lab_reports.id = '{$bean->id}'
                ORDER BY category_id ASC
                LIMIT 1
SQL;

        $res = $db->query($sql);
        $ret['preview_doc_id'] = 'report-preview.jpg';
        $ret['lab_report_preview_c'] = "{$sugar_config['site_url']}/pdfs/report-preview.jpg#zoom=60";
        $ret['fileExist'] = false;
        while ($row = $db->fetchByAssoc($res)) {
            if (!empty($row['id']) && !empty($row['file_ext'])) {
                $ret['preview_doc_id'] = $row['id'] . '.' . $row['file_ext'];
                if (file_exists("pdfs/{$ret['preview_doc_id']}")) {
                    $ret['lab_report_preview_c'] = "{$sugar_config['site_url']}/pdfs/{$ret['preview_doc_id']}#zoom=60";

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
