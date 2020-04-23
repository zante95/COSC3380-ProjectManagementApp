<?php
error_reporting( E_ALL );
ini_set( "display_errors", 1 );
ini_set('date.timezone','America/Chicago');
$date_now = date("Y-m-d H:i:s");
$clock_now = date("H:i:s");
$dayname = date("l");
$servername = "localhost";
$username = "jdlimano";
$password = "password";
$dbname = "projectmanagementapp";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?> 