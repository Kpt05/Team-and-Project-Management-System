<?php
// Path: includes/dbconfig.php
// This file is used to connect to the database, and is included in all pages that need to connect to the database.
// For the database connection to work, it needs to have the host, database name, username and password.
$host = "localhost"; // Here I am setting the host variable to localhost, which is the default host for a local database.
$dbname = "Source_Tech"; // Here I am setting the database name variable to Source_Tech, which is the name of the database I created.
$dbusername = "root"; // Here I am setting the username variable to root, which is the default username for a local database.
$dbpassword = "root"; // Here I am setting the password variable to root, which is the default password for a local database.

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname); // Here I am creating a new mysqli object, and passing in the host, username, password and database name variables.
// This is the conn variable that is used on evert page that needs to connect to the database.

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // If the connection fails, then the script will die and display the error.
}

return $conn; // This returns the connection variable, so that it can be used on other pages.
