<!--Created by Kevin Titus on 2022-07-19.-->
<!-- PHP intergration -->
<?php
// This will start the session and get the employee number, first name, last name, and account type. This is used to display the name of the user on the navbar and to determine which sidebar to display
// Ultimately, this decide which navbar and sidebar to display basec on the account type
session_start();

require_once('includes/functions.inc.php'); // Including functions.inc.php to use functions and dbconfig.php to connect to the database
$conn = require 'includes/dbconfig.php';

require_once 'includes/authentication.inc.php'; // Include the authentication.php file
$empNo = $_SESSION['empNo'];
$firstName = getFirstName($conn, $empNo);
$lastName = getLastName($conn, $empNo);
$accountType = getAccountType($conn, $empNo);

// Authenticate the user
$isAuthenticated = authenticate($conn);

if (!$isAuthenticated) {
    // If not authenticated, redirect to the login page
    header("Location: ../index.php?error=notloggedin");
    exit();
}


// This will count the number of adminsitraive users in the database, this is used to retireve the number of admins, managers, and employees for the pie chart which shows the breakdown of users
$sql = "SELECT COUNT(*) as count FROM Users WHERE accountType='Administrator'"; // SQL query to count number of admins
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$admin_count = $row['count'];

// Count number of managers in the database whcih is used to display the number of managers in the pie chart
$sql = "SELECT COUNT(*) as count FROM Users WHERE accountType='Manager'"; // Query to count number of managers
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$manager_count = $row['count'];

// Count number of employees in the database which is used to display the number of employees in the pie chart
$sql = "SELECT COUNT(*) as count FROM Users WHERE accountType='Employee'"; // Query to count number of employees
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$employee_count = $row['count'];

// Total number of users in the database which is used to display the total number of users in the pie chart
$total_users = $admin_count + $manager_count + $employee_count; // Total number of users
// THOU THE VARIABLES ABOVE DO NOT DIRECTLY DISPLAY THE NUMBER OF USERS, THEY ARE USED TO CALCULATE THE PERCENTAGE OF USERS IN EACH CATEGORY FOR THE PIE CHART
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Query the database to retrieve data for the chart which shows the efficiency rate of each user, this is used to display the efficiency rate of each user in the bar chart
$sql = "SELECT r.userID, u.firstName, u.lastName, r.tasksCompleted, r.tasksAssigned, r.hoursWorked FROM Reports r
        INNER JOIN Users u ON r.userID = u.userID"; // Join with Users table to get full names
$result = $conn->query($sql);

// Create a 3D array to store the chart data which will be used to display the efficiency rate of each user in the bar chart on the dashboard
$chartData = array(); // 3D array to store the chart data
while ($row = $result->fetch_assoc()) { // Loop through each row in the result set
    $efficiencyRate = ($row["tasksCompleted"] / $row["hoursWorked"]) * 100; // Calculate efficiency rate
    $fullName = $row["firstName"] . " " . $row["lastName"]; // Concatenate first name and last name
    $chartData[] = array(
        "userID" => $fullName, // Use full name as label on x-axis
        "efficiencyRate" => $efficiencyRate // Use efficiency rate as value on y-axis
    );
}

// Bubble sort to sort the chart data in ascending order based on efficiency rate
// This is used to display the users in the bar chart in ascending order based on efficiency rate
for ($i = 0; $i < count($chartData) - 1; $i++) {
    for ($j = 0; $j < count($chartData) - $i - 1; $j++) {
        if ($chartData[$j]["efficiencyRate"] > $chartData[$j + 1]["efficiencyRate"]) {
            $temp = $chartData[$j];
            $chartData[$j] = $chartData[$j + 1];
            $chartData[$j + 1] = $temp;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> <!-- This is used to make the page responsive by scaling the page to the width of the device -->
    <title>My Dashboard | Source Tech Portal</title> <!-- Page title -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/feather/feather.css" /> <!-- Feather icons whcih are used in the sidebar -->
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icons which are used in the sidebar -->
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css" /> <!-- Base CSS for the page -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css"> <!-- Bootstrap icons which are used in the sidebar -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js which is used to display the pie chart and bar chart -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css" /> <!-- CSS for the data tables which are used to display the users in the table -->
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icons which are used in the sidebar -->
    <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css" /> <!-- CSS for the data tables which are used to display the users in the table -->
    <!-- End plugin css for this page -->

    <link rel="stylesheet" href="css/vertical-layout-light/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<!-- Loader Styling -->
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
    <!-- Loader -->
    <div class="loader">
        <img src="images/loader.gif" alt="" />
    </div>

    <div class="container-scroller">

        <!-- partial:includes/_navbar.php -->
        <?php include "includes/_navbar.php"; ?> <!-- This will use the navbar partial and include it on the dasboard.php page -->

        <div class="container-fluid page-body-wrapper">


            <!-- partial - Account Type Based Navbar -->
            <!-- This will use the sidebar partial based on the account type in the session variable of the user and include it on the dasboard.php page -->
            <?php
            if ($accountType == 'Employee') {
                include 'includes/_employeesidebar.php';
            } elseif ($accountType == 'Manager') {
                include 'includes/_managersidebar.php';
            } elseif ($accountType == 'Administrator') {
                include 'includes/_adminsidebar.php';
            }
            ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold">Dashboard</h2> <!-- Page title -->

                                    <h4 class="font-weight-bold mb-0">
                                        Welcome, <?php echo $firstName ?> <!-- Welcome message -->
                                    </h4>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card tale-bg">
                                <div class="card-people mt-auto">
                                    <img src="images/dashboard/people.svg" alt="people" />
                                    <div class="weather-info">
                                        <div class="d-flex">
                                            <div>
                                                <h2 class="mb-0 font-weight-normal">
                                                    <i class="icon-cloud mr-2"></i><span id="temp"></span><sup>C</sup> <!-- Uses the openweathermap API to display the current temperature in Yeovil -->
                                                </h2>
                                            </div>
                                            <div class="ml-2">
                                                <h4 class="location font-weight-normal">Source Tech HQ</h4>
                                                <h6 class="font-weight-normal">Yeovil - United Kingdom</h6> <!-- Displays the location of the Source Tech HQ (Where the system will be used primarily) -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- OpenWeatherMap API -->
                        <script>
                            const apiKey = "6abe60b89e524acc551948f8a204b452"; // API Key which is used to access the data from the API (This technically shouldn't be here but it's a free API so it's fine)
                            const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=Yeovil,uk&units=metric&appid=${apiKey}`; // API URL which is used to access the data from the API

                            fetch(apiUrl) // Fetches the data from the API URL using the API Key to access the data for the system
                                .then(response => response.json()) // Converts the response to JSON which can be used by the system to display the data
                                .then(data => { 
                                    const tempElement = document.getElementById("temp"); 
                                    tempElement.textContent = Math.round(data.main.temp); // Displays the current temperature in Yeovil, this is becuase the HQ of Source Tech is in Yeovil and the system is intended to be used there
                                })
                                .catch(error => console.log(error)); // Displays any errors in the console through the browser using error trapping
                        </script>

                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card position-relative">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="myPieChart"></canvas>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- Displays the number of active user accounts -->
                                            <div class="chart-legend">
                                                <h4 style="font-size: 24px; margin-bottom: 30px;">Active User Accounts</h4> <!-- Displays the number of active user accounts -->
                                                <?php
                                                // As declared at the top of the page, this will display the number of active user accounts and the percentage of each account type from the database and display it on the dashboard
                                                $user_types = array(
                                                    'Admins' => $admin_count, // Uses the variables declared at the top of the page to display the number of active user accounts
                                                    'Managers' => $manager_count, // Uses the variables declared at the top of the page to display the number of active user accounts
                                                    'Employees' => $employee_count // Uses the variables declared at the top of the page to display the number of active user accounts
                                                );

                                                // Calculate the total number of users
                                                $total_users = array_sum($user_types); // Uses the array_sum function to add all the values in the array together to get the total number of users
                                                foreach ($user_types as $user_type => $count) {
                                                    $percent = round($count / $total_users * 100, 2);
                                                    echo "<p style='font-size: 20px; margin-bottom: 35px;'>{$user_type}: {$count} ({$percent}%)</p>";
                                                }
                                                ?>
                                                <p style="font-size: 20px; margin-bottom: 0;">Total Users: <?php echo $total_users; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart.js implementation -->
                        <script>
                            var ctx = document.getElementById('myPieChart').getContext('2d');
                            var myPieChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: <?php echo json_encode(array_keys($user_types)); ?>,
                                    datasets: [{
                                        data: <?php echo json_encode(array_values($user_types)); ?>,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.7)',
                                            'rgba(54, 162, 235, 0.7)',
                                            'rgba(255, 206, 86, 0.7)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    legend: {
                                        position: 'right',
                                        align: 'end',
                                        labels: {
                                            fontColor: 'black'
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>

                    <div class="row">

                        <div class="row">
                            <!-- Chart to display the efficiency rate of each user -->
                            <!-- Add the canvas element to render the chart -->
                            <div class="col-md-9 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Efficiency Rate Chart</h4> <!-- Added chart title -->
                                        <canvas id="efficiencyChart"></canvas>
                                        <p class="chart-description">Efficiency Rate = (Completed Tasks / Total Tasks) * 100</p> <!-- Added chart description with formula -->
                                    </div>
                                </div>
                            </div>

                            <!-- To do list -->
                            <div class="col-md-3 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">To Do Lists</h4> <!-- Added to do list title -->
                                        <div class="list-wrapper pt-2">
                                            <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                                                <!-- This is the to do list, it will display the tasks that need to be completed -->
                                                <!-- However, this is only client side and does not store the data in the database, so it will not be saved when the page is refreshed -->
                                                <li>
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" />
                                                            Meeting with Tech Team
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                                <li class="completed">
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" checked />
                                                            Add new employees to the team
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" />
                                                            Project meeting with client
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                                <li class="completed">
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" checked />
                                                            Follow up of team projects
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" />
                                                            Project meeting with boss
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="add-items d-flex mb-0 mt-2">
                                            <input type="text" class="form-control todo-list-input" placeholder="Add new task" />
                                            <button class="add btn btn-icon text-primary todo-list-add-btn bg-transparent">
                                                <i class="icon-circle-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- JavaScript code to create the chart -->
                        <script>
                            var chartData = <?php echo json_encode($chartData); ?>; // Pass the PHP array to JavaScript

                            // Prepare the data for the chart
                            var chartLabels = chartData.map(function(item) {
                                return item.userID;
                            });
                            var chartEfficiencyRate = chartData.map(function(item) {
                                return item.efficiencyRate;
                            });

                            // Create the chart
                            var ctx = document.getElementById("efficiencyChart").getContext("2d");
                            var chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: chartLabels,
                                    datasets: [{
                                        label: 'Efficiency Rate',
                                        data: chartEfficiencyRate,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Set the background color for the bars
                                        borderColor: 'rgba(75, 192, 192, 1)', // Set the border color for the bars
                                        borderWidth: 1 // Set the border width for the bars
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 100 // Set the maximum value for the y-axis to 100
                                        }
                                    }
                                }
                            });
                        </script>

                    </div>

                    <!-- partial:includes/_footer.php -->
                    <?php include("includes/_footer.php"); ?>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

        <!-- plugins:js -->
        <script src="vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="vendors/chart.js/Chart.min.js"></script>
        <script src="vendors/datatables.net/jquery.dataTables.js"></script>
        <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
        <script src="js/dataTables.select.min.js"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/hoverable-collapse.js"></script>
        <script src="js/template.js"></script>
        <script src="js/settings.js"></script>
        <script src="js/todolist.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="js/dashboard.js"></script>
        <script src="js/Chart.roundedBarCharts.js"></script>
        <!-- End custom js for this page-->

        <!-- loader script -->
        <script>
            var loader = document.querySelector(".loader") // Get the loader element

            window.addEventListener("load", vanish);

            function vanish() {
                loader.classList.add("disppear");
            }
        </script>
    </div>

</body>

</html>