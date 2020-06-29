<?php

//add the job key to the list of job strings
array_push($job_strings, 'fetch_epa_info');

function fetch_epa_info() {
    require_once 'custom/modules/Accounts/clients/base/api/getEPAInformation.php';
    $epaInfoHandler = new getEPAInformation();
    global $db;
    $epaIdsList = array();

    // Fetch all the Manifest Records
    $sql = "SELECT 
            TRIM(accounts_cstm.ac_usepa_id_c) AS ac_usepa_id_c
        FROM
            accounts
                LEFT JOIN
            accounts_cstm ON accounts.id = accounts_cstm.id_c
        WHERE
            accounts.deleted = 0
                AND (ac_usepa_id_c != ''
                AND ac_usepa_id_c IS NOT NULL);";
    $result = $db->query($sql);

    // Go over each call...
    while ($row = $db->fetchByAssoc($result)) {
        array_push($epaIdsList, $row['ac_usepa_id_c']);
    }

    if (!empty($epaIdsList)) {
        foreach ($epaIdsList as $epaId) {
            $ret = $epaInfoHandler->getEPAInformationMethod(null, array('epaID' => $epaId));
            if ($ret['src']) {
                $GLOBALS['log']->fatal("SCHEDULER::fetch_epa_info EPA Information for #$epaId is successfully received");
            } else {
                $GLOBALS['log']->fatal("SCHEDULER::fetch_epa_info No EPA Information received for #$epaId");
            }
        }
    }

    //return true for completed
    return true;
}
