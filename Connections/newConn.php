<?php

$servername = "localhost";
$username = "junren";
$password = "360038";
$dbname = "projectmanagementapp";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>