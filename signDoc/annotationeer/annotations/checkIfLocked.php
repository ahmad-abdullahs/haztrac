<?php

require_once '../../../config.php';
require_once 'signDoc_utils.php';
require_once 'signDoc_dbConnection.php';

$docStatus = array(
    'is_locked' => 0,
);

$document_id = $_GET['document_id'];
if ($document_id) {
    $sql = "SELECT 
            is_locked
        FROM
            mv_attachments
        WHERE
            id = '{$document_id}'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $docStatus = array(
                'is_locked' => $row['is_locked'],
            );
        }
    }

    mysqli_close($conn);
}

echo json_encode($docStatus);
