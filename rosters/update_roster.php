<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require('../includes/functions.inc.php');
$conn = require(__DIR__ . '/../includes/dbconfig.php');

$disableStrictMode = "SET sql_mode = ''";
if (!mysqli_query($conn, $disableStrictMode)) {
    $error_message = mysqli_error($conn);
    echo json_encode(['success' => false, 'message' => "Error disabling strict mode: $error_message"]);
    exit;
}

header('Content-Type: application/json');

$requestData = json_decode(file_get_contents('php://input'), true);
$data = $requestData['data'];

if (!isset($requestData['empNo'])) {
    echo json_encode(['success' => false, 'message' => "Error: empNo is not provided."]);
    exit;
}

$empNo = $requestData['empNo'];

$sql = "SELECT UserID, teams AS teamID FROM Users WHERE empNo = " . $empNo;
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo json_encode(['success' => false, 'message' => "Error: Unable to retrieve userID and teamID from the Users table."]);
    exit;
}

$row = mysqli_fetch_assoc($result);
$userID = $row['UserID'];
$teamID = $row['teamID'];

foreach ($data as $entry) {
    $date = $entry['date'];
    $attendanceCode = mysqli_real_escape_string($conn, $entry['attendanceCode']);    

    $sql = "SELECT * FROM Roster WHERE userID = $userID AND shiftDate = '$date'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $sql = "UPDATE Roster SET attendanceCode = '$attendanceCode' WHERE rosterID = {$row['rosterID']}";
    } else {
        $sql = "INSERT INTO Roster (attendanceCode, shiftDate, teamID, userID) VALUES ('$attendanceCode', '$date', '$teamID', $userID)";
    }

    error_log("Executing SQL query: $sql");

    if (!mysqli_query($conn, $sql)) {
        $error_message = mysqli_error($conn);
        echo json_encode(['success' => false, 'message' => "Error executing query: $error_message"]);
        exit;
    }
}

echo json_encode(['success' => true]);
?>
