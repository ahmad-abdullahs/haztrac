<?php

require_once('modules/Emails/EmailsApiHelper.php');

// Since the EmailsApiHelper exists, we'll extend it If it didn't we would just extend the SugarBeanApiHelper
class CustomEmailsApiHelper extends EmailsApiHelper {

    // Mimic the SugarBeanApiHelper->formatForApi() class
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);
        $ids = array();

        $sql = <<<SQL
                    SELECT 
                        bean_id
                    FROM
                        emails_beans
                    WHERE
                        email_id = '{$bean->id}'
                            AND deleted = 0;
SQL;
        global $db;
        $res = $db->query($sql);
        while ($row = $db->fetchByAssoc($res)) {
            $ids[] = $row['bean_id'];
        }

        // This code is checking if the middle table entry exist then it means this attachment / Note 
        // is linked to the email otherwise not.
        if (is_array($data['attachments_collection'])) {
            foreach ($data['attachments_collection']['records'] as $key => $value) {
                if (in_array($value['id'], $ids)) {
                    $data['attachments_collection']['records'][$key]['linked'] = 1;
                } else {
                    $data['attachments_collection']['records'][$key]['linked'] = 0;
                }
            }
        }

        return $data;
    }

}
