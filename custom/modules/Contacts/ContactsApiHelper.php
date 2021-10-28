<?php

require_once('modules/Contacts/ContactsApiHelper.php');

// Since the ContactsApiHelper exists, we'll extend it If it didn't we would just extend the SugarBeanApiHelper
class CustomContactsApiHelper extends ContactsApiHelper {

    // Mimic the SugarBeanApiHelper->formatForApi() class
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);

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

//        $data['accounts_and_roles_widget'] = json_encode(array(
//            'accounts_and_roles_widget' => $data['accounts_and_roles_widget']
//        ));
//        return json_encode($data);
        $data['accounts_and_roles_widget'] = json_encode($data['accounts_and_roles_widget']);
        $data['contact_to_account_history'] = $this->getContactHistory($bean);
        return $data;
    }

    public function getContactHistory($bean) {
        $sql = <<<SQL
            SELECT 
                accounts_contacts.account_id AS 'accounts_and_roles_widget_name_id',
                accounts.name AS 'accounts_and_roles_widget_name',
                accounts_contacts.role AS 'accounts_and_roles_widget_role',
                accounts_contacts.primary_account AS 'accounts_and_roles_widget_primary_account',
                accounts_contacts.date_modified AS 'date_modified',
                -- DATE(accounts_contacts.date_modified) AS 'date_modified',
                accounts_contacts.deleted AS 'deleted'
            FROM
                accounts_contacts accounts_contacts
                    INNER JOIN
                accounts accounts ON accounts_contacts.account_id = accounts.id
            WHERE
                accounts_contacts.contact_id = '{$bean->id}'
            ORDER BY date_modified DESC
SQL;
        global $db;

        $res = $db->query($sql);
        $dateModified = '';
        $deleted = '';
        $htmlString = '';
        $prefix = '';
        $suffix = '</table>
  </div>
</div>';
        $index = 0;
        $cardCount = 0;

        while ($row = $db->fetchByAssoc($res)) {
            $index++;
            if ($index == 1) {
                $dateModified = $row['date_modified'];
                $deleted = $row['deleted'];
                $htmlString .= $this->getCard($row, $cardCount);
                $cardCount ++;
            }

            if ($dateModified != $row['date_modified'] || $deleted != $row['deleted']) {
                // Closing the last card
                if ($cardCount % 2 == 0 && $cardCount != 0) {
                    $htmlString .= $suffix . '</div>';
                } else {
                    $htmlString .= $suffix;
                }

                $prefix = $this->getCard($row, $cardCount);
                $tempStr = $this->getTableRow($row);
                $htmlString .= $prefix . $tempStr;

                $cardCount ++;
            } else {
                $tempStr = $this->getTableRow($row);
                $htmlString .= $tempStr;
            }

            $dateModified = $row['date_modified'];
            $deleted = $row['deleted'];
        }

        $htmlString .= $suffix;
        // Floating Div closing tag
        $htmlString .= '</div>';

        return $this->getHTMLContent($htmlString);
    }

    public function getCard($row, $cardCount) {
        global $current_user, $timedate;
        // Instantiate the TimeDate Class
        $timeDate = new TimeDate();
        // Call the function
        $localDate = $timeDate->to_display_date_time($row['date_modified'], true, true, $current_user);

//        $temp = $timedate->asUserDate($timedate->fromString($row['date_modified'], $current_user), true, $current_user);

        $color = '#f44336';
        $title = ' Removed On ' . $localDate;
        if ($row['deleted'] == 0) {
//            $color = '#8bc34a';
            $color = '';
            $title = ' Added On ' . $localDate;
        }

        $floatingDiv = '';
        if ($cardCount % 2 == 0) {
            $floatingDiv = '<div class="float-container">';
        }

        $prefix = $floatingDiv . '<div class="coupon float-child" style="">
  <div class="cardcontainer">
    <p style="margin: 0px 0px 0px;text-align: center;background-color: ' . $color . ';"><b>' . $title . '</b></p>
  </div>
  <div class="cardcontainer">
    <table class="customHistoryTable">
        <tr>
            <th class="tdAndTh thOfThable" style="width: 50%;">Account Name</th>
            <th class="tdAndTh thOfThable" style="width: 35%;">Role</th>
            <th class="tdAndTh thOfThable" style="width: 15%;">Primary</th>
        </tr>';

        return $prefix;
    }

    public function getTableRow($row) {
        return '<tr>
            <td class="tdAndTh">' . $row['accounts_and_roles_widget_name'] . '</td>
            <td class="tdAndTh">' . $row['accounts_and_roles_widget_role'] . '</td>
            <td class="tdAndTh">' . ($row['accounts_and_roles_widget_primary_account'] ? 'Yes' : 'No') . '</td>
        </tr>';
    }

    public function getHTMLContent($htmlString) {
        return '<html>
<head>
<style>
.coupon {
    border: 2px groove;
    border-radius: 2px;
}

.float-container {
    border: 3px solid #fff;
    display: flex;
}

.float-child {
    width: 50%;
    float: left;
}

.thOfThable {
    background-color: #ebedef;
}

.cardcontainer {
    background-color: #ebedef;
}

.customHistoryTable {
    width: 100%;
}

.tdAndTh {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
</style>
</head>
<body>' . $htmlString . '</body>
</html>';
    }

}
