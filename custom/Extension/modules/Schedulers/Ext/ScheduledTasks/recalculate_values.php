<?php

//add the job key to the list of job strings
array_push($job_strings, 'recalculate_values');

function recalculate_values() {
    global $db;
    $idsList = array();

    // Fetch all the Manifest Records
    $sql = "SELECT id FROM ht_manifest where deleted = 0";
    $result = $db->query($sql);

    // Go over each call...
    while ($row = $db->fetchByAssoc($result)) {
        array_push($idsList, $row['id']);
    }

    if (!empty($idsList)) {
        require_once 'include/SugarQueue/jobs/SugarJobMassUpdate.php';
        $mu_params = array(
            'module' => 'HT_Manifest',
            'action' => 'save',
            'uid' => $idsList,
        );

        $massUpdateJob = new SugarJobMassUpdate();
        $result = $massUpdateJob->runUpdate($mu_params);
        $result['status'] = 'done';
    }

    //return true for completed
    return true;
}
