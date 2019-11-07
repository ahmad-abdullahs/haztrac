<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    function before_save_method($bean, $event, $arguments) {
        if ($bean->accounts_and_roles_widget != $bean->fetched_row['accounts_and_roles_widget']) {
            global $db, $timedate;
            $sql = <<<SQL
                    DELETE FROM accounts_contacts 
                WHERE
                    accounts_contacts.contact_id = '{$bean->id}'
SQL;
            $db->query($sql);

            // Add the relationship
            $accounts_and_roles_widget_decoded = json_decode($bean->accounts_and_roles_widget);
            foreach ($accounts_and_roles_widget_decoded as $key => $account_role_obj) {
                if (empty($account_role_obj->accounts_and_roles_widget_primary_account)) {
                    $account_role_obj->accounts_and_roles_widget_primary_account = 0;
                }
                if (!empty($account_role_obj->accounts_and_roles_widget_name_id)) {
                    $id = create_guid();
                    $sql = <<<SQL
                        INSERT INTO accounts_contacts 
                            (`id`, `contact_id`, `account_id`, `date_modified`, `primary_account`, `deleted`, `role`) 
                        VALUES ('{$id}', '{$bean->id}', '{$account_role_obj->accounts_and_roles_widget_name_id}', '{$timedate->nowDb()}', '{$account_role_obj->accounts_and_roles_widget_primary_account}', '0', {$db->quoted($account_role_obj->accounts_and_roles_widget_role)});
SQL;
                    $db->query($sql);
                }
            }
        }
    }

}
