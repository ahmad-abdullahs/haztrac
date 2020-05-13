<?php

// http://localhost/haztrac/signDoc/annotationeer/annotations/addSignature.php

require_once '../../../config.php';
require_once 'signDoc_utils.php';
require_once 'signDoc_dbConnection.php';

$id = create_guid();
$dateTime = date("Y-m-d H:i:s");
$data = json_decode(file_get_contents('php://input'), true);
$sugar_user_id = $data['sugar_user_id'];
$width = $data['width'];
$height = $data['height'];
$signature = $data['signature'];

//error_log(print_r($_REQUEST, TRUE));
//error_log(print_r($_POST, TRUE));
//error_log(print_r($_GET, TRUE));
//error_log(print_r($HTTP_POST_VARS, TRUE));
//error_log(print_r(json_decode(file_get_contents('php://input'), true), TRUE));

$sql = "INSERT INTO signdoc_user_signatures 
            (id, 
             sugar_user_id, 
             date_entered, 
             date_modified, 
             deleted, 
             width, 
             height, 
             signature) 
VALUES      ('{$id}', 
             '{$sugar_user_id}', 
             '{$dateTime}', 
             '{$dateTime}', 
             '0', 
             '{$width}', 
             '{$height}', 
             '{$signature}' 
            );";

if ($conn->query($sql) === TRUE) {
//    echo "Signature is added";
} else {
//    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "SELECT max(signature_id) as signature_id FROM signdoc_user_signatures";
$result = mysqli_query($conn, $sql);

$signature_id = '';
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $signature_id = $row["signature_id"];
    }
} else {
    echo "0 results";
}

$conn->close();

echo json_encode(array(
    'id' => $signature_id,
    'username' => '',
    'signature' => $data['signature'],
    'width' => $data['width'],
    'height' => $data['height'],
));
