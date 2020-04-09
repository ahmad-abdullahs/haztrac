<?php

function customFormatForApiHelper(SugarBean $bean, array $fieldList = array(), array $options = array(), array $data = array()) {
    global $db;
    $accountIds = array();
    $contactIds = array();
    $accountKeyValue = array();
    $contactKeyValue = array();

    $data['accounts_contact_role_widget'] = array();

    $accounts_contact_role_widget_decoded = json_decode($bean->accounts_contact_role_widget);
    foreach ($accounts_contact_role_widget_decoded as $key => $accounts_contact_role_obj) {
        array_push($accountIds, $accounts_contact_role_obj->accounts_contact_role_widget_name_id);
        array_push($contactIds, $accounts_contact_role_obj->accounts_contact_role_widget_contact_name_id);
    }

    $sugarQuery = new SugarQuery();
    $sugarQuery->select(array('id', 'name'));
    $sugarQuery->from(BeanFactory::newBean("Contacts"));
    $sugarQuery->where()
            ->in('id', $contactIds);
    $sugarQueryResult = $sugarQuery->execute();

    foreach ($sugarQueryResult as $row) {
        $contactKeyValue[$row['id']] = implode(' ', array_filter(array(
            $row['salutation'],
            $row['first_name'],
            $row['last_name'],
        )));
    }

    $accountIdsStr = "'" . implode("' , '", $accountIds) . "'";
    $sql = <<<SQL
                    SELECT 
                    accounts.id,
                    accounts.name
                FROM
                    accounts
                WHERE
                    accounts.id IN ({$accountIdsStr})
                AND
                    accounts.deleted = 0
SQL;
    $res = $db->query($sql);
    while ($row = $db->fetchByAssoc($res)) {
        $accountKeyValue[$row['id']] = $row['name'];
    }

    foreach ($accounts_contact_role_widget_decoded as $key => $accounts_contact_role_obj) {
        if (!empty($accounts_contact_role_obj->accounts_contact_role_widget_name_id)) {
            if (!empty($accountKeyValue[$accounts_contact_role_obj->accounts_contact_role_widget_name_id])) {
                $accounts_contact_role_widget_decoded[$key]->accounts_contact_role_widget_name = $accountKeyValue[$accounts_contact_role_widget_decoded[$key]->accounts_contact_role_widget_name_id];
            } else {
                $accounts_contact_role_widget_decoded[$key]->accounts_contact_role_widget_name_id = '';
                $accounts_contact_role_widget_decoded[$key]->accounts_contact_role_widget_name = '';
            }
        }

        if ($accounts_contact_role_obj->accounts_contact_role_widget_contact_name_id) {
            if (!empty($contactKeyValue[$accounts_contact_role_obj->accounts_contact_role_widget_contact_name_id])) {
                $accounts_contact_role_widget_decoded[$key]->accounts_contact_role_widget_contact_name = $contactKeyValue[$accounts_contact_role_widget_decoded[$key]->accounts_contact_role_widget_contact_name_id];
            } else {
                $accounts_contact_role_widget_decoded[$key]->accounts_contact_role_widget_contact_name_id = '';
                $accounts_contact_role_widget_decoded[$key]->accounts_contact_role_widget_contact_name = '';
            }
        }
    }

    $data['accounts_contact_role_widget'] = json_encode((array) $accounts_contact_role_widget_decoded);

    return $data;
}
