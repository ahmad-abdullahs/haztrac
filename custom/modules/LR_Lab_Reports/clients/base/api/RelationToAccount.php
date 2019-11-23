<?php

require_once 'include/api/SugarApi.php';

class RelationToAccount extends SugarApi {

    public function registerApiRest() {
        return array(
            'IncludedServices' => array(
                'reqType' => 'PUT',
                'path' => array('relationToAccount', 'lr_lab_reports_accounts', '?', '?', '?'),
                'pathVars' => array('module', 'link', 'labReportId', 'accountId', 'type'),
                'method' => 'decideLinkForAccount',
                'jsonParams' => array(),
                'longHelp' => '',
                'exceptions' => array(
                    'SugarApiExceptionInvalidParameter',
                    'SugarApiExceptionNotAuthorized',
                ),
            ),
        );
    }

    public function decideLinkForAccount(ServiceBase $api, array $args) {
        global $db, $timedate, $current_user;
        $labReportId = $args['labReportId'];
        $accountId = $args['accountId'];
        $type = $args['type'];

        $select = "SELECT 
                    id
                FROM
                    lr_lab_reports_accounts_c
                WHERE
                    lr_lab_reports_accountslr_lab_reports_ida = '$labReportId'
                        AND lr_lab_reports_accountsaccounts_idb = '$accountId'
                        AND deleted = '0'";

        $result = $db->query($select, true);
        if ($result->num_rows > 0) {
            // if type is link no need to do anything, it already exist
            if ($type == 'unlink') {
                $update = "UPDATE lr_lab_reports_accounts_c SET `deleted`='1' WHERE `lr_lab_reports_accountslr_lab_reports_ida` = '{$labReportId}'"
                        . " and `lr_lab_reports_accountsaccounts_idb` = '{$accountId}'";
                $result = $db->query($update, true);
            }
        } else {
            // if type is link we need to insert
            if ($type == 'link') {
                $insert = "INSERT INTO lr_lab_reports_accounts_c "
                        . "(`id`, `date_modified`, `deleted`, `lr_lab_reports_accountslr_lab_reports_ida`, `lr_lab_reports_accountsaccounts_idb`, `role`) "
                        . "VALUES "
                        . "('" . create_guid() . "', '{$timedate->nowDb()}', '0', '{$labReportId}', '{$accountId}', '')";
                $result = $db->query($insert, true);
            } else {
                // this is unlink, and it does not exist in the database, so no need to worry.
            }
        }
    }

}
