<!--Created by Kevin Titus on 2022-07-21.-->
<!-- PHP intergration -->
<?php
require_once('../includes/functions.inc.php'); // Include the functions file
$conn = require '../includes/dbconfig.php'; // Include the database connection file and get the connection object

// Start the session
session_start();
$empNo = $_SESSION['empNo']; // Get the empNo from the session
$firstName = getFirstName($conn, $empNo); // Get the first name from the database
$lastName = getLastName($conn, $empNo); // Get the last name from the database
$accountType = getAccountType($conn, $empNo); // Get the account type from the database
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Source Tech Portal</title> <!-- Title of the page -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" /> <!-- Feather icon -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icon -->
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" /> <!-- Base CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css"> <!-- Bootstrap icons -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" /> <!-- Data table -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css" /> <!-- Data table -->

    <link rel="stylesheet" href="css/select2/select2.min.css"> <!-- Select2 CSS -->
    <link rel="stylesheet" href="css/select2/"> <!-- Select2 CSS -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> <!-- Select2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> <!-- Select2 JS -->

    <!-- End plugin css for this page -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" /> <!-- CSS -->
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.ico" /> <!-- Favicon -->


    <script>
        // When the page is loaded, hide the loader
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

</head>

<style>
    /* Loader Styling */
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

    /* Roster Calendar legend Styling */
    .small-legend {
        font-size: 12px;
        padding: 5px;
    }

    .small-legend th,
    .small-legend td {
        padding: 3px;
    }


    /* Roster Calendar Styling (Dropdowns and Day numbers) */
    .roster-calendar-day {
        position: relative;
    }

    .roster-calendar-day-number {
        position: absolute;
        top: 5px;
        left: 5px;
        font-weight: bold;
    }

    .attendance-code-dropdown {
        width: 50%;
        margin: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
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

                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold">Team Roster</h2> <!-- Page title -->
                                    <?php
                                    // Display the current month and year
                                    echo "<h4>" . date('F Y') . "</h4>"; 
                                    ?>
                                </div>
                                <div class="row"></div>
                                <div class="col-lg-12 grid-margin stretch-card"> <!-- Table card -->
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Team Roster calendar table -->
                                            <table class="table table-bordered roster-calendar" style="height: 500px;"> <!-- Table Size -->
                                                <thead>
                                                    <tr>
                                                        <!-- Roster Calendar Headers (Each day of the week) -->
                                                        <th class="roster-calendar-day">Sun</th>
                                                        <th class="roster-calendar-day">Mon</th>
                                                        <th class="roster-calendar-day">Tue</th>
                                                        <th class="roster-calendar-day">Wed</th>
                                                        <th class="roster-calendar-day">Thu</th>
                                                        <th class="roster-calendar-day">Fri</th>
                                                        <th class="roster-calendar-day">Sat</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Query the Roster table to get the user data
                                                    $sql = "SELECT userName, attendanceCode, shiftDate FROM Roster"; // SQL query
                                                    $result = mysqli_query($conn, $sql); // Execute the query

                                                    $userData = []; // Array to store the user data

                                                    if (mysqli_num_rows($result) > 0) {
                                                        // Loop through the query results and add them to the $userData array
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $userData[] = $row;
                                                        }
                                                    }

                                                    mysqli_close($conn); // Close the database connection

                                                    $startDate = new DateTime('first day of this month'); // Get the first day of the current month
                                                    $endDate = new DateTime('last day of this month'); // Get the last day of the current month

                                                    while ($startDate <= $endDate) { // Loop through the days of the current month
                                                        echo "<tr>";
                                                        for ($i = 0; $i < 7; $i++) { // Loop through the days of the week
                                                            echo "<td class='roster-calendar-day' style='height: 70px; width: 100px;'>"; // Set the height and width of the table cells
                                                            $currentDate = $startDate->format('Y-m-d'); // Get the current date

                                                            if ($startDate->format('m') == date('m')) { // Check if the current date is in the current month
                                                                echo "<div class='roster-calendar-day-number' style='position: relative; top: -30px; left: -17px;'>" . $startDate->format('j') . "</div>"; // Display the day number

                                                                // Create a container with a fixed height and overflow set to auto
                                                                echo "<div class='roster-entry-container' style='max-height: 40px; overflow-y: auto;'>";

                                                                // Loop through the user data and display matching entries for the current date
                                                                foreach ($userData as $entry) { // Loop through the user data
                                                                    if ($entry['shiftDate'] == $currentDate) { // Check if the current date matches the shift date
                                                                        // Add a fixed width and word-break to the roster-entry div
                                                                        echo "<div class='roster-entry' style='width: 90px; word-break: break-all;'>{$entry['userName']} - {$entry['attendanceCode']}</div>";
                                                                    }
                                                                }

                                                                echo "</div>"; // Close the roster-entry-container div
                                                            }

                                                            echo "</td>"; // Close the table cell
                                                            if ($startDate->format('m') == date('m')) { // Check if the current date is in the current month
                                                                $startDate->add(new DateInterval('P1D')); // Add one day to the current date
                                                            } else {
                                                                break; // Break out of the loop
                                                            }
                                                        }
                                                        echo "</tr>"; // Close the table row
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Codes Legend -->
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Attendance Codes Legend</h4> <!-- Attendance Codes Legend Title -->
                                            <table class="table table-bordered small-legend">
                                                <thead>
                                                    <!-- Attendance Codes Legend Table Header -->
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>H</td>
                                                        <td>Holiday - Annual Leave</td>
                                                    </tr>
                                                    <tr>
                                                        <td>B</td>
                                                        <td>Bank Holiday - Or other statutory holiday</td>
                                                    </tr>
                                                    <tr>
                                                        <td>am</td>
                                                        <td>½ Day AM Out - Will be back in after lunch</td>
                                                    </tr>
                                                    <tr>
                                                        <td>pm</td>
                                                        <td>½ Day PM Out - Will be out after lunch</td>
                                                    </tr>
                                                    <tr>
                                                        <td>F</td>
                                                        <td>Flex Day - Take a day off on flexy time</td>
                                                    </tr>
                                                    <tr>
                                                        <td>PM</td>
                                                        <td>Flex PM - Take Afternoon off on flexy</td>
                                                    </tr>
                                                    <tr>
                                                        <td>AM</td>
                                                        <td>Flex AM - Take Morning off on flexy</td>
                                                    </tr>
                                                    <tr>
                                                        <td>OOO</td>
                                                        <td>Out Of Office - For any given valid reason</td>
                                                    </tr>
                                                    <tr>
                                                        <td>T</td>
                                                        <td>Training - Take a training day</td>
                                                    </tr>
                                                    <tr>
                                                        <td>NR</td>
                                                        <td>Not required to work - For some valid reason</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- content-wrapper ends -->
                            <!-- partial:includes/_footer.php -->
                            <?php include("../includes/_footer.php"); ?> <!-- Footer -->
                            <!-- partial -->
                        </div>
                    </div>
                </div>

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
                // Loader Script
                    var loader = document.querySelector(".loader")

                    window.addEventListener("load", vanish);

                    function vanish() {
                        loader.classList.add("disppear");
                    }
                </script>

</body>
</html>