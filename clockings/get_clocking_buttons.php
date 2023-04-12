<?php
require_once('../includes/functions.inc.php');
$conn = require '../includes/dbconfig.php';

error_log("get_clocking_buttons.php - Start");

if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    
    // Get the current status
    $query = "SELECT * FROM Clockings WHERE UserID = ? ORDER BY clockInTime DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $status = "";
    $buttons = "";

    if ($row) {
        $status = $row['status'];

        if ($status == 'Clocked Out') {
            $buttons = '<button class="clocking-action" data-action="clock_in">Clock In</button>';
        } elseif ($status == 'Clocked In') {
            $buttons = '<button class="clocking-action" data-action="clock_out">Clock Out</button>';
            $buttons .= '<button class="clocking-action" data-action="start_break">Start Break</button>';
        } elseif ($status == 'On Break') {
            $buttons = '<button class="clocking-action" data-action="end_break">End Break</button>';
        }
    } else {
        $status = 'Clocked Out';
        $buttons = '<button class="clocking-action" data-action="clock_in">Clock In</button>';
    }

    $response = array(
        "buttons" => $buttons,
        "status" => $status
    );

    error_log("get_clocking_buttons.php - Response: " . json_encode($response));

    echo json_encode($response);
}
?>
