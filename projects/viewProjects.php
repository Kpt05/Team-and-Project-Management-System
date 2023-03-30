<!--
PHP intergration
-->
<?php
// Make a database connection
$conn = require '../includes/dbconfig.php';

// Define the SQL query to retrieve data from the Users Table
$sql = "SELECT * FROM Users";

// Execute the query and get the result set
$result = mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.ico" />


    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet" />

    <!-- Data Table JS
		============================================ -->
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css" />


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
                                    <h2 class="font-weight-bold">View projects</h2>
                                    <h6 class="font-weight-normal mb-0">
                                        All systems are running smoothly! You have
                                        <span class="text-primary">3 unread alerts!</span>
                                    </h6>
                                </div>
                                <div class="col-12 col-xl-4">
                                    <div class="justify-content-end d-flex">

                                        <!-- might wanna put something here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">


                                    <div class="table-responsive">
                                        <table id="data-table-basic" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Employee No.</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Email</th>
                                                    <th>Team</th>
                                                    <th>Gender</th>
                                                    <th>DOB</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>

                                                    <th>Report</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Loop through each row in the result set and output the data
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr onclick=\"highlightRow(this)\">";
                                                    echo "<td>" . $row['empNo'] . "</td>";
                                                    echo "<td>" . $row['firstName'] . " " . $row['lastName'] . "</td>";

                                                    echo "<td>" . $row['accountType'] . "</td>";
                                                    echo "<td>" . $row['email'] . "</td>";
                                                    echo "<td>" . $row['teams'] . "</td>";
                                                    echo "<td>" . $row['gender'] . "</td>";
                                                    echo "<td>" . $row['DOB'] . "</td>";
                                                    echo "<td>" . $row['phone'] . "</td>";
                                                    echo "<td>" . $row['address'] . "</td>";
                                                    echo "<td>" . $row['Report'] . "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>

                                    <script>
                                        function highlightRow(row) {
                                            if (row.classList.contains('selected')) {
                                                row.classList.remove('selected');
                                            } else {
                                                row.classList.add('selected');
                                            }
                                        }
                                    </script>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="../js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../js/dashboard.js"></script>
    <script src="../js/Chart.roundedBarCharts.js"></script>
    <!-- End custom js for this page-->


    <!-- Data Table area End-->

    <!-- End Footer area-->
    <!-- jquery
		============================================ -->
    <script src="../js/vendor/jquery-1.12.4.min.js"></script>

    <!-- plugins JS
		============================================ -->
    <script src="../js/plugins.js"></script>
    <!-- Data Table JS
		============================================ -->
    <script src="../js/data-table/jquery.dataTables.min.js"></script>
    <script src="../js/data-table/data-table-act.js"></script>
    <!-- main JS
		============================================ -->
    <script src="../js/main.js"></script>


    <script>
        var loader = document.querySelector(".loader")

        window.addEventListener("load", vanish);

        function vanish() {
            loader.classList.add("disppear");
        }
    </script>


</body>

</html>