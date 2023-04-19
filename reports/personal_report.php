<!-- PHP intergration -->
<?php
// Start session
session_start();
// Including functions.inc.php to use functions and dbconfig.php to connect to the database
require_once('../includes/functions.inc.php');
$conn = require '../includes/dbconfig.php';


require_once '../includes/authentication.inc.php'; // Include the authentication.php file
$empNo = $_SESSION['empNo'];
$firstName = getFirstName($conn, $empNo);
$lastName = getLastName($conn, $empNo);
$accountType = getAccountType($conn, $empNo);
$userID = getUserID($conn, $empNo); // Get user ID
$reportsData = getReportsData($conn, $userID); // Get data from Reports table

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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Personal Reports | Source Tech Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.ico" />
</head>

<style>
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
</style>

<body>
    <div class="loader">
        <img src="../images/loader.gif" alt="" />
    </div>

    <div class="container-scroller">

        <!-- partial:includes/_navbar.php -->
        <?php include "../includes/_navbar.php"; ?>


        <div class="container-fluid page-body-wrapper">

            <!-- partial:includes/_adminsidebar.php -->
            <?php include '../includes/_adminsidebar.php'; ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold">View Personal Reports</h2> <!-- Page title -->

                                    <h4 class="font-weight-bold mb-0">
                                        Welcome, <?php echo $firstName ?> <!-- Welcome message -->
                                    </h4>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Tasks Completed</h4>
                                    <canvas id="tasksCompletedChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Hours Worked</h4>
                                    <canvas id="hoursWorkedChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Completion Rate</h4>
                                    <canvas id="completionRateChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Average Tasks Completed per Hour Worked</h4>
                                    <canvas id="tasksPerHourChart"></canvas>
                                </div>
                            </div>
                        </div>


                        <!-- Plugin js for this page -->
                        <script src="../vendors/chart.js/Chart.min.js"></script>
                        <script>
                            // Convert PHP data to JavaScript
                            const reportsData = <?php echo json_encode($reportsData); ?>;

                            // Get canvas elements
                            const tasksCompletedChart = document.getElementById('tasksCompletedChart').getContext('2d');
                            const hoursWorkedChart = document.getElementById('hoursWorkedChart').getContext('2d');

                            // Generate charts using Chart.js
                            new Chart(tasksCompletedChart, {
                                type: 'bar',
                                data: {
                                    labels: reportsData.map(report => report.reportID),
                                    datasets: [{
                                        label: 'Tasks Completed',
                                        data: reportsData.map(report => report.tasksCompleted),
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });

                            new Chart(hoursWorkedChart, {
                                type: 'line',
                                data: {
                                    labels: reportsData.map(report => report.reportID),
                                    datasets: [{
                                        label: 'Hours Worked',
                                        data: reportsData.map(report => report.hoursWorked),
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 2,
                                        fill: false
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                            // Get the new canvas elements
                            const completionRateChart = document.getElementById('completionRateChart').getContext('2d');
                            const tasksPerHourChart = document.getElementById('tasksPerHourChart').getContext('2d');

                            // Calculate completion rates and average tasks per hour worked
                            const completionRates = reportsData.map(report => report.tasksCompleted / report.tasksAssigned * 100);
                            const tasksPerHour = reportsData.map(report => report.tasksCompleted / report.hoursWorked);

                            // Generate the completion rate chart
                            new Chart(completionRateChart, {
                                type: 'line',
                                data: {
                                    labels: reportsData.map(report => report.reportID),
                                    datasets: [{
                                        label: 'Completion Rate (%)',
                                        data: completionRates,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 2,
                                        fill: false
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 100
                                        }
                                    }
                                }
                            });

                            // Generate the average tasks completed per hour worked chart
                            new Chart(tasksPerHourChart, {
                                type: 'bar',
                                data: {
                                    labels: reportsData.map(report => report.reportID),
                                    datasets: [{
                                        label: 'Tasks per Hour',
                                        data: tasksPerHour,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                        <!-- End plugin js for this page -->






                    </div>

                </div>
                <!-- content-wrapper ends -->

                <!-- partial:includes/_footer.php -->
                <?php include("../includes/_footer.php"); ?>
                <!-- partial -->

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../js/chart.js"></script>
    <!-- End custom js for this page-->
    <script>
        var loader = document.querySelector(".loader")

        window.addEventListener("load", vanish);

        function vanish() {
            loader.classList.add("disppear");
        }
    </script>
</body>

</html>