<!--
PHP intergration
-->
<?php
require_once('../includes/functions.inc.php');
// Make a database connection
$conn = require '../includes/dbconfig.php';

session_start();
$empNo = $_SESSION['empNo'];
$firstName = getFirstName($conn, $empNo);
$user_id = getUserId($conn, $empNo);
$lastName = getLastName($conn, $empNo);
$accountType = getAccountType($conn, $empNo);



?>

<!--Created by Kevin Titus on 2022-07-21.-->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Source Tech Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css" />

    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/select2/">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">


    <link href="~bulma-calendar/dist/css/bulma-calendar.min.css" rel="stylesheet">
    <script src="~bulma-calendar/dist/js/bulma-calendar.min.js"></script>

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.ico" />


    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvUiP0DYjb3XiFw9toptx7gBtokfnyfFM&libraries=places"></script>


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

            <!-- partial:includes/_settings-panel.html -->
            <?php include "../includes/_settings-panel.php"; ?>

            <!-- partial:includes/_adminsidebar.php -->
            <?php include '../includes/_adminsidebar.php'; ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                  







                <div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h2 class="font-weight-bold">Clockings</h2>
            </div>
            <div class="col-12 col-xl-4 text-right font-weight-bold" style="font-size: 23px; margin-top: 20px; margin-right: -50px; text-align: right;">
                <div class="text-center">
                    <?php
                    $date = date('l, j M');
                    $time = date('H:i');
                    echo "<div>$date</div>";
                    echo "<div>$time</div>";

                    // get user status
                    $status = getUserStatus($conn, $userID);
                    ?>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-xl-8 text-center font-weight-bold">
                <div style="font-size: 40px; font-weight: bold;"><?php echo $status; ?></div>
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

                <script>
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