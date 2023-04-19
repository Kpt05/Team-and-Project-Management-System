<!--Created by Kevin Titus on 2022-07-21.-->
<!-- PHP intergration -->
<?php
// Start the session
session_start();
require_once('../includes/functions.inc.php'); // Include the functions file
$conn = require '../includes/dbconfig.php'; // Include the database connection file and return the connection object

require_once '../includes/authentication.inc.php'; // Include the authentication.php file
$empNo = $_SESSION['empNo']; // Get the employee number from the session
$firstName = getFirstName($conn, $empNo); // Get the first name from the database
$lastName = getLastName($conn, $empNo); // Get the last name from the database
$accountType = getAccountType($conn, $empNo); // Get the account type from the database

// Authenticate the user
$isAuthenticated = authenticate($conn);

if (!$isAuthenticated) {
    // If not authenticated, redirect to the login page
    header("Location: ../index.php?error=notloggedin");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> <!-- Bootstrap CSS -->
    <title>Source Tech Portal</title> <!-- Title of the page -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" /> <!-- Feather icon -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icon -->
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" /> <!-- Base CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" /> <!-- Data table CSS -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css" /> <!-- Data table CSS -->

    <!-- End plugin css for this page -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" /> <!-- CSS -->
    <link rel="shortcut icon" href="../images/favicon.ico" /> <!-- Favicon -->

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

            <!-- partial - Account Type Based Navbar -->
            <!-- This will use the sidebar partial based on the account type in the session variable of the user and include it on the dasboard.php page -->
            <?php
            if ($accountType == 'Employee') {
                include '../includes/_employeesidebar.php';
            } elseif ($accountType == 'Manager') {
                include '../includes/_managersidebar.php';
            } elseif ($accountType == 'Administrator') {
                include '../includes/_adminsidebar.php';
            }
            ?>
            
            <!-- partial -->
            <div class="main-panel">

                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-md-12 grid-margin">

                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold">Personal Roster</h2> <!-- Page title -->
                                    <?php
                                    // Display the current month and year
                                    echo "<h4>" . date('F Y') . "</h4>";
                                    ?>
                                </div>
                                <div class="row"></div>
                                <div class="col-lg-12 grid-margin stretch-card">
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
                                                    // Attendance codes array
                                                    $attendanceCodes = ['H', 'B', 'am', 'pm', 'F', 'PM', 'AA', 'OOO', 'T', 'NR']; // Replace with your actual attendance codes

                                                    // Fetch userID from Users table based on empNo
                                                    $empNo = $_SESSION['empNo'];

                                                    $sql = "SELECT UserID FROM Users WHERE empNo = " . $empNo; // replace 'Users' with your actual table name
                                                    $result = mysqli_query($conn, $sql); // replace $conn with your actual database connection variable
                                                    $row = mysqli_fetch_assoc($result); // replace $result with your actual query result variable
                                                    $userID = $row['userID']; // replace 'userID' with your actual userID column name

                                                    // Fetch roster data from the database based on userID
                                                    $sql = "SELECT * FROM Roster WHERE userID = " . $userID; // replace 'Roster' with your actual table name
                                                    $result = mysqli_query($conn, $sql); // replace $conn with your actual database connection variable
                                                    $rosterData = mysqli_fetch_all($result, MYSQLI_ASSOC); // replace $result with your actual query result variable

                                                    // Create a date range for the calendar
                                                    $startDate = new DateTime('first day of this month'); // Replace 'first day of this month' with 'first day of last month' to display the previous month
                                                    $endDate = new DateTime('last day of this month'); // Replace 'last day of this month' with 'last day of next month' to display the next month

                                                    // Loop through each day in the date range
                                                    while ($startDate <= $endDate) { // Replace '<=' with '<' to display the next month
                                                        echo "<tr>";
                                                        for ($i = 0; $i < 7; $i++) { // Replace '7' with '6' to display the next month
                                                            echo "<td class='roster-calendar-day'>"; // Add a class to each day cell
                                                            $currentDate = $startDate->format('Y-m-d'); // Format the date to match the database date format

                                                            if ($startDate->format('m') == date('m')) { // Replace 'm' with 'n' to display the next month
                                                                // Display the day number
                                                                echo "<div class='roster-calendar-day-number' style='position: relative; top: -30px; left: -17px;'>" . $startDate->format('j') . "</div>";

                                                                // Check if the current date has a roster entry
                                                                $rosterEntry = array_filter($rosterData, function ($entry) use ($currentDate) { // Replace $rosterData with your actual roster data array
                                                                    return $entry['shiftDate'] == $currentDate; // Replace 'shiftDate' with your actual shiftDate column name
                                                                });
                                                                // Add dropdown menu with attendance codes
                                                                echo "<select class='form-control attendance-code-dropdown' data-date='{$currentDate}'>"; // Add a data attribute to each dropdown menu
                                                                foreach ($attendanceCodes as $code) { // Replace $attendanceCodes with your actual attendance codes array
                                                                    $selected = !empty($rosterEntry) && $rosterEntry[0]['attendanceCode'] == $code ? 'selected' : ''; // Replace 'attendanceCode' with your actual attendanceCode column name
                                                                    echo "<option value='{$code}' {$selected}>{$code}</option>"; // Replace $code with your actual attendance code
                                                                }
                                                                echo "</select>";
                                                            }

                                                            echo "</td>";
                                                            if ($startDate->format('m') == date('m')) { // Replace 'm' with 'n' to display the next month
                                                                $startDate->add(new DateInterval('P1D')); // Replace 'P1D' with 'P1M' to display the next month
                                                            } else {
                                                                break;
                                                            }
                                                        }
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                            <input type="hidden" id="empNo" value="<?php echo $_SESSION['empNo']; ?>"> <!-- Hidden input to pass empNo to the update_roster.php file -->
                                            <button id="saveButton" class="btn btn-primary">Save Roster</button> <!-- Save button -->

                                            <script>
                                                // Save button click event listener
                                                document.getElementById('saveButton').addEventListener('click', function() { // Replace 'saveButton' with your actual save button ID
                                                    console.log('Save button clicked'); // Just to help debug in the console

                                                    const dropdowns = document.getElementsByClassName('attendance-code-dropdown'); // Replace 'attendance-code-dropdown' with your actual dropdown class name
                                                    const data = []; // Array to store the data to be sent to the server

                                                    // Loop through each dropdown menu
                                                    for (let i = 0; i < dropdowns.length; i++) { 
                                                        const dropdown = dropdowns[i];
                                                        const date = dropdown.dataset.date;
                                                        const attendanceCode = dropdown.value;

                                                        data.push({
                                                            date: date,
                                                            attendanceCode: attendanceCode
                                                        });
                                                    }

                                                    console.log('Data to be sent:', data); // debuging statement

                                                    const empNo = document.getElementById('empNo').value; // Replace 'empNo' with your actual empNo input ID
                                                    console.log('empNo to be sent:', empNo); // debuging statement

                                                    // Send the data to the server
                                                    fetch('update_roster.php', { 
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json'
                                                            },
                                                            body: JSON.stringify({
                                                                empNo: empNo,
                                                                data: data
                                                            })
                                                        })
                                                        
                                                    // Handle the response from the server
                                                        .then(response => {
                                                            console.log('Response:', response);
                                                            if (!response.ok) {
                                                                return response.text().then(errorText => {
                                                                    console.error('Error text:', errorText);
                                                                    throw new Error('Server error');
                                                                });
                                                            }
                                                            return response.text().then(text => {
                                                                console.log('Response text:', text);
                                                                return JSON.parse(text);
                                                            });
                                                        })
                                                        // Handle the result from the server
                                                        .then(result => {
                                                            console.log('Result:', result);
                                                            if (result.success) {
                                                                alert('Roster saved successfully!');
                                                            } else {
                                                                // Check if the error message is available
                                                                if (result.message) {
                                                                    alert(result.message);
                                                                } else {
                                                                    alert('Error saving roster. Please try again.');
                                                                }
                                                            }
                                                        })
                                                        .catch(error => { // Handle any errors
                                                            console.error('Error:', error); // Log the error to the console
                                                        });
                                                });
                                            </script>
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

                <!-- container-scroller -->

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
                    // Loader script for page
                    var loader = document.querySelector(".loader")

                    window.addEventListener("load", vanish);

                    function vanish() {
                        loader.classList.add("disppear");
                    }
                </script>

</body>
</html>