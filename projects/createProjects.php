<!--Created by Kevin Titus on 2022-07-21.-->
<!-- PHP intergration -->
<?php

require_once('../includes/functions.inc.php'); // Include the functions.inc.php file
// Make a database connection
$conn = require '../includes/dbconfig.php'; // Include the dbconfig.php file which contains the database connection details

// Start a session
session_start();
$empNo = $_SESSION['empNo']; // Get the employee number from the session
$firstName = getFirstName($conn, $empNo); // Get the first name of the user
$lastName = getLastName($conn, $empNo); // Get the last name of the user
$accountType = getAccountType($conn, $empNo); // Get the account type of the user
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
    <title>Source Tech Portal</title> <!-- Title of the page -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
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
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
    <link rel="shortcut icon" href="../images/favicon.ico" />


    <script>
        // Loader script to make the loader disappear after 1.5 seconds
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

</head>

<!-- CSS -->
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

    .form-group select {
        font-size: 16px;
        color: #555;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-group select:focus {
        outline: none;
        border-color: #66afe9;
        box-shadow: 0 0 5px rgba(102, 175, 233, 0.5);
    }
</style>

<body>
    <!-- Loader -->
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
                                    <h3 class="font-weight-bold">Create a project</h3> <!-- Page title -->
                                </div>
                                <div class="row"></div>
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="container-fluid">
                                                <form action="../includes/signup.inc.php" method="POST"> <!-- Form to create a project, and all inputs get passed into the signup.php file -->
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <form>

                                                                <div class="form-group">
                                                                    <label for="projectName">
                                                                        Project name: <span style="color: red;">*</span>
                                                                    </label>
                                                                    <input type="text" class="form-control" id="projectName" name="projectName" required /> <!-- Project name input, also set to required -->
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="projectDescription">
                                                                        Project Description:
                                                                    </label>
                                                                    <div style="position: relative;">
                                                                        <textarea class="form-control" id="projectDescription" name="projectDescription" maxlength="150" oninput="updateCounter(this)" style="padding-right: 30px;"></textarea> <!-- Project description input, uses the updateCounter function to count the characters -->
                                                                        <span id="counter" style="position: absolute; bottom: 0; right: 10px; font-size: smaller;"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <label for="priorityLevel">Priority Level:</label>
                                                                            <select class="form-control" id="priorityLevel" name="priorityLevel">
                                                                                <option value="high">High</option>
                                                                                <option value="medium">Medium</option>
                                                                                <option value="low">Low</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label for="projectStatus">Project Status:</label>
                                                                            <select class="form-control" id="projectStatus" name="projectStatus">
                                                                                <option value="in-progress">In Progress</option>
                                                                                <option value="pending">Pending</option>
                                                                                <option value="completed">Completed</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label for="projectTeamID">Team ID: <span style="color: red;">*</span></label>
                                                                    <input type="text" class="form-control" id="projectTeamID" name="projectTeamID" placeholder="Search for a team ID" list="teamList1" required>

                                                                    <datalist id="teamList1">
                                                                        <?php
                                                                        // Query the teams table to get all teamIDs
                                                                        $sql = "SELECT teamID FROM Teams"; // SQL query to get all teamIDs
                                                                        $result = mysqli_query($conn, $sql); // Run the query

                                                                        // Loop through the query results and display them as options in the datalist
                                                                        while ($row = mysqli_fetch_assoc($result)) { // Loop through the query results
                                                                            echo "<option value='" . $row["teamID"] . "'>"; // Display the teamID as an option
                                                                        }
                                                                        ?>
                                                                    </datalist>

                                                                    <script>
                                                                        // Listen for changes on the datalist input
                                                                        document.getElementById("teamID").addEventListener("input", function() { // Listen for changes on the datalist input
                                                                            // Get the selected option and set the hidden input value to the corresponding data-value attribute
                                                                            var option = document.querySelector("#teamList1 option[value='" + this.value + "']"); // Get the selected option
                                                                            if (option) {
                                                                                document.getElementById("teamID").value = option.value;
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="projectLead">Project Lead: <span style="color: red;">*</span></label>
                                                                    <input type="text" class="form-control" id="projectLead" name="projectLead" placeholder="Search for a lead" list="projectLeadList" required>
                                                                    <input type="hidden" id="projectLeadID" name="projectLeadID" value="">

                                                                    <datalist id="projectLeadList">
                                                                        <?php
                                                                        // Query the users table to get all users with accountType "Manager"
                                                                        $sql = "SELECT UserID, CONCAT(firstName, ' ', lastName) AS fullName FROM Users WHERE accountType = 'Manager'"; // SQL query to get all users with accountType "Manager"
                                                                        $result = mysqli_query($conn, $sql);

                                                                        // Loop through the query results and display them as options in the datalist
                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo "<option value='" . $row["fullName"] . "' data-value='" . $row["UserID"] . "'>";
                                                                        }
                                                                        ?>
                                                                    </datalist>

                                                                    <script>
                                                                        // Listen for changes on the datalist input
                                                                        document.getElementById("projectLead").addEventListener("input", function() {
                                                                            // Get the selected option and set the value of the input field and hidden input to the corresponding data-value attribute
                                                                            var option = document.querySelector("#projectLeadList option[value='" + this.value + "']"); // Get the selected option
                                                                            if (option) {
                                                                                var userID = option.getAttribute("data-value"); // Get the data-value attribute
                                                                                document.getElementById("projectLeadID").value = userID; // Set the value of the hidden input
                                                                                this.value = option.value;
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>

                                                                <script>
                                                                    // Function to count the characters in the project description input
                                                                    function updateCounter(field) {
                                                                        var maxLength = 150;
                                                                        var currentLength = field.value.length;
                                                                        var counter = document.getElementById("counter");
                                                                        counter.textContent = currentLength + "/" + maxLength;
                                                                    }
                                                                </script>

                                                                <!-- Error messagea -->
                                                                <?php
                                                                if (isset($_GET['error']) && $_GET['error'] === "emptyinput") {
                                                                    $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                    echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";
                                                                }

                                                                //Project Name already exists
                                                                else if (isset($_GET['error']) && $_GET['error'] === "projectnamealreadyexists") {
                                                                    $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                    echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";

                                                                    //Team ID already exists
                                                                } else if (isset($_GET['error']) && $_GET['error'] === "projectidalreadyexists") {
                                                                    $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                    echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";
                                                                }
                                                                ?>
                                                                <!-- End of error message -->

                                                                <button type="submit" name="createProject" class="form-control btn     btn-primary rounded submit px-3"> <!-- Submit button -->
                                                                    <b>Create Project</b>
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
                    // Loader animation script
                    var loader = document.querySelector(".loader")

                    window.addEventListener("load", vanish);

                    function vanish() {
                        loader.classList.add("disppear");
                    }
                </script>

</body>
</html>