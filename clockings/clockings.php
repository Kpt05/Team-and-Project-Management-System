<!--Created by Kevin Titus on 2022-07-21.-->
<!-- PHP intergration -->
<?php
// Start a session to get the employee number from the session and use it to get the first name, last name and account type of the user
session_start();
require_once('../includes/functions.inc.php'); // Include the functions file
// Make a database connection
$conn = require '../includes/dbconfig.php'; // Include the database connection file and store the connection in a variable

require_once '../includes/authentication.inc.php'; // Include the authentication.php file
$empNo = $_SESSION['empNo']; // Get the employee number from the session
$firstName = getFirstName($conn, $empNo); // Get the first name from the database
$userID = getUserId($conn, $empNo); // Get the user ID from the database
$lastName = getLastName($conn, $empNo); // Get the last name from the database
$accountType = getAccountType($conn, $empNo); // Get the account type from the database

// Authenticate the user
$isAuthenticated = authenticate($conn);

if (!$isAuthenticated) {
    // If not authenticated, redirect to the login page
    header("Location: ../index.php?error=notloggedin");
    exit();
}

// Find the corresponding UserID for the empNo
$query = "SELECT UserID FROM Users WHERE empNo = ?"; // Query to find the UserID
$stmt = $conn->prepare($query); // Prepare the query
$stmt->bind_param("i", $empNo); // Bind the parameters
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result
$row = $result->fetch_assoc();  // Fetch the result

// Check if the user was found
if ($row) {
    $userID = $row['UserID']; // Set the user ID

    // Check for the latest clocking entry for the user
    $query = "SELECT * FROM Clockings WHERE UserID = ? ORDER BY clockInTime DESC LIMIT 1"; // Query to find the latest clocking entry
    $stmt = $conn->prepare($query); // Prepare the query
    $stmt->bind_param("i", $userID); // Bind the parameters
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result(); // Get the result
    $row = $result->fetch_assoc(); // Fetch the result

    if ($row) { // Check if the user has a clocking entry
        $status = $row['status']; // Get the status of the clocking entry
    } else {
        // Insert a new record with the status 'Clocked Out' if the user doesn't have a clocking entry
        $status = "Clocked Out"; // Set the status to 'Clocked Out'
        $query = "INSERT INTO Clockings (UserID, status) VALUES (?, ?)"; // Query to insert a new clocking entry
        $stmt = $conn->prepare($query); // Prepare the query
        $stmt->bind_param("is", $userID, $status); // Bind the parameters
        $stmt->execute(); // Execute the query
    }
} else {
    // Handle user not found
    echo "User not found"; // Display an error message
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Source Tech Portal</title> <!-- Title of the page -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" /> <!-- Feather icons -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icons -->
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" /> <!-- Base plugin css for this page -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" /> <!-- Data table css -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icons -->
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css" /> <!-- Data table css -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css"> <!-- Bootstrap icons -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- JQuery -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"> <!-- Bootstrap icons -->

    <!-- End plugin css for this page -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" /> <!-- Custom styles for this page -->
    <link rel="shortcut icon" href="../images/favicon.ico" />

</head>

<style>
    /* Loader */
    * {
        margin: 0;
        padding: 0;
    }

    .loader {
        position: fixed;
        top: 0;
        left: 0;
        background: #ededee;
        height: 100%;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 99999;
    }

    .disppear {
        animation: vanish 1.5s forwards;
    }

    @keyframes vanish {
        100% {
            opacity: 0;
            visibility: hidden;
        }
    }


    /* Clocking Cards */
    .clocking-card {
        border-radius: 10px;
        display: inline-flex;
        font-size: 2rem;
        margin: 1rem;
        padding: 5rem 2rem;
        text-align: center;
        text-decoration: none;
        transition: transform 0.3s;
        width: 40rem;
        height: 50vh;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    /* Clocking Cards - Clock In */
    .clock-in-out {
        background-color: #667C89;
        color: white;
        opacity: 1;
    }

    /* Clocking Cards - Break */
    .break-action {
        background-color: #FFA500;
        color: white;
        opacity: 0.87;
    }

    @media (min-width: 768px) {
        .clocking-card {
            width: calc(50% - 6rem);
        }
    }

    @media (min-width: 1200px) {
        .clocking-card {
            width: calc(40% - 6rem);
        }
    }

    /* Clocking Cards - Hover */
    .clocking-card:hover {
        transform: translateY(-5px) scale(1.05);
        cursor: pointer;
    }

    /* Clocking Cards - Disabled */
    .user-status-container {
        font-size: 1.5rem;
        text-align: center;
        margin-bottom: 2rem;
    }

    /* The user status styling */
    #user-status {
        font-weight: bold;
    }
</style>

<body>
    <!-- Loader -->
    <div class="loader">
        <img src="../images/loader.gif" alt="" />
    </div>

    <div class="container-scroller">

        <!-- partial:includes/_navbar.php -->
        <?php include "../includes/_navbar.php"; ?> <!-- Navbar -->

        <div class="container-fluid page-body-wrapper">

            <!-- partial:includes/_adminsidebar.php -->
            <?php include '../includes/_adminsidebar.php'; ?> <!-- Sidebar -->

            <!-- partial -->
            <div class="main-panel">

                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row justify-content-center">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold">Clockings</h2> <!-- Page title -->
                                </div>
                                <div class="col-12 col-xl-4 text-right font-weight-bold" style="font-size: 23px; margin-top: 20px; margin-right: -50px; text-align: right;">
                                    <div class="text-center">
                                        <?php
                                        $date = date('l, j M'); // Day, Date Month
                                        $time = date('H:i'); // Hour:Minute
                                        echo "<div>$date</div>"; // Display the date
                                        echo "<div>$time</div>"; // Display the time
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="user-status-container">
                                User status: <span id="user-status"><?php echo $status; ?></span> <!-- The user status will be loaded here via JavaScript -->
                            </div>
                            <div id="clocking-buttons" class="text-center">
                                <!-- The buttons will be loaded here via JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> <!-- Select2 library -->
                <script>
                    const userID = <?php echo $userID; ?>; // The user ID is passed to JavaScript via PHP

                    function loadButtonsAndStatus() { // This function loads the buttons and status
                        console.log('Loading buttons and status for user ID:', userID); 
                        // The AJAX request is sent to the get_clocking_buttons.php file
                        $.ajax({
                            url: 'get_clocking_buttons.php',  // The get_clocking_buttons.php file is called
                            method: 'POST', // The method is POST which is used to send data to the server
                            dataType: 'json', // The data type is JSON which is used to send data to the server
                            data: {
                                userID: userID // The user ID is passed to the server
                            },
                            success: function(response) { // If the request is successful, the response is returned
                                console.log('Successfully loaded buttons and status:', response); // The response is logged to the console (For debugging purposes)
                                $('#clocking-buttons').html(response.buttons); // The buttons are loaded into the #clocking-buttons element
                                $('#user-status').text(response.status); // The user status is loaded into the #user-status element
                            },

                            error: function(jqXHR, textStatus, errorThrown) { // If the request is unsuccessful, the error is logged to the console (For debugging purposes)
                                console.error('Error loading buttons and status:', textStatus, errorThrown); // Update this line
                            }

                        });
                    }

                    $(document).ready(function() { // When the document is ready, the loadButtonsAndStatus() function is called
                        loadButtonsAndStatus(); // The loadButtonsAndStatus() function is called

                        $(document).on('click', '.clocking-action', function() { // When a button with the class .clocking-action is clicked, the following function is called
                            console.log('Button clicked:', this); // The button is logged to the console (For debugging purposes)
                            const action = $(this).data('action'); // The action is stored in the action variable
                            // The AJAX request is sent to the clocking_action.php file
                            $.ajax({
                                url: 'clocking_action.php', // The clocking_action.php file is called 
                                method: 'POST', // The method is POST which is used to send data to the server
                                dataType: 'text', // The data type is text which is used to send data to the server
                                data: {
                                    userID: userID, // The user ID is passed to the server
                                    action: action // The action is passed to the server
                                },
                                success: function(response) { // If the request is successful, the response is returned
                                    console.log('Clocking action success:', response); // The response is logged to the console (For debugging purposes)
                                    loadButtonsAndStatus(); // The loadButtonsAndStatus() function is called
                                },
                                error: function(jqXHR, textStatus, errorThrown) { // If the request is unsuccessful, the error is logged to the console (For debugging purposes)
                                    console.error('Error performing clocking action:', textStatus, errorThrown); // Mainly for debugging purposes
                                }
                            });
                        });
                    });
                </script>

                <!-- content-wrapper ends -->
                <!-- partial:includes/_footer.php -->
                <?php include("../includes/_footer.php"); ?>
                <!-- partial -->

                <!-- plugins:js -->
                <script src="../vendors/js/vendor.bundle.base.js"></script>
                <!-- Plugin js for this page -->
                <script src="../vendors/chart.js/Chart.min.js"></script>
                <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
                <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
                <script src="../js/dataTables.select.min.js"></script>
                <!-- End plugin js for this page -->
                <script src="../js/off-canvas.js"></script>
                <script src="../js/hoverable-collapse.js"></script>
                <script src="../js/template.js"></script>
                <script src="../js/settings.js"></script>
                <script src="../js/todolist.js"></script>
                <!-- Custom js for this page-->
                <script src="../js/dashboard.js"></script>
                <script src="../js/Chart.roundedBarCharts.js"></script>
                <!-- End custom js for this page-->

                <script>
                    // Loader animation
                    var loader = document.querySelector(".loader")

                    window.addEventListener("load", vanish);

                    function vanish() {
                        loader.classList.add("disppear");
                    }
                </script>


            </div>
        </div>
    </div>
</body>

</html>