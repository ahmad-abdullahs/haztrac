<?php

require_once('modules/Contacts/ContactsApiHelper.php');

// Since the ContactsApiHelper exists, we'll extend it If it didn't we would just extend the SugarBeanApiHelper
class CustomContactsApiHelper extends ContactsApiHelper {

    // Mimic the SugarBeanApiHelper->formatForApi() class
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);

        // Make sure they requested the top_opp field, or no field restriction at all
        if (empty($fieldList) || in_array('accounts_and_roles_widget', $fieldList)) {
            // Pushing Account, its role and primary status data to Contacts Model
            $data['accounts_and_roles_widget'] = array();

            $sql = <<<SQL
                    SELECT 
                    accounts_contacts.account_id AS 'accounts_and_roles_widget_name_id',
                    accounts.name AS 'accounts_and_roles_widget_name',
                    accounts_contacts.role AS 'accounts_and_roles_widget_role',
                    accounts_contacts.primary_account AS 'accounts_and_roles_widget_primary_account'
                FROM
                    accounts_contacts accounts_contacts
                        INNER JOIN
                    accounts accounts ON accounts_contacts.account_id = accounts.id
                        AND accounts_contacts.deleted = '0'
                        AND accounts.deleted = '0'
                WHERE
                    accounts_contacts.contact_id = '{$bean->id}' 
                ORDER BY accounts.name
SQL;
            global $db;

            $res = $db->query($sql);
            while ($row = $db->fetchByAssoc($res)) {
                $data['accounts_and_roles_widget'][] = $row;
            }
        }

//        $data['accounts_and_roles_widget'] = json_encode(array(
//            'accounts_and_roles_widget' => $data['accounts_and_roles_widget']
//        ));
//        return json_encode($data);
        $data['accounts_and_roles_widget'] = json_encode($data['accounts_and_roles_widget']);
        return $data;
    }

}
