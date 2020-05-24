<?php

class sales_and_servicesApiHelper extends SugarBeanApiHelper {

    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $ret = parent::formatForApi($bean, $fieldList, $options);

        // This check can be added for the performance reasons
        if (in_array('transporter_carrier_c', $fieldList)) {
            $ret = $this->removeDeletedRecordsFromJson($ret);
        }

        return $ret;
    }

    public function removeDeletedRecordsFromJson($ret) {
        $transporter_carrier_c = $ret['transporter_carrier_c'];
        global $db;
        $transporterIds = array();
        $accountIds = array();
        $transporterArr = array();

        if (!empty($transporter_carrier_c)) {
            $transporter_carrier_c = json_decode($transporter_carrier_c, true);

            if (!empty($transporter_carrier_c)) {
                // Get the transporter ids to compare
                foreach ($transporter_carrier_c as $transporter) {
                    array_push($transporterIds, $transporter['id']);
                }

                // Filter and sort the array
                $transporterIds = array_filter($transporterIds);
                sort($transporterIds);

                // Fecth from DB to check if any account was deleted?
                $sql = "SELECT 
                            accounts.id AS 'id',
                            accounts.name AS 'name'
                        FROM
                            accounts
                        WHERE
                            accounts.deleted = '0'
                                AND accounts.id  IN( '" . implode("','", $transporterIds) . "' );";

                $res = $db->query($sql);
                while ($row = $db->fetchByAssoc($res)) {
                    array_push($accountIds, $row['id']);
                }

                // Sort the array
                sort($accountIds);

                // If both the arrays are different it means there was any account which was deleted 
                // but the Json was not updated, So we need to rebuild the Json and send it to the view.
                if ($transporterIds != $accountIds) {
                    foreach ($transporter_carrier_c as $transporter) {
                        if (in_array($transporter['id'], $accountIds)) {
                            array_push($transporterArr, $transporter);
                        }
                    }

                    $transporter_carrier_c = json_encode($transporterArr);
                    $ret['transporter_carrier_c'] = $transporter_carrier_c;
                }
            }
        }

        return $ret;
    }

}
