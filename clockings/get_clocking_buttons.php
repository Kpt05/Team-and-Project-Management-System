<?php
require_once('../includes/functions.inc.php'); // Includes all the functions from the functions file
$conn = require '../includes/dbconfig.php'; // Connects to the database and returns the connection

error_log("get_clocking_buttons.php - Start"); // Logs the start of the script, useful for debugging

if (isset($_POST['userID'])) { // Checks if the userID has been set
    $userID = $_POST['userID']; // Gets the userID from the POST request
    
    // Get the current status
    $query = "SELECT * FROM Clockings WHERE UserID = ? ORDER BY clockInTime DESC LIMIT 1"; // Gets the latest clocking for the user
    $stmt = $conn->prepare($query); // Prepares the query for execution
    $stmt->bind_param("i", $userID); // Binds the parameters to the query
    $stmt->execute(); // Executes the query
    $result = $stmt->get_result(); // Gets the result of the query
    $row = $result->fetch_assoc(); // Gets the first row of the result

    $status = ""; // Sets the status to an empty string
    $buttons = ""; // Sets the buttons to an empty string

    // Checks if the row exists and sets the status and buttons accordingly
    if ($row) {
        $status = $row['status']; // Sets the status to the status of the clocking

        if ($status == 'Clocked Out') { // Sets the buttons based on the status
            $buttons = '<button class="clocking-card clocking-action clock-in-out" data-action="clock_in">Clock In</button>'; // Sets the buttons to the clock in button
        } elseif ($status == 'Clocked In') { // Sets the buttons based on the status
            $buttons = '<button class="clocking-card clocking-action clock-in-out" data-action="clock_out">Clock Out</button>'; // Sets the buttons to the clock out button
            $buttons .= '<button class="clocking-card clocking-action break-action" data-action="start_break">Start Break</button>'; // Adds the start break button to the buttons
        } elseif ($status == 'On Break') { // Sets the buttons based on the status
            $buttons = '<button class="clocking-card clocking-action break-action" data-action="end_break">End Break</button>'; // Sets the buttons to the end break button
        }
        
    } else { // If the row doesn't exist, set the status to clocked out and the buttons to the clock in button
        $status = 'Clocked Out';
        $buttons = '<button class="clocking-action" data-action="clock_in">Clock In</button>';
    }

    $response = array( // Creates the response array
        "buttons" => $buttons, // Adds the buttons to the response array
        "status" => $status // Adds the status to the response array
    );

    error_log("get_clocking_buttons.php - Response: " . json_encode($response)); // Logs the response, useful for debugging
    echo json_encode($response); // Returns the response as a JSON object
}
