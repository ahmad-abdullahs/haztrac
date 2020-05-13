<?php

// http://localhost/haztrac/signDoc/annotationeer/annotations/deleteSignature.php?signature_id=1

require_once '../../../config.php';
require_once 'signDoc_utils.php';
require_once 'signDoc_dbConnection.php';

$signature_id = $_GET['signature_id'];

//error_log(print_r($signature_id, TRUE));

$sql = "DELETE FROM signdoc_user_signatures WHERE signature_id='{$signature_id}'";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
echo true;
