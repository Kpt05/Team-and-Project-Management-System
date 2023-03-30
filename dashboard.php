<!--
PHP intergration
-->
<?php
require_once('includes/functions.inc.php');
$conn = require 'includes/dbconfig.php';

session_start();
$empNo = $_SESSION['empNo'];
$firstName = getFirstName($conn, $empNo);
$lastName = getLastName($conn, $empNo);
$accountType = getAccountType($conn, $empNo);

?>

<!--Created by Kevin Titus on 2022-07-19.-->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>My Dashboard | Source Tech Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/feather/feather.css" />
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.ico" />
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
        <img src="images/loader.gif" alt="" />
    </div>

    <div class="container-scroller">

        <!-- partial:includes/_navbar.php -->
        <?php include "includes/_navbar.php"; ?>


        <div class="container-fluid page-body-wrapper">

            <!-- partial:includes/_settings-panel.html -->
            <?php include "includes/_settings-panel.php"; ?>

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
                                    <h2 class="font-weight-bold">Dashboard</h2>

                                    <h4 class="font-weight-bold mb-0">
                                        Welcome, <?php echo $firstName ?>
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
                                                    <i class="icon-cloud mr-2"></i><span id="temp"></span><sup>C</sup>
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

                        <script>
                            const apiKey = "6abe60b89e524acc551948f8a204b452";
                            const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=Yeovil,uk&units=metric&appid=${apiKey}`;

                            fetch(apiUrl)
                                .then(response => response.json())
                                .then(data => {
                                    const tempElement = document.getElementById("temp");
                                    tempElement.textContent = Math.round(data.main.temp);
                                })
                                .catch(error => console.log(error));
                        </script>


                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card position-relative">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-6 d-flex flex-column justify-content-start">
                                            <div class="ml-xl-4 mt-3">
                                                <p class="card-title">Detailed Reports</p>
                                                <h1 class="text-primary">$34040</h1>
                                                <h3 class="font-weight-500 mb-xl-4 text-primary">
                                                    North America
                                                </h3>
                                                <p class="mb-2 mb-xl-0">
                                                    The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="row">

                        <div class="row">
                            <div class="col-md-5 grid-margin stretch-card">

                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-title mb-0">Top Products</p>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Search Engine Marketing</td>
                                                        <td class="font-weight-bold">$362</td>
                                                        <td>21 Sep 2018</td>
                                                        <td class="font-weight-medium">
                                                            <div class="badge badge-success">Completed</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Search Engine Optimization</td>
                                                        <td class="font-weight-bold">$116</td>
                                                        <td>13 Jun 2018</td>
                                                        <td class="font-weight-medium">
                                                            <div class="badge badge-success">Completed</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Display Advertising</td>
                                                        <td class="font-weight-bold">$551</td>
                                                        <td>28 Sep 2018</td>
                                                        <td class="font-weight-medium">
                                                            <div class="badge badge-warning">Pending</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pay Per Click Advertising</td>
                                                        <td class="font-weight-bold">$523</td>
                                                        <td>30 Jun 2018</td>
                                                        <td class="font-weight-medium">
                                                            <div class="badge badge-warning">Pending</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>E-Mail Marketing</td>
                                                        <td class="font-weight-bold">$781</td>
                                                        <td>01 Nov 2018</td>
                                                        <td class="font-weight-medium">
                                                            <div class="badge badge-danger">Cancelled</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Referral Marketing</td>
                                                        <td class="font-weight-bold">$283</td>
                                                        <td>20 Mar 2018</td>
                                                        <td class="font-weight-medium">
                                                            <div class="badge badge-warning">Pending</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Social media marketing</td>
                                                        <td class="font-weight-bold">$897</td>
                                                        <td>26 Oct 2018</td>
                                                        <td class="font-weight-medium">
                                                            <div class="badge badge-success">Completed</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="col-md-5 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">To Do Lists</h4>
                                        <div class="list-wrapper pt-2">
                                            <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                                                <li>
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" />
                                                            Meeting with Urban Team
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                                <li class="completed">
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" checked />
                                                            Duplicate a project for new customer
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" />
                                                            Project meeting with CEO
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                                <li class="completed">
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" checked />
                                                            Follow up of team zilla
                                                        </label>
                                                    </div>
                                                    <i class="remove ti-close"></i>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-flat">
                                                        <label class="form-check-label">
                                                            <input class="checkbox" type="checkbox" />
                                                            Level up for Antony
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


                    <!-- content-wrapper ends -->

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

        <script>
            var loader = document.querySelector(".loader")

            window.addEventListener("load", vanish);

            function vanish() {
                loader.classList.add("disppear");
            }
        </script>




</body>

</html>