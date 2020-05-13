<?php

require_once '../../../config.php';
require_once 'signDoc_utils.php';
require_once 'signDoc_dbConnection.php';

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
