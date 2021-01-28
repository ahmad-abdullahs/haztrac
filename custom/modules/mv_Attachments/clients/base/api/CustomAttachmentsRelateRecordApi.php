<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/RelateRecordApi.php");

class CustomAttachmentsRelateRecordApi extends RelateRecordApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'createRelatedRecordForLabReports' => array(
                'reqType' => 'POST',
                'path' => array('LR_Lab_Reports', '?', 'link', 'lr_lab_reports_mv_attachments'),
                'pathVars' => array('module', 'record', '', 'link_name'),
                'method' => 'createRelatedRecord',
                'shortHelp' => 'Create a single record and relate it to this module',
                'longHelp' => 'include/api/help/module_record_link_link_name_post_help.html',
            ),
            'createRelatedRecordForManifest' => array(
                'reqType' => 'POST',
                'path' => array('HT_Manifest', '?', 'link', 'ht_manifest_mv_attachments'),
                'pathVars' => array('module', 'record', '', 'link_name'),
                'method' => 'createRelatedRecord',
                'shortHelp' => 'Create a single record and relate it to this module',
                'longHelp' => 'include/api/help/module_record_link_link_name_post_help.html',
            ),
            'lockOrUnlockDoc' => array(
                'reqType' => 'POST',
                'path' => array('HT_Manifest', '?', 'lockOrUnlockDoc'),
                'pathVars' => array('module', 'recordId', 'lockOrUnlockDoc'),
                'method' => 'lockOrUnlockDoc',
                'exceptions' => array(
                    'SugarApiExceptionInvalidParameter',
                    'SugarApiExceptionNotAuthorized',
                ),
            ),
        ));
    }

    public function createRelatedRecord(ServiceBase $api, array $args) {
        $data = parent::createRelatedRecord($api, $args);

        // Used when a new file is added in the record view, It should be moved to the pdfs directory.
        if (isset($args['uploadfile_guid'])) {
            if (file_exists("upload://{$data['related_record']['id']}")) {
                if (copy("upload://{$data['related_record']['id']}", "pdfs/{$data['related_record']['id']}.{$args['temp_file_ext']}")) {
                    $GLOBALS['log']->fatal('File successfully copied to pdfs directory.');
                } else {
                    $GLOBALS['log']->fatal('Unable to successfully copy the file to pdfs directory.');
                }
            } else {
                $GLOBALS['log']->fatal('File does not exist : ' . print_r("upload://{$data['related_record']['id']}", 1));
            }
        }

        return $data;
    }

    public function lockOrUnlockDoc(ServiceBase $api, array $args) {
        global $db;
        $recordId = $args['recordId'];
        $flag = $args['flag'];

        $update = "UPDATE mv_attachments 
                SET 
                    is_locked = '{$flag}'
                WHERE
                    id = '{$recordId}'";

        $db->query($update, true);

        return $update;
    }

}
