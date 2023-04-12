<?php

require_once('../includes/functions.inc.php');
// Make a database connection
$conn = require '../includes/dbconfig.php';

error_log("clocking_action.php - Start");

if (isset($_POST['userID']) && isset($_POST['action'])) {
    $userID = $_POST['userID'];
    $action = $_POST['action'];

    switch ($action) {
        case "clock_in":
            $status = "Clocked In";
            $clockInTime = date("Y-m-d H:i:s");
            $hoursWorked = 0;
            $breakDuration = 0; // Add this line
            $query = "INSERT INTO Clockings (UserID, status, clockInTime, hoursWorked, breakDuration) VALUES (?, ?, ?, ?, ?)"; // Modify this line
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issii", $userID, $status, $clockInTime, $hoursWorked, $breakDuration); // Modify this line
            $stmt->execute();
            $affectedRows = $stmt->affected_rows;
            error_log("clocking_action.php - Clock In - Affected Rows: " . $affectedRows);
            error_log("clocking_action.php - Clock In - SQL Error: " . $stmt->error);
            break;
        
        case "clock_out":
            $status = "Clocked Out";
            $clockOutTime = date("Y-m-d H:i:s");
            $query = "UPDATE Clockings SET status=?, clockOutTime=?, hoursWorked=TIMESTAMPDIFF(HOUR, clockInTime, clockOutTime) WHERE UserID=? AND status='Clocked In'";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $status, $clockOutTime, $userID);
            $stmt->execute();
            error_log("clocking_action.php - Clock Out - Affected Rows: " . $stmt->affected_rows); // Add this line
            break;
        case "start_break":
            $status = "On Break";
            $breakStartTime = date("Y-m-d H:i:s");
            $query = "UPDATE Clockings SET status=?, breakStartTime=? WHERE UserID=? AND status='Clocked In'";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $status, $breakStartTime, $userID);
            $stmt->execute();
            error_log("clocking_action.php - Start Break - Affected Rows: " . $stmt->affected_rows); // Add this line
            break;
        case "end_break":
            $status = "Clocked In";
            $breakEndTime = date("Y-m-d H:i:s");
            $query = "UPDATE Clockings SET status=?, breakEndTime=?, breakDuration=TIMESTAMPDIFF(MINUTE, breakStartTime, breakEndTime) WHERE UserID=? AND status='On Break'";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $status, $breakEndTime, $userID);
            $stmt->execute();
            error_log("clocking_action.php - End Break - Affected Rows: " . $stmt->affected_rows); // Add this line
            break;
    }
    
    error_log("clocking_action.php - Processed request");
    echo "Success";
}
?>
