<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=createAttachmentsForOldOnes

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('include/entryPoint.php');

class createAttachmentsForOldOnes {

    public function __construct() {
        $this->execute();
    }

    private function execute() {
        global $db;
        $selectAllLabReports = "SELECT 
                                id, filename, lab_ref_number_c, analysis_date_c
                            FROM
                                lr_lab_reports
                                    JOIN
                                lr_lab_reports_cstm ON lr_lab_reports.id = lr_lab_reports_cstm.id_c
                            WHERE
                                deleted = 0;";

        $result = $db->query($selectAllLabReports);
        while ($row = $db->fetchByAssoc($result)) {
            if (file_exists("upload://{$row['id']}") && !empty($row['filename'])) {
                echo 'File exists.' . ' (' . $row['filename'] . ') ' . '<br>';
                $extensionArr = explode('.', $row['filename']);
                $ext = $extensionArr[count($extensionArr) - 1];

                $newID = create_guid();
                if (copy("upload://{$row['id']}", "pdfs/{$newID}.{$ext}")) {
                    echo 'File successfully copied to pdfs directory.' . '<br>';
                    $attachmentBean = BeanFactory::newBean('mv_Attachments');
                    $attachmentBean->new_with_id = true;
                    $attachmentBean->id = $newID;
                    $attachmentBean->document_name = $row['filename'];
                    $attachmentBean->filename = $row['filename'];
                    $attachmentBean->file_ext = $ext;
                    $attachmentBean->file_mime_type = 'application/pdf';
                    $attachmentBean->category_id = 'Primary';
                    $attachmentBean->parent_type = 'LR_Lab_Reports';
                    $attachmentBean->parent_id = $row['id'];
                    $attachmentBean->lab_ref_number = $row['lab_ref_number_c'];
                    $attachmentBean->analysis_date = $row['analysis_date_c'];
                    $attachmentBean->assigned_user_id = '1';
                    $attachmentBean->modified_user_id = '1';
                    $attachmentBean->created_by = '1';
                    $attachmentBean->team_id = '1';
                    $attachmentBean->team_set_id = '1';
                    $attachmentBean->save();
                } else {
                    echo 'Unable to successfully copy the file to pdfs directory.' . '<br>';
                }
            } else {
                echo 'File does not exists.' . '<br>';
            }
        }
    }

}

$obj = new createAttachmentsForOldOnes();
echo('Script excuted successfully');
