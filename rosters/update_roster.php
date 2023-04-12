<?php
error_reporting(0); // Disable all errors and warnings
session_start(); // Start the session
require('../includes/functions.inc.php'); // Include the functions file
$conn = require(__DIR__ . '/../includes/dbconfig.php'); // Include the database connection file and get the connection object

// Disable strict mode temporarily
$disableStrictMode = "SET sql_mode = ''"; 
if (!mysqli_query($conn, $disableStrictMode)) { // If any error occurs, send a failure response with an error message
    // If any error occurs, send a failure response with an error message
    $error_message = mysqli_error($conn);
    echo json_encode(['success' => false, 'message' => "Error disabling strict mode: $error_message"]); // Send a failure response with an error message
    exit;
}


header('Content-Type: application/json'); // Set the content type to JSON

// Get the data from the request
$requestData = json_decode(file_get_contents('php://input'), true); // Get the request data as an associative array
$data = $requestData['data']; // Get the data array

if (!isset($requestData['empNo'])) { // If empNo is not provided, send a failure response
    echo json_encode(['success' => false, 'message' => "Error: empNo is not provided."]); // Send a failure response with an error message
    exit;
}

$empNo = $requestData['empNo']; // Get the empNo


// Get the teamID from the Users table using empNo
$sql = "SELECT UserID, teamID FROM Users WHERE empNo = " . $empNo; // Replace 'Users' with your actual table name
$result = mysqli_query($conn, $sql); // Execute the query
$row = mysqli_fetch_assoc($result); // Get the result as an associative array
$userID = $row['UserID']; // Get the userID
$teamID = $row['teamID']; // Get the teamID

// Loop through each entry and update the Roster table
foreach ($data as $entry) { // Loop through each entry
    $date = $entry['date'];
    $attendanceCode = $entry['attendanceCode']; // Get the attendance code

    // Check if the entry already exists
    $sql = "SELECT * FROM Roster WHERE userID = $userID AND shiftDate = '$date'";
    $result = mysqli_query($conn, $sql); // Execute the query
    $row = mysqli_fetch_assoc($result); // Get the result as an associative array

    if ($row) {
        // Update the existing entry
        $sql = "UPDATE Roster SET attendanceCode = '$attendanceCode' WHERE rosterID = {$row['rosterID']}"; // This updates the existing entry with the new attendance code and the same rosterID
    } else {
        // Insert a new entry
        $sql = "INSERT INTO Roster (attendanceCode, shiftDate, teamID, userID) VALUES ('$attendanceCode', '$date', $teamID, $userID)"; // If the entry does not exist, insert a new entry with the attendance code, date, teamID and userID
    }

    // Log the SQL query before execution
    error_log("Executing SQL query: $sql"); // Log the SQL query before execution

    // Execute the query
    if (!mysqli_query($conn, $sql)) { // If any error occurs, send a failure response with an error message
        // If any error occurs, send a failure response with an error message
        $error_message = mysqli_error($conn); // Get the error message
        echo json_encode(['success' => false, 'message' => "Error executing query: $error_message"]); // Send a failure response with an error message
        exit;
    }
}

// If all updates are successful, send a success response
echo json_encode(['success' => true]);

