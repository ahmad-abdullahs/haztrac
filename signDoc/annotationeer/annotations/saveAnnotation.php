<?php

// http://localhost/haztrac/signDoc/annotationeer/annotations/saveAnnotation.php

require_once '../../../config.php';
require_once 'signDoc_utils.php';
require_once 'signDoc_dbConnection.php';

$id = create_guid();
$dateTime = date("Y-m-d H:i:s");
$data = json_decode(file_get_contents('php://input'), true);
$document_id = $data['document_id'];
$user_id = $data['user_id'];
$annotation_id = $data['id'];
$annotation = json_encode($data);

// means this is the new annotation, so this is the insert operation
if ($annotation_id == 0) {
    // Get the max annotation_id of this doc
    $sql = "SELECT max(annotation_id) AS annotation_id FROM signdoc_annotations "
            . "WHERE document_id='{$document_id}' AND deleted=0";
    $result = mysqli_query($conn, $sql);

    $signature_id = '';
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $annotation_id = $row["annotation_id"];
        }
    }

    $annotation_id = $annotation_id + 1;

    $sql = "INSERT INTO signdoc_annotations 
                (id,annotation_id,document_id,annotation,user_id,date_entered,date_modified,deleted) 
            VALUES      
            ('{$id}','{$annotation_id}','{$document_id}','{$annotation}','{$user_id}','{$dateTime}','{$dateTime}','0');";

    if ($conn->query($sql) === TRUE) {
        //    echo "Annotation is added";
    } else {
        //    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $data['id'] = $annotation_id;
    echo json_encode($data);
} else {
    // This is the update operation
    $sql = "UPDATE signdoc_annotations
        SET 
            annotation = '{$annotation}',
            date_modified = '{$dateTime}'
        WHERE
            annotation_id = '{$annotation_id}' AND document_id = '{$document_id}' AND deleted = 0;";

    if ($conn->query($sql) === TRUE) {
        //    echo "Annotation is updated";
    } else {
        //    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    echo json_encode($data);
}

$conn->close();
