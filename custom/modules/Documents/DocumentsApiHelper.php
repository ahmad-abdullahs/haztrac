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

require_once('modules/Documents/DocumentsApiHelper.php');

class CustomDocumentsApiHelper extends DocumentsApiHelper {

    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array()) {
        // If there was a field list requested and document_revision_id was not
        // a requested field we will have problems. Set the revision id so that 
        // additional fields like filename get picked up.
        if (!empty($fieldList) && !in_array('document_revision_id', $fieldList)) {
            $db = DBManagerFactory::getInstance();

            // Get the revision ID so that it can be set into the bean
            $query = sprintf(
                    'SELECT document_revision_id FROM %s WHERE id = %s', $bean->table_name, $db->quoted($bean->id)
            );
            $rs = $db->query($query);
            $row = $db->fetchByAssoc($rs);
            if (isset($row['document_revision_id'])) {
                // Set the revision and setup everything else for a document that
                // depends on a revision id, like filename, revision, etc
                $bean->document_revision_id = $row['document_revision_id'];
                $bean->fill_in_additional_detail_fields();
            }
        }
        $data = parent::formatForApi($bean, $fieldList, $options);
        $data['document_revision_id'] = $bean->document_revision_id;

        global $db, $sugar_config;
        $sql = <<<SQL
            SELECT 
                id, file_ext
            FROM
                document_revisions
            WHERE
                document_id = '{$bean->id}'
            LIMIT 1;
SQL;

        $res = $db->query($sql);
        $data['document_preview'] = "{$sugar_config['site_url']}/pdfs/report-preview.jpg#zoom=60";
        $data['fileExist'] = false;
        while ($row = $db->fetchByAssoc($res)) {
            if (!empty($row['id']) && !empty($row['file_ext'])) {
                if (file_exists("upload/{$row['id']}")) {
                    $data['document_preview'] = "{$sugar_config['site_url']}/upload/{$row['id']}#zoom=60";

                    if ($row['file_ext'] == 'pdf') {
                        $data['popOutFullViewLink'] = "#bwc/index.php?entryPoint=openpdf&id={$row['id']}&uploadDir=upload";
                    } else {
                        $data['popOutFullViewLink'] = "{$sugar_config['site_url']}/index.php?entryPoint=download&id={$row['id']}&type=Documents";
                    }

                    $data['fileExist'] = true;
                }
            }
        }

        return $data;
    }

}
