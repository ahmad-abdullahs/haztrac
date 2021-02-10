<?php

// http://localhost/haztrac/signDoc/annotationeer/annotations/deleteAnnotation.php

require_once '../../../config.php';
require_once 'signDoc_utils.php';
require_once 'signDoc_dbConnection.php';

$data = json_decode(file_get_contents('php://input'), true);
$document_id = $data['document_id'];
$annotation_id = $data['id'];

if (!empty($document_id) && !empty($annotation_id)) {
    if ($annotation_id == 'all') {
        $sql = "UPDATE 
            signdoc_annotations 
        SET 
            deleted='1'
        WHERE
            document_id = '{$document_id}';";
    } else {
        $sql = "UPDATE 
            signdoc_annotations 
        SET 
            deleted='1'
        WHERE
            annotation_id = '{$annotation_id}' AND document_id = '{$document_id}';";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Annotation is deleted",));
    } else {
        echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error,));
    }
}

$conn->close();
