<!--Created by Kevin Titus on 2022-07-19.-->
<!-- PHP intergration -->
<?php
require_once('../includes/functions.inc.php'); // Include the functions file
// Make a database connection
$conn = require '../includes/dbconfig.php';

// Start the session
session_start();
$empNo = $_SESSION['empNo']; // Get the employee number of the logged in user
$firstName = getFirstName($conn, $empNo); // Get the first name of the logged in user
$lastName = getLastName($conn, $empNo); // Get the last name of the logged in user
$accountType = getAccountType($conn, $empNo); // Get the account type of the logged in user
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>User Performance | Source Tech Portal</title> <!-- Title of the page -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-vn+VrRGJkbPZdVgbNVl0GDM98/r50LZxJxh7qPy9XrHr7FzRgNlV0kjfOZowWV7fqbGmzTcTmF9bPYfbtBvM+w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-BiMDI4PnLMT6U5SjjU5vQF5I6Rh3qBpfW8VDvL0swroCmzBtvHfZC8SKv6EGIzoIDc1NEiKbJKYqXlNmc5i6UQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
                        <div class="col-md-8">
                            <h2 class="font-weight-bold">User Performance</h2> <!-- Page title -->
                            <h6 class="font-weight-normal mb-0">
                            </h6>
                        </div>
                    </div>

                    <!-- The Main card container in which the form inputs are placed in -->
                    <div class="row mt-4">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container-fluid">

                                        <form method="post" action="../includes/signup.inc.php"> <!-- Form action, all form inputs are submitted to the signup.inc.php file -->
                                            <div class="form-group">
                                                <label for="userID"> <!-- User ID label -->
                                                    Name: <span style="color: red;">*</span>
                                                </label>
                                                <select class="form-control" id="userID" name="userID" required> <!-- User ID dropdown list -->
                                                    <?php
                                                    // Query the users table to get all users with accountType "Employee" or "Manager"
                                                    $sql = "SELECT UserID, CONCAT(firstName, ' ', lastName, ' - ', empNo) AS fullName, empNo FROM Users WHERE accountType IN ('Employee', 'Manager')"; // Query to get all users with accountType "Employee" or "Manager"
                                                    $result = mysqli_query($conn, $sql); // Run the query

                                                    // Fetch query results and store them in an array
                                                    $users = array(); // Array to store users
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $users[] = $row; // Add user to the users array
                                                    }

                                                    // Loop through the users array and display them as options in the dropdown list
                                                    foreach ($users as $user) { // Loop through the users array
                                                        $selected = "";
                                                        if (isset($_POST["userID"]) && $_POST["userID"] == $user["UserID"]) { // If the user ID is set and matches the current user ID, set the selected variable to "selected"
                                                            $selected = "selected";
                                                        }
                                                        echo "<option value='" . $user["UserID"] . "' " . $selected . ">" . $user["fullName"] . "</option>"; // Display the user as an option in the dropdown list
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="tasksCompleted">Tasks Completed:</label> <!-- Tasks completed label -->
                                                <input type="text" class="form-control" id="tasksCompleted" name="tasksCompleted" required inputmode="numeric" pattern="[0-9]*">
                                            </div>

                                            <div class="form-group">
                                                <label for="hoursWorked">Hours Worked:</label> <!-- Hours worked label -->
                                                <input type="number" class="form-control" id="hoursWorked" name="hoursWorked" required>
                                            </div>

                                            <button type="submit" name="userPerformance" class="btn btn-primary">Submit</button> <!-- Submit button -->
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial:includes/_footer.php -->
        <?php include("../includes/_footer.php"); ?>
        <!-- partial -->
    </div>
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
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
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
        // Loader script
        var loader = document.querySelector(".loader")

        window.addEventListener("load", vanish);

        function vanish() {
            loader.classList.add("disppear");
        }
    </script>

</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>