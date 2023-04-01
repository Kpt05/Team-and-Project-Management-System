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
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">Create a Team</h3>
                                </div>
                                <div class="row"></div>
                                <div class="col-lg-8 grid-margin stretch-card mx-auto">
                                    <div class="card">
                                        <div class="card-body">


                                            <div class="container-fluid">

                                                <form action="../includes/signup.inc.php" method="POST">
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <form>
                                                                <div class="form-group">
                                                                    <label for="teamName">
                                                                        Team Name: <span style="color: red;">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control" id="teamName" name="teamName" required />
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="teamType">Department <span style="color: red;">*</span></label>
                                                                    <select class="select2" style="width: 100%; height: 38px;" id="department" name="department" required>
                                                                        <option value="" disabled selected hidden>Please select</option>
                                                                        <option value="SLS">Sales</option>
                                                                        <option value="MKT">Marketing</option>
                                                                        <option value="FNC">Finance</option>
                                                                        <option value="ENG">Engineering</option>
                                                                        <option value="HR">Human Resources</option>
                                                                        <option value="OP">Operations</option>
                                                                        <option value="RD">Research and Development</option>
                                                                        <option value="CUST">Customer Service</option>
                                                                        <option value="PM">Product Management</option>
                                                                        <option value="DES">Design</option>
                                                                        <option value="IT">Information Technology</option>
                                                                        <option value="BUS">Business Development</option>
                                                                        <option value="PUB">Public Relations</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="teamDescription">
                                                                        Team Description:
                                                                    </label>
                                                                    <div style="position: relative;">
                                                                        <textarea class="form-control" id="teamDescription" name="teamDescription" maxlength="150" oninput="updateCounter(this)" style="padding-right: 30px;"></textarea>
                                                                        <span id="counter" style="position: absolute; bottom: 0; right: 10px; font-size: smaller;"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="teamLead">
                                                                        Team Manager/Lead: <span style="color: red;">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control" id="teamLead" name="teamLead" placeholder="Search for a lead" list="teamList" required />
                                                                    <input type="hidden" id="teamLeadID" name="teamLeadID">

                                                                    <datalist id="teamList">
                                                                        <?php
                                                                        // Query the users table to get all users with accountType "Manager"
                                                                        $sql = "SELECT UserID, CONCAT(firstName, ' ', lastName) AS fullName FROM Users WHERE accountType = 'Manager'";
                                                                        $result = mysqli_query($conn, $sql);

                                                                        // Loop through the query results and display them as options in the datalist
                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo "<option value='" . $row["fullName"] . "' data-value='" . $row["UserID"] . "'>";
                                                                        }

                                                                        // Close the database connection
                                                                        mysqli_close($conn);
                                                                        ?>
                                                                    </datalist>

                                                                    <script>
                                                                        // Listen for changes on the datalist input
                                                                        document.getElementById("teamLead").addEventListener("input", function() {
                                                                            // Get the selected option and set the hidden input value to the corresponding data-value attribute
                                                                            var option = document.querySelector("#teamList option[value='" + this.value + "']");
                                                                            if (option) {
                                                                                document.getElementById("teamLeadID").value = option.getAttribute("data-value");
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>




                                                                <script>
                                                                    function updateCounter(field) {
                                                                        var maxLength = 150;
                                                                        var currentLength = field.value.length;
                                                                        var counter = document.getElementById("counter");
                                                                        counter.textContent = currentLength + "/" + maxLength;
                                                                    }
                                                                </script>

                                                                <!-- Error message -->
                                                                <?php
                                                                //Empty input
                                                                if (isset($_GET['error']) && $_GET['error'] === "emptyinput") {
                                                                    $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                    echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";
                                                                }

                                                                //Team Name already exists
                                                                else if (isset($_GET['error']) && $_GET['error'] === "teamnamealreadyexists") {
                                                                    $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                    echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";

                                                                    //Team ID already exists
                                                                } else if (isset($_GET['error']) && $_GET['error'] === "teamidalreadyexists") {
                                                                    $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                    echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";
                                                                }
                                                                ?>
                                                                <!-- End of error message -->

                                                                <button type="submit" name="createTeam" class="form-control btn     btn-primary rounded submit px-3">
                                                                    <b>Add user</b>
                                                                </button>

                                                        </div>
                                                    </div>
                                                </form>
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
                </div>

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

                <script>
                    $(function() {
                        var sixteenYearsAgo = new Date();
                        var hundredYearsAgo = new Date();
                        sixteenYearsAgo.setFullYear(sixteenYearsAgo.getFullYear() - 16);
                        hundredYearsAgo.setFullYear(hundredYearsAgo.getFullYear() - 65);

                        var maxDate = sixteenYearsAgo.toISOString().split('T')[0];
                        var minDate = hundredYearsAgo.toISOString().split('T')[0];

                        $('#DOB').attr('max', maxDate);
                        $('#DOB').attr('min', minDate);
                        $('#DOB').val(maxDate);
                    });
                </script>

            </div>
        </div>
    </div>


</body>



</html>