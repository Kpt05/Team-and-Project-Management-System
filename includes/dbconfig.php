<?php

$host = "localhost";
$dbname = "Source_Tech";
$dbusername = "root";
$dbpassword = "root";

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

return $conn;
