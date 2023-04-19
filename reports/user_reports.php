<!-- PHP intergration -->
<?php
// Start session
session_start();
// Including functions.inc.php to use functions and dbconfig.php to connect to the database
require_once('../includes/functions.inc.php'); // All the necessary functions are in this file
$conn = require '../includes/dbconfig.php'; // Database connection, returns $conn


require_once '../includes/authentication.inc.php'; // Include the authentication.php file
$empNo = $_SESSION['empNo']; // Get the employee number from the session
$firstName = getFirstName($conn, $empNo); // Get the first name of the user
$lastName = getLastName($conn, $empNo); // Get the last name of the user
$accountType = getAccountType($conn, $empNo); // Get the account type of the user

// Authenticate the user
$isAuthenticated = authenticate($conn);

if (!$isAuthenticated) {
    // If not authenticated, redirect to the login page
    header("Location: ../index.php?error=notloggedin");
    exit();
}

// Fetch data from the Reports table
$sql = "SELECT r.tasksCompleted, r.tasksAssigned, r.hoursWorked, r.userID, u.firstName, u.lastName, u.teams
FROM Reports r
JOIN Users u ON r.tasksCompleted = u.UserID";
$result = mysqli_query($conn, $sql); // Execute the query

// Initialize arrays to store team data
$teamPerformance = array(); // 3D Array to store performance data
$teamNames = array(); // 3D Array to store names of team members
$hoursWorkedData = array(); // New array to store hours worked data
$tasksCompletedData = array(); // New array to store tasks completed data

// Loop through the result set
while ($row = mysqli_fetch_assoc($result)) { // Fetch a result row as an associative array
    $tasksCompleted = $row['tasksCompleted']; // Get the tasks completed
    $tasksAssigned = $row['tasksAssigned']; // Get the tasks assigned
    $hoursWorked = $row['hoursWorked']; // Get the hours worked
    $userID = $row['userID']; // Get the user ID
    $firstName = $row['firstName']; // Get the first name
    $lastName = $row['lastName']; // Get the last name
    $teamID = $row['teams']; // Get the team ID 

    // Calculate performance metrics
    $completionRate = ($tasksCompleted / $tasksAssigned) * 100; // Calculate completion rate
    $productivityIndex = ($tasksCompleted / $hoursWorked); // Calculate productivity index
    $efficiencyRatio = ($tasksAssigned / $hoursWorked); // Calculate efficiency ratio

    // Calculate overall performance score
    $performanceScore = ($completionRate + $productivityIndex + $efficiencyRatio) / 3; 

    // Store performance data in arrays
    $teamPerformance[$teamID][$userID] = $performanceScore; // The teamPerformance array holds the team ID as the key and an array of user IDs and performance scores as the value
    $teamNames[$teamID][$userID] = $firstName . ' ' . $lastName; // The teamNames array holds the team ID as the key and an array of user IDs and names as the value
    $hoursWorkedData[$teamID][$userID] = $hoursWorked; // Store hours worked data in the hoursWorkedData array
    $tasksCompletedData[$teamID][$userID] = $tasksCompleted; // Store tasks completed data in the tasksCompletedData array
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>User Reports | Source Tech Portal</title> <!-- Title of the page -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" /> <!-- Feather icon -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icon -->
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" /> <!-- Base CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css"> <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" /> <!-- Style CSS -->
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.ico" /> <!-- Favicon -->
</head>

<style>
    /* Loader CSS */
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


    /* Chart CSS */
    .carousel-item {
        height: 300px;
    }
</style>

<body>
    <div class="container-scroller">

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
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card position-relative">
                                    <div class="card-body">
                                        <div id="detailedReports" class="position-static pt-2">
                                            <div class="row">
                                                <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                    <div class="ml-xl-4 mt-3">
                                                        <p class="card-title">Tasks Completed</p> <!-- Chart Title -->
                                                        <h1 class="text-primary">Beta Team</h1> <!-- Name of the team -->
                                                        <p class="mb-2 mb-xl-0"> <!-- Chart description -->
                                                            The total number of tasks completed by the team.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xl-9">
                                                    <div class="row">
                                                        <div class="col-md-12 border-right">
                                                            <div class="table-responsive mb-3 mb-md-0 mt-4">
                                                                <table class="table table-borderless report-table">
                                                                    <!-- Loop through team members -->
                                                                    <!-- Get team members from Users table with teamID = ENGV0H5 -->
                                                                    <!-- Get tasksCompleted from Reports table using UserIDs -->
                                                                    <!-- Concatenate firstName and lastName to display full name -->
                                                                    <!-- Display number of tasks completed -->
                                                                    <?php
                                                                    $teamID = 'ENGV0H5'; // Team ID
                                                                    $teamMembers = getUsersByTeamID($conn, $teamID); // Function to get team members from Users table
                                                                    foreach ($teamMembers as $teamMember) { // Loop through team members and store data in variables
                                                                        $firstName = $teamMember['firstName']; // First name
                                                                        $lastName = $teamMember['lastName']; // Last name
                                                                        $tasksCompleted = $teamMember['tasksCompleted']; // Tasks completed
                                                                    ?>
                                                                        <tr>
                                                                            <td class="text-muted"><?php echo $firstName . ' ' . $lastName; ?></td> <!-- Display full name -->
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $tasksCompleted; ?>%" aria-valuenow="<?php echo $tasksCompleted; ?>" aria-valuemin="0" aria-valuemax="100"></div> <!-- Progress bar -->
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0"><?php echo $tasksCompleted; ?></h5> <!-- Display number of tasks completed -->
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12 grid-margin stretch-card"> <!-- Chart -->
                                <div class="card position-relative">
                                    <div class="card-body">
                                        <div class="row">
                                            <canvas id="performanceChart" height="400"></canvas> <!-- Set the desired height of the chart -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Create arrays to store chart data
                                var teamNames = <?php echo json_encode($teamNames); ?>; // Array to store team names
                                var data = <?php echo json_encode($teamPerformance); ?>; // Array to store team performance data

                                // Create an array to store labels and datasets
                                var labels = []; // Array to store labels
                                var datasets = []; // Array to store datasets

                                // Loop through team data and format it for chart
                                for (var teamID in data) { // Loop through team IDs
                                    var teamData = data[teamID]; // Get team data
                                    var performanceScores = []; // Array to store performance scores for this team
                                    var userNames = []; // Array to store user names for this team
                                    for (var userID in teamData) { // Loop through user IDs
                                        var performanceScore = teamData[userID]; // Get performance score for this user
                                        performanceScores.push(performanceScore); // Add performance score for this team
                                        userNames.push(teamNames[teamID][userID]); // Add user name for this team
                                    }
                                    datasets.push({ // Add dataset for this team
                                        label: 'Team ID ' + teamID, // Update with desired label
                                        data: performanceScores, // Update with desired data
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Update with desired chart color
                                        borderColor: 'rgba(75, 192, 192, 1)', // Update with desired chart color
                                        borderWidth: 1, // Update with desired chart color
                                        barThickness: 30, // Update with desired chart color
                                    });
                                    // Add team ID as label
                                    labels.push('Team ID ' + teamID); // Update with desired label
                                }

                                // Create the chart using Chart.js
                                var ctx = document.getElementById('performanceChart').getContext('2d'); // Get the canvas element
                                var chart = new Chart(ctx, { // Create the chart
                                    type: 'bar', // Update with desired chart type
                                    data: {
                                        labels: labels, // Update with desired labels
                                        datasets: datasets // Update with desired datasets
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                max: 100,
                                                title: {
                                                    display: true,
                                                    text: 'Performance Score (%)'
                                                }
                                            },
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Teams'
                                                }
                                            }
                                        },
                                        responsive: true, // Update with desired responsiveness
                                        maintainAspectRatio: false, // Update with desired responsiveness
                                        tooltips: {
                                            mode: 'index', // Update with desired tooltip mode
                                            intersect: false,
                                            callbacks: {
                                                label: function(context) {
                                                    var datasetLabel = context.dataset.label || '';
                                                    var index = context.dataIndex;
                                                    var label = context.chart.data.labels[index];
                                                    var value = context.formattedValue;
                                                    var userIndex = teamNames[label.split(' ')[2]][userNames[index]]; // Find the index of the user within the team
                                                    return datasetLabel + ': ' + teamNames[label.split(' ')[2]][userIndex] + ' - ' + value + '%'; // Update tooltip label to include user name
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>


                            <div class="col-md-7 grid-margin stretch-card">
                                <div class="card position-relative">
                                    <div class="card-body">
                                        <h4 class="card-title"> Team Productivity Index</h4> <!-- Chart title -->
                                        <p class="card-description">Formula = (Tasks Completed / Hours Worked)</p> <!-- Chart description -->
                                        <div id="teamPerformanceCarousel" class="carousel slide" data-ride="carousel"> <!-- Carousel -->
                                            <!-- Indicators -->
                                            <ol class="carousel-indicators">
                                                <!-- Generate carousel indicators based on number of teams -->
                                                <?php
                                                $indicatorCount = 0; // Counter to keep track of indicator count 
                                                foreach ($teamPerformance as $teamID => $users) { // Loop through teams
                                                    echo '<li data-target="#teamPerformanceCarousel" data-slide-to="' . $indicatorCount . '"'; // Update with desired carousel ID
                                                    if ($indicatorCount == 0) { // Set first indicator as active
                                                        echo ' class="active"'; // Update with desired carousel ID
                                                    }
                                                    echo '></li>'; // Update with desired carousel ID
                                                    $indicatorCount++; // Increment indicator count
                                                }
                                                ?>
                                            </ol>

                                            <!-- Slides -->
                                            <div class="carousel-inner">
                                                <!-- Generate carousel slides based on number of teams -->
                                                <?php
                                                $slideCount = 0; // Counter to keep track of slide count
                                                foreach ($teamPerformance as $teamID => $users) { // Loop through teams
                                                    echo '<div class="carousel-item'; // Update with desired carousel ID
                                                    if ($slideCount == 0) { // Set first slide as active
                                                        echo ' active'; // Update with desired carousel ID
                                                    }
                                                    echo '">';
                                                    echo '<canvas id="teamPerformanceChart_' . $teamID . '"></canvas>'; // Update with desired chart ID
                                                    echo '</div>'; // Update with desired carousel ID
                                                    $slideCount++; // Increment slide count
                                                }
                                                ?>
                                            </div>

                                            <!-- Controls -->
                                            <a class="carousel-control-prev" href="#teamPerformanceCarousel" role="button" data-slide="prev"> <!-- Update with desired carousel ID -->
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span> <!-- Update with desired carousel ID -->
                                                <span class="sr-only">Previous</span> <!-- Update with desired carousel ID -->
                                            </a>
                                            <a class="carousel-control-next" href="#teamPerformanceCarousel" role="button" data-slide="next"> <!-- Update with desired carousel ID -->
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span> <!-- Update with desired carousel ID -->
                                                <span class="sr-only">Next</span> <!-- Update with desired carousel ID -->
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script> <!-- Chart.js -->
                            <script>
                                var teamData = <?php echo json_encode($teamPerformance); ?>; // Get team performance data from PHP
                                var teamNames = <?php echo json_encode($teamNames); ?>; // Get team names from PHP 

                                // Loop through teamData to generate charts for each team
                                for (var teamID in teamData) { // Loop through teams
                                    var ctx = document.getElementById('teamPerformanceChart_' + teamID).getContext('2d'); // Get the canvas element
                                    var users = teamData[teamID]; // Get the users for the current team
                                    var labels = []; // Array to store user names
                                    var productivityIndexes = []; // Array to store productivity indexes

                                    // Extract user data for the current team
                                    for (var userID in users) { // Loop through users
                                        labels.push(teamNames[teamID][userID]); // Add user name to labels array
                                        productivityIndexes.push(users[userID]); // Add productivity index to productivityIndexes array 
                                    }

                                    // Create a bar chart for team performance
                                    new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: labels, // Update with desired labels
                                            datasets: [{
                                                label: 'Productivity Index', // Update with desired label
                                                data: productivityIndexes,
                                                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: { // Update with desired options
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    max: 100,
                                                    title: {
                                                        display: true,
                                                        text: 'Productivity Index (%)' // Update with desired title
                                                    }
                                                },
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: 'Team Members'
                                                    }
                                                }
                                            },
                                            plugins: {
                                                legend: {
                                                    display: false
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Team Performance - ' + teamNames[teamID]['teamName']
                                                }
                                            }
                                        }
                                    });
                                }
                            </script>

                            <div class="col-md-5 grid-margin stretch-card"> <!-- Update with desired column size -->
                                <div class="card position-relative">
                                    <div class="card-body">
                                        <h4 class="card-title">Team Hours and tasks completed</h4> <!-- Chart title -->
                                        <p class="card-description">List of full system users</p> <!-- Chart description -->
                                        <div id="teamPerformanceCarousel" class="carousel slide" data-ride="carousel"> <!-- Carousel that will hold the charts -->
                                            <!-- Indicators -->
                                            <ol class="carousel-indicators">
                                                <!-- Generate carousel indicators based on number of teams -->
                                                <?php
                                                $indicatorCount = 0; // Counter to keep track of indicator count and slide count
                                                foreach ($teamPerformance as $teamID => $users) { // Loop through teams 
                                                    echo '<li data-target="#teamPerformanceCarousel" data-slide-to="' . $indicatorCount . '"'; // Update with desired carousel ID
                                                    if ($indicatorCount == 0) { // Set first indicator as active
                                                        echo ' class="active"'; // Update with desired carousel ID using the same class name
                                                    }
                                                    echo '></li>';
                                                    $indicatorCount++; // Increment indicator count and slide count
                                                }
                                                ?>
                                            </ol>

                                            <!-- Slides -->
                                            <div class="carousel-inner">
                                                <!-- Generate carousel slides based on number of teams -->
                                                <?php
                                                $slideCount = 0; // Counter to keep track of slide count and is set to 0
                                                foreach ($teamPerformance as $teamID => $users) { // Loop through teams
                                                    echo '<div class="carousel-item'; // Update with desired carousel ID
                                                    if ($slideCount == 0) { // Set first slide as active
                                                        echo ' active'; // Update with desired carousel ID
                                                    }
                                                    echo '">';
                                                    echo '<table class="table">'; // Update with desired table class
                                                    echo '<thead>'; // Update with desired table class
                                                    echo '<tr>'; // Update with desired table class
                                                    echo '<th>Name</th>'; // Update with desired table class
                                                    echo '<th>Hours Worked</th>'; // Update with desired table class
                                                    echo '<th>Tasks Completed</th>'; // Update with desired table class
                                                    echo '<th>Productivity Index</th>'; // Add a new column for Productivity Index
                                                    echo '</tr>'; // Update with desired table class
                                                    echo '</thead>';// Update with desired table class
                                                    echo '<tbody>'; // Update with desired table class

                                                    foreach ($users as $userID => $userData) {
                                                        echo '<tr>';
                                                        echo '<td>' . $teamNames[$teamID][$userID] . '</td>';
                                                        echo '<td>' . $hoursWorkedData[$teamID][$userID] . '</td>'; // Display hours worked from the new array
                                                        echo '<td>' . $tasksCompletedData[$teamID][$userID] . '</td>'; // Display tasks completed from the new array
                                                        echo '<td>' . round($userData / $hoursWorkedData[$teamID][$userID], 2) . '</td>'; // Calculate and display Productivity Index
                                                        echo '</tr>';
                                                    }
                                                    echo '</tbody>'; // Update with desired table class
                                                    echo '</table>'; // Update with desired table class
                                                    echo '</div>'; // Update with desired carousel ID
                                                    $slideCount++;
                                                }
                                                ?>
                                            </div>

                                            <!-- Controls -->
                                            <a class="carousel-control-prev" href="#teamPerformanceCarousel" role="button" data-slide="prev"> <!-- Update with desired carousel ID -->
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span> <!-- Update with desired carousel ID -->
                                                <span class="sr-only">Previous</span> <!-- Update with desired carousel ID -->
                                            </a>
                                            <a class="carousel-control-next" href="#teamPerformanceCarousel" role="button" data-slide="next"> <!-- Update with desired carousel ID to match the carousel ID in the previous control -->
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span> <!-- Update with desired carousel ID to match the carousel ID in the previous control -->
                                                <span class="sr-only">Next</span> <!-- Update with desired carousel ID to match the carousel ID in the previous control -->
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- content-wrapper ends -->

                        <!-- partial:includes/_footer.php -->
                        <?php include("../includes/_footer.php"); ?> <!-- Update with desired footer file -->
                        <!-- partial -->

                    </div>
                    <!-- main-panel ends -->
                </div>
                <!-- page-body-wrapper ends -->
            </div>
            <!-- container-scroller -->
            <!-- plugins:js -->
            <script src="../vendors/js/vendor.bundle.base.js"></script>
            <!-- Plugin js for this page -->
            <script src="../vendors/chart.js/Chart.min.js"></script>
            <!-- End plugin js for this page -->
            <script src="../js/off-canvas.js"></script>
            <script src="../js/hoverable-collapse.js"></script>
            <script src="../js/template.js"></script>
            <script src="../js/settings.js"></script>
            <script src="../js/todolist.js"></script>
            <!-- Custom js for this page-->
            <script src="../js/chart.js"></script>
            <!-- End custom js for this page-->
            
            <script>
                // Loader script
                var loader = document.querySelector(".loader")

                window.addEventListener("load", vanish);

                function vanish() {
                    loader.classList.add("disppear");
                }
            </script>
</body>
</html>