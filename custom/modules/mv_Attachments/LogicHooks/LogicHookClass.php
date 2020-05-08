<?php

class mv_AttachmentsLogicHookClass {

    protected static $mimes = [
        'image/jpeg',
        'image/gif',
        'image/png',
    ];

    function before_save($bean, $event, $arguments) {
//        $bean->name = $bean->document_name;
//        if (in_array($bean->file_mime_type, self::$mimes) AND ! empty($bean->id)) {
//            $bean->image = $bean->id;
//        } else {
//            $bean->image = '';
//        }
        // new record
        if (!isset($bean->fetched_row['id'])) {
            $extensionArr = explode('.', $bean->filename);
            $bean->file_ext = $extensionArr[count($extensionArr) - 1];
            $bean->name = empty($bean->document_name) ? $bean->filename : $bean->document_name;
        }
    }

    function after_save($bean) {
        if (($bean->parent_type == 'LR_Lab_Reports' || $bean->parent_type == 'HT_Manifest') &&
                !empty($bean->parent_id)) {
            $notes = BeanFactory::getBean($bean->parent_type, $bean->parent_id);
            $bean->assigned_user_id = $notes->assigned_user_id;
            $bean->team_id = $notes->team_id;
            $bean->team_set_id = $notes->team_set_id;
            $bean->acl_team_set_id = $notes->acl_team_set_id;
            $extensionArr = explode('.', $bean->filename);
            $bean->file_ext = $extensionArr[count($extensionArr) - 1];
            $GLOBALS['db']->update($bean);
        }

        // Used by Create view.
        if (file_exists("upload://{$bean->id}")) {
            if (copy("upload://{$bean->id}", "pdfs/{$bean->id}.{$bean->file_ext}")) {
                $GLOBALS['log']->fatal('Yes we have copied the file');
            } else {
                $GLOBALS['log']->fatal('Unable to successfully copy the file');
            }
        } else {
            $GLOBALS['log']->fatal('File does not exist : ' . print_r($bean->id, 1));
        }
    }

}
