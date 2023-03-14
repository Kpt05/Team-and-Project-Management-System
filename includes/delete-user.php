<?php
// Check if the employee ID was sent in the request
if (isset($_POST['empNo'])) {
    $empNo = $_POST['empNo'];

    // Connect to the database

    $conn = require __DIR__ . '/dbconfig.php';

    // Check if the connection was successful
    if (!$conn) {
        die('Could not connect to the database: ' . mysqli_connect_error());
    }

    // Prepare the SQL statement to delete the user
    $sql = "DELETE FROM Users WHERE empNo = $empNo";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
        echo 'User deleted successfully';
    } else {
        echo 'Error deleting user: ' . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo 'No employee ID specified';
}
