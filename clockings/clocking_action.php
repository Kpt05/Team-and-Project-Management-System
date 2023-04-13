<?php

require_once('../includes/functions.inc.php'); // This includes all the functions from the functions.inc.php file
// Make a database connection
$conn = require '../includes/dbconfig.php'; // This includes the database connection from the dbconfig.php file and assigns it to the $conn variable

error_log("clocking_action.php - Start"); // This will log the message to the error log file, making it easier to debug

if (isset($_POST['userID']) && isset($_POST['action'])) { // Check if the userID and action variables are set
    $userID = $_POST['userID']; // Assign the userID variable to the userID POST variable
    $action = $_POST['action']; // Assign the action variable to the action POST variable

    // Check if the user is clocked in or out, using swtich case selection to determine the action
    switch ($action) { // Check the action variable
        case "clock_in": // If the action variable is clock_in
            $status = "Clocked In"; // Set the status variable to Clocked In
            $clockInTime = date("Y-m-d H:i:s"); // Set the clockInTime variable to the current date and time
            $hoursWorked = 0; // Set the hoursWorked variable to 0
            $breakDuration = 0; // // Set the breakDuration variable to 0
            $query = "INSERT INTO Clockings (UserID, status, clockInTime, hoursWorked, breakDuration) VALUES (?, ?, ?, ?, ?)"; // Create the SQL query
            $stmt = $conn->prepare($query); // Prepare the SQL query
            $stmt->bind_param("issii", $userID, $status, $clockInTime, $hoursWorked, $breakDuration); // Bind the variables to the SQL query
            $stmt->execute(); // Execute the SQL query
            $affectedRows = $stmt->affected_rows; // Get the number of affected rows
            error_log("clocking_action.php - Clock In - Affected Rows: " . $affectedRows); // Log the number of affected rows to the error log file
            error_log("clocking_action.php - Clock In - SQL Error: " . $stmt->error); // Log the SQL error to the error log file if there is one
            break;
        
        case "clock_out": // If the action variable is clock_out
            $status = "Clocked Out"; // Set the status variable to Clocked Out
            $clockOutTime = date("Y-m-d H:i:s"); // Set the clockOutTime variable to the current date and time
            $query = "UPDATE Clockings SET status=?, clockOutTime=?, hoursWorked=TIMESTAMPDIFF(HOUR, clockInTime, clockOutTime) WHERE UserID=? AND status='Clocked In'"; // Create the SQL query to update the clocking
            $stmt = $conn->prepare($query); // Prepare the SQL query to update the clocking
            $stmt->bind_param("ssi", $status, $clockOutTime, $userID); // Bind the variables to the SQL query to update the clocking
            $stmt->execute(); // Execute the SQL query to update the clocking 
            error_log("clocking_action.php - Clock Out - Affected Rows: " . $stmt->affected_rows); // Log the number of affected rows to the error log file 
            break;
        case "start_break": // If the action variable is start_break 
            $status = "On Break"; // Set the status variable to On Break 
            $breakStartTime = date("Y-m-d H:i:s"); // Set the breakStartTime variable to the current date and time and format it
            $query = "UPDATE Clockings SET status=?, breakStartTime=? WHERE UserID=? AND status='Clocked In'"; // Create the SQL query to update the clocking 
            $stmt = $conn->prepare($query); // Prepare the SQL query to update the clocking
            $stmt->bind_param("ssi", $status, $breakStartTime, $userID); // Bind the variables to the SQL query to update the clocking
            $stmt->execute(); // Execute the SQL query to update the clocking
            error_log("clocking_action.php - Start Break - Affected Rows: " . $stmt->affected_rows); // Log the number of affected rows to the error log file and format it
            break;
        case "end_break": // If the action variable is end_break
            $status = "Clocked In"; // Set the status variable to Clocked In
            $breakEndTime = date("Y-m-d H:i:s"); // Set the breakEndTime variable to the current date and time and format it
            $query = "UPDATE Clockings SET status=?, breakEndTime=?, breakDuration=TIMESTAMPDIFF(MINUTE, breakStartTime, breakEndTime) WHERE UserID=? AND status='On Break'"; // Create the SQL query to update the clocking 
            $stmt = $conn->prepare($query); // Prepare the SQL query to update the clocking
            $stmt->bind_param("ssi", $status, $breakEndTime, $userID); // Bind the variables to the SQL query to update the clocking. the sss is for the data types of the variables
            $stmt->execute(); // Execute the SQL query to update the clocking
            error_log("clocking_action.php - End Break - Affected Rows: " . $stmt->affected_rows); // Log the number of affected rows to the error log file and format it as a string
            break;
    }
    
    error_log("clocking_action.php - Processed request"); // Log the message to the error log file and format it as a string, making it easier to debug
    echo "Success"; // Return the string Success to the AJAX request
}
?>
