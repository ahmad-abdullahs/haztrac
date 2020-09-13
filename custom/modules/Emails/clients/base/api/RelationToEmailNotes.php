<?php

require_once 'include/api/SugarApi.php';

class RelationToEmailNotes extends SugarApi {

    public function registerApiRest() {
        return array(
            'RelationToEmailNotesEntry' => array(
                'reqType' => 'PUT',
                'path' => array('relationToEmailNotes', '?', '?', '?'),
                'pathVars' => array('module', 'emailId', 'noteId', 'type'),
                'method' => 'decideLinkForEmailNotes',
                'jsonParams' => array(),
                'longHelp' => '',
                'exceptions' => array(
                    'SugarApiExceptionInvalidParameter',
                    'SugarApiExceptionNotAuthorized',
                ),
            ),
        );
    }

    public function decideLinkForEmailNotes(ServiceBase $api, array $args) {
        global $db, $timedate, $current_user;
        $emailId = $args['emailId'];
        $noteId = $args['noteId'];
        $type = $args['type'];

        $select = "SELECT 
                    id
                FROM
                    emails_beans
                WHERE
                    email_id = '$emailId'
                        AND bean_id = '$noteId'
                        AND deleted = '0'";

        $result = $db->query($select, true);
        if ($result->num_rows > 0) {
            // if type is link no need to do anything, it already exist
            if ($type == 'unlink') {
                $update = "UPDATE emails_beans SET `deleted`='1' WHERE `email_id` = '{$emailId}'"
                        . " and `bean_id` = '{$noteId}'";
                $result = $db->query($update, true);
            }
        } else {
            // if type is link we need to insert
            if ($type == 'link') {
                $insert = "INSERT INTO emails_beans "
                        . "(`id`, `date_modified`, `deleted`, `email_id`, `bean_id`, `bean_module`, `campaign_data`) "
                        . "VALUES "
                        . "('" . create_guid() . "', '{$timedate->nowDb()}', '0', '{$emailId}', '{$noteId}', 'Notes','')";
                $result = $db->query($insert, true);
            } else {
                // this is unlink, and it does not exist in the database, so no need to worry.
            }
        }
    }

}
