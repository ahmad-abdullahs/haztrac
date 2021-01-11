<?php

// http://localhost/haztrac/signDoc/annotationeer/annotations/deleteAnnotation.php

require_once '../../../config.php';
require_once 'signDoc_utils.php';
require_once 'signDoc_dbConnection.php';

$data = json_decode(file_get_contents('php://input'), true);
$document_id = $data['document_id'];
$annotation_id = $data['id'];

$sql = "UPDATE 
            signdoc_annotations 
        SET 
            deleted='1'
        WHERE
            annotation_id = '{$annotation_id}' AND document_id = '{$document_id}';";

if ($conn->query($sql) === TRUE) {
    //    echo "Annotation is deleted";
} else {
    //    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
