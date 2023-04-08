<!--Created by Kevin Titus on 2022-07-19.-->
<!-- PHP intergration -->
<?php
// Including functions.inc.php to use functions and dbconfig.php to connect to the database
require_once('includes/functions.inc.php');
$conn = require 'includes/dbconfig.php';

// Start session
session_start();
$empNo = $_SESSION['empNo'];
$firstName = getFirstName($conn, $empNo);
$lastName = getLastName($conn, $empNo);
$accountType = getAccountType($conn, $empNo);

// Count number of admins
$sql = "SELECT COUNT(*) as count FROM Users WHERE accountType='Administrator'"; // SQL query to count number of admins
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$admin_count = $row['count'];

// Count number of managers
$sql = "SELECT COUNT(*) as count FROM Users WHERE accountType='Manager'"; // Query to count number of managers
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$manager_count = $row['count'];

// Count number of employees
$sql = "SELECT COUNT(*) as count FROM Users WHERE accountType='Employee'"; // Query to count number of employees
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$employee_count = $row['count'];

$total_users = $admin_count + $manager_count + $employee_count; // Total number of users

// Query to retrieve data from Reports table, including tasksCompleted, hoursWorked, and userID
$sql = "SELECT tasksCompleted, hoursWorked, userID FROM Reports";
$result = $conn->query($sql);

// Create a 3D array to store the data for the chart
$data = array();
while ($row = $result->fetch_assoc()) {
    $efficiencyRate = ($row['tasksCompleted'] / $row['hoursWorked']) * 100; // Calculate efficiency rate
    $userSql = "SELECT CONCAT(firstName, ' ', lastName) AS fullName FROM Users WHERE userID = " . $row['userID']; // Query to retrieve full name of user
    $userResult = $conn->query($userSql); 
    $userRow = $userResult->fetch_assoc();
    $fullName = $userRow['fullName'];
    $data[] = array($fullName, $efficiencyRate); // Add data to array
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>My Dashboard | Source Tech Portal</title> <!-- Page title -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/feather/feather.css" />
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css" />
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
                                                <h6 class="font-weight-normal">Yeovil - United Kingdom</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- OpenWeatherMap API -->
                        <script>
                            const apiKey = "6abe60b89e524acc551948f8a204b452"; // API Key
                            const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=Yeovil,uk&units=metric&appid=${apiKey}`;

                            fetch(apiUrl)
                                .then(response => response.json())
                                .then(data => {
                                    const tempElement = document.getElementById("temp");
                                    tempElement.textContent = Math.round(data.main.temp); // Displays the current temperature in Yeovil
                                })
                                .catch(error => console.log(error));
                        </script>

                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card position-relative">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="myPieChart"></canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="chart-legend">
                                                <h4 style="font-size: 24px; margin-bottom: 30px;">Active User Accounts</h4> <!-- Displays the number of active user accounts -->
                                                <?php
                                                $user_types = array(
                                                    'Admins' => $admin_count,
                                                    'Managers' => $manager_count,
                                                    'Employees' => $employee_count
                                                );

                                                // Calculate the total number of users
                                                $total_users = array_sum($user_types);
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

                        <!-- Chart to display the efficiency rate of each user -->
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Efficiency Rate by User</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">Efficiency Rate = (Number of Tasks Completed / Total Hours Worked) * 100</h6>
                                    <canvas id="efficiencyChart"></canvas>
                                </div>
                            </div>
                        </div>


                        <!-- Script to create the chart using Charts.js -->
                        <script>
                            // Get the data from the PHP array
                            var data = <?php echo json_encode($data); ?>;

                            // Function to perform bubble sort on the data array by efficiency rate in ascending order
                            function bubbleSort(arr) {
                                var len = arr.length;
                                for (var i = 0; i < len - 1; i++) {
                                    for (var j = 0; j < len - i - 1; j++) {
                                        if (arr[j][1] > arr[j + 1][1]) {
                                            var temp = arr[j];
                                            arr[j] = arr[j + 1];
                                            arr[j + 1] = temp;
                                        }
                                    }
                                }
                                return arr;
                            }

                            // Sort the data array by efficiency rate in ascending order using bubble sort
                            data = bubbleSort(data);

                            // Extract the full names and efficiency rates from the sorted data array
                            var labels = data.map(function(item) {
                                return item[0];
                            });
                            var efficiencyRates = data.map(function(item) {
                                return item[1];
                            });

                            // Create a chart using Charts.js
                            var ctx = document.getElementById('efficiencyChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Efficiency Rate',
                                        data: efficiencyRates,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Set the color for the bars
                                        borderColor: 'rgba(75, 192, 192, 1)', // Set the border color for the bars
                                        borderWidth: 1 // Set the border width for the bars
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: {
                                            beginAtZero: true,
                                            max: 100 // Set the maximum value for the x-axis to 100
                                        },
                                        y: {
                                            beginAtZero: true,
                                            max: 100 // Set the maximum value for the y-axis to 100
                                        }
                                    }
                                }
                            });
                        </script>

                        <!-- To do list -->
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">To Do Lists</h4>
                                        <div class="list-wrapper pt-2">
                                            <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
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
            var loader = document.querySelector(".loader")

            window.addEventListener("load", vanish);

            function vanish() {
                loader.classList.add("disppear");
            }
        </script>

</body>
</html>