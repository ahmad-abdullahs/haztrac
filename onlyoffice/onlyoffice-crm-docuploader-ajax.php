<?php

/**
 *
 * (c) Copyright Ascensio System SIA 2021
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
/**
 * WebEditor AJAX Process Execution.
 */
require_once( dirname(__FILE__) . '/config.php' );
require_once( dirname(__FILE__) . '/ajax.php' );
require_once( dirname(__FILE__) . '/common.php' );
require_once( dirname(__FILE__) . '/functions.php' );
require_once( dirname(__FILE__) . '/jwtmanager.php' );
require_once( dirname(__FILE__) . '/trackmanager.php' );

$_trackerStatus = array(
    0 => 'NotFound',
    1 => 'Editing',
    2 => 'MustSave',
    3 => 'Corrupted',
    4 => 'Closed',
    6 => 'MustForceSave',
    7 => 'CorruptedForceSave'
);

$logFile = "onlyoffice-crm-docuploader-ajax";

if (isset($_GET["type"]) && !empty($_GET["type"])) { //Checks if type value exists
    $response_array;
    @header('Content-Type: application/json; charset==utf-8');
    @header('X-Robots-Tag: noindex');
    @header('X-Content-Type-Options: nosniff');

    nocache_headers();

    sendlog(serialize($_GET), $logFile);

    $type = $_GET["type"];

    switch ($type) { //Switch case for value of type
        case "upload":
            $response_array = upload($logFile);
            $response_array['status'] = isset($response_array['error']) ? 'error' : 'success';
            sendlog("Ahmad is here!!", $logFile);
            sendlog(serialize(json_encode($response_array)), $logFile);
            die(json_encode($response_array));
        default:
            $response_array['status'] = 'error';
            $response_array['error'] = '404 Method not found';
            die(json_encode($response_array));
    }
}

function upload($logFile) {
    $result;
    $filename;

    if ($_FILES['files']['error'] > 0) {
        $result["error"] = 'Error ' . json_encode($_FILES['files']['error']);
        return $result;
    }

    $tmp = $_FILES['files']['tmp_name'];

    sendlog('$tmp : ' . $tmp, $logFile);
    sendlog(serialize(json_encode($_FILES)), $logFile);

    if (empty(tmp)) {
        $result["error"] = 'No file sent';
        return $result;
    }

    if (is_uploaded_file($tmp)) {
        $filesize = $_FILES['files']['size'];
        $ext = strtolower('.' . pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION));

        if ($filesize <= 0 || $filesize > $GLOBALS['FILE_SIZE_MAX']) {
            $result["error"] = 'File size is incorrect';
            return $result;
        }

        if (!in_array($ext, getFileExts())) {
            $result["error"] = 'File type is not supported';
            return $result;
        }

//        $filename = GetCorrectName($_FILES['files']['name']);
        // Create Guid for the document
        $id = create_guid_section(32);
        $filename = $id . $ext;

        if (!move_uploaded_file($tmp, getStoragePath($filename))) {
            $result["error"] = 'Upload failed';
            return $result;
        }

        sendlog('$filename : ' . $filename, $logFile);

        createMeta($filename);

        // Create the Doc_Manager bean with the same id.
        createDocManagerBean($id, $_FILES['files']['name']);
    } else {
        $result["error"] = 'Upload failed';
        return $result;
    }

    $result["filename"] = $filename;
    $result["id"] = $id;
    $result["name"] = $_FILES['files']['name'];
    $result["documentType"] = getDocumentType($filename);
    return $result;
}

function create_guid_section($characters) {
    $return = "";
    for ($i = 0; $i < $characters; $i++) {
        $return .= dechex(mt_rand(0, 15));
        if ($i == 7 || $i == 11 || $i == 15 || $i == 19) {
            $return .= '-';
        }
    }

    return $return;
}

function createDocManagerBean($id, $name) {
    require_once (dirname(__FILE__) . '/../config.php');
    require_once (dirname(__FILE__) . '/../config_override.php');

    $dbconfig = $sugar_config['dbconfig'];

    $servername = $dbconfig['db_host_name'];
    $username = $dbconfig['db_user_name'];
    $password = $dbconfig['db_password'];
    $dbname = $dbconfig['db_name'];

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $dateTime = date("Y-m-d H:i:s");

    $docTemplate = $sugar_config['additional_js_config']['docManagerURL']['url'] . "doceditor.php?fileID={$id}.docx&action=view";

    $sql = "INSERT INTO doc_manager 
                (id,name,doc_template,assigned_user_id,date_entered,date_modified,deleted) 
            VALUES      
            ('{$id}','{$name}','{$docTemplate}','1','{$dateTime}','{$dateTime}','0');";

    if ($conn->query($sql) === TRUE) {
        //    echo "Document is created.";
    } else {
        //    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>