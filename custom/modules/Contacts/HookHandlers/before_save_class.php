<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    function before_save_method($bean, $event, $arguments) {
        if ($bean->accounts_and_roles_widget != $bean->fetched_row['accounts_and_roles_widget']) {
            // ---------------Note---------------
            // We are assuming that one account is selected once in the accounts_and_roles_widget
            // If same account is selected multiple times we will keep only one row.

            global $db, $timedate;
            $timedateNowDb = $timedate->nowDb();
            $comingRecordsAccountsIds = array();
            $queryArray = array();
            $avoidMultipleAccoutRows = array();

            $returnData = $this->findExistingAccountsRecordsIds($bean);
            $existingRecordsAccountsIds = array_keys($returnData);

            $accounts_and_roles_widget_decoded = json_decode($bean->accounts_and_roles_widget);
            foreach ($accounts_and_roles_widget_decoded as $key => $account_role_obj) {
                // Assigning the existing Date Modified, so that we can keep the track of 
                // Contact jumping from one Account to another,
                $dateModified = $timedateNowDb;
                if (!empty($returnData[$account_role_obj->accounts_and_roles_widget_name_id])) {
                    $dateModified = $returnData[$account_role_obj->accounts_and_roles_widget_name_id];
                }

                if (empty($account_role_obj->accounts_and_roles_widget_primary_account)) {
                    $account_role_obj->accounts_and_roles_widget_primary_account = 0;
                }
                if (!empty($account_role_obj->accounts_and_roles_widget_name_id) &&
                        !in_array($account_role_obj->accounts_and_roles_widget_name_id, $avoidMultipleAccoutRows)) {
                    array_push($avoidMultipleAccoutRows, $account_role_obj->accounts_and_roles_widget_name_id);
                    $id = create_guid();
                    $sql = <<<SQL
                        INSERT INTO accounts_contacts 
                            (`id`, `contact_id`, `account_id`, `date_modified`, `primary_account`, `deleted`, `role`) 
                        VALUES ('{$id}', '{$bean->id}', '{$account_role_obj->accounts_and_roles_widget_name_id}', 
                            '{$dateModified}', '{$account_role_obj->accounts_and_roles_widget_primary_account}', 
                                '0', {$db->quoted($account_role_obj->accounts_and_roles_widget_role)});
SQL;
                    array_push($queryArray, $sql);
                    array_push($comingRecordsAccountsIds, $account_role_obj->accounts_and_roles_widget_name_id);
                }
            }

            $deletedAccountsIds = array_diff($existingRecordsAccountsIds, $comingRecordsAccountsIds);

            // Set deleted = 1 for the rows which are deleted
            if (!empty($deletedAccountsIds)) {
                $accountIdsStr = "'" . implode("' , '", $deletedAccountsIds) . "'";
                $sql = <<<SQL
                    UPDATE accounts_contacts SET deleted = '1', date_modified = '{$timedateNowDb}' 
                WHERE
                    accounts_contacts.contact_id = '{$bean->id}'
                AND accounts_contacts.account_id IN ({$accountIdsStr})
SQL;
                $db->query($sql);
            }


            $sql = <<<SQL
                    DELETE FROM accounts_contacts 
                WHERE
                    accounts_contacts.contact_id = '{$bean->id}' and deleted = '0'
SQL;
            $db->query($sql);


            // Finally executing all the queries
            // Add the relationship
            foreach ($queryArray as $query) {
                $db->query($query);
            }
        }
    }

    function findExistingAccountsRecordsIds($bean) {
        global $db;
        $existingRecordsAccountsIds = array();

        $sql = <<<SQL
            SELECT 
                accounts_contacts.account_id AS 'id',
                accounts_contacts.date_modified AS 'date_modified'
            FROM
                accounts_contacts
            WHERE
                accounts_contacts.contact_id = '{$bean->id}' and deleted = '0'
SQL;
        $res = $db->query($sql);
        while ($row = $db->fetchByAssoc($res)) {
            $existingRecordsAccountsIds[$row['id']] = $row['date_modified'];
        }

        return $existingRecordsAccountsIds;
    }

    /* function before_save_method($bean, $event, $arguments) {
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
      } */
}
