<!--Created by Kevin Titus on 2022-07-21.-->
<!-- PHP intergration -->
<?php
// Start session
session_start();
require_once('../includes/functions.inc.php'); // Including functions.inc.php to use functions
// Make a database connection
$conn = require '../includes/dbconfig.php'; // dbconfig.php to connect to the database


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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Source Tech Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" /> <!-- Feather icons -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icons -->
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" /> <!-- Vendor css -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" /> <!-- Data tables -->
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" /> <!-- Themify icons -->
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css" /> <!-- Data tables -->

    <link rel="stylesheet" href="css/select2/select2.min.css"> <!-- Select2 -->
    <link rel="stylesheet" href="css/select2/"> <!-- Select2 Styling-->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css"> <!-- Bootstrap icons -->

    <link href="~bulma-calendar/dist/css/bulma-calendar.min.css" rel="stylesheet"> <!-- Bulma Calendar -->
    <script src="~bulma-calendar/dist/js/bulma-calendar.min.js"></script> <!-- Bulma Calendar -->

    <!-- End plugin css for this page -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.ico" /> <!-- Favicon -->


    <script>
        // Script to make the loader disappear
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvUiP0DYjb3XiFw9toptx7gBtokfnyfFM&libraries=places"></script> <!-- Uses Google Maps API to get the address and use autocomplete suggestions -->

</head>

<style>
    /* Loader styling */
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
        <?php include "../includes/_navbar.php"; ?> <!-- Navbar -->

        <div class="container-fluid page-body-wrapper">

           <!-- partial - Account Type Based Navbar -->
            <!-- This will use the sidebar partial based on the account type in the session variable of the user and include it on the dasboard.php page -->
            <?php
            if ($accountType == 'Employee') {
                include '../includes/_employeesidebar.php';
            } elseif ($accountType == 'Manager') {
                include '../includes/_managersidebar.php';
            } elseif ($accountType == 'Administrator') {
                include '../includes/_adminsidebar.php';
            }
            ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">Create system user</h3> <!-- Page title -->
                                </div>
                                <div class="row"></div>
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Personal Details</h4> <!-- Card title -->
                                            <div class="container-fluid">

                                                <form action="../includes/signup.inc.php" method="POST"> <!-- When the form is submitted, form data will go to the signup.inc.php file -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6" style="border-right: 1px solid rgba(103, 103, 103, 0.25); margin-bottom:10px;">

                                                                    <div class="form-group">
                                                                        <label for="firstName">
                                                                            First Name <span style="color: red;">*</span> <!-- Required field -->
                                                                        </label>
                                                                        <input type="text" class="form-control" id="firstName" name="firstName" required /> <!-- First name input -->
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="middleName">
                                                                            Middle Name
                                                                        </label>
                                                                        <input type="text" class="form-control" id="middleName" name="middleName" /> <!-- Middle name input -->
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="lastName">
                                                                            Last Name <span style="color: red;">*</span>
                                                                        </label>
                                                                        <input type="text" class="form-control" id="lastName" name="lastName" required /> <!-- Last name input -->
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="gender">
                                                                                    Gender <span style="color: red;">*</span> <!-- Required field -->
                                                                                </label>
                                                                                <select class="select2" style="width: 100%; height: 38px;" id="gender" name="gender" required> <!-- Dropdown list to select the user's gender -->
                                                                                    <option value="" disabled selected hidden>Please select</option>
                                                                                    <option value="male">Male</option>
                                                                                    <option value="female">Female</option>
                                                                                    <option value="other">Other</option>
                                                                                    <option value="not-say">Prefer not to say</option>
                                                                                </select>
                                                                            </div>

                                                                            <style>
                                                                                /* Dropdown styling */
                                                                                .select2 {
                                                                                    padding: 8px;
                                                                                    font-size: 14px;
                                                                                    border: 1px solid #ccc;
                                                                                    border-radius: 5px;
                                                                                    appearance: none;
                                                                                    -webkit-appearance: none;
                                                                                    -moz-appearance: none;
                                                                                }
                                                                            </style>
                                                                        </div>


                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="DOB">
                                                                                    Date of birth <span style="color: red;">*</span>
                                                                                </label>
                                                                                <input type="date" class="form-control" id="DOB" name="DOB" required /> <!-- Date of birth input -->
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="phoneNumber">Phone
                                                                            Number</label>
                                                                        <input type="tel" class="form-control" id="phoneNumber" pattern="[0-9]{11}" name="phoneNumber"> <!-- Phone number input that only accepts numbers -->
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="addressInput">Home address <span style="color: red;">*</span></label> <!-- Required field -->
                                                                        <input type="text" class="form-control" id="address" required name="address"> <!-- Address input -->
                                                                    </div>

                                                                    <script>
                                                                        // Uses the Google Maps API to autocomplete the address input
                                                                        // Wait for the page to load
                                                                        document.addEventListener('DOMContentLoaded', function() {
                                                                            // Create the Autocomplete object with UK address restrictions
                                                                            const autocomplete = new google.maps.places.Autocomplete( 
                                                                                document.getElementById('address'), {
                                                                                    types: ['geocode'], // Only return geocoding results (addresses)
                                                                                    componentRestrictions: {
                                                                                        country: 'GB'
                                                                                    } // Restrict to UK addresses
                                                                                });

                                                                            // Add an event listener to update the input field with the formatted address when a place is selected
                                                                            autocomplete.addListener('place_changed', function() { // When a place is selected
                                                                                const place = autocomplete.getPlace(); // Get the place details
                                                                                document.getElementById('address').value = place.formatted_address; // Update the address input with the formatted address
                                                                            });
                                                                        });
                                                                    </script>

                                                                    <style>
                                                                        /* Styling for the address input */
                                                                        .form-group {
                                                                            margin-bottom: 1rem;
                                                                        }

                                                                        label {
                                                                            font-weight: bold;
                                                                        }

                                                                        input.form-control {
                                                                            height: calc(2.25rem + 2px);
                                                                            padding: .375rem .75rem;
                                                                            font-size: 1rem;
                                                                            line-height: 1.5;
                                                                            border-radius: .25rem;
                                                                            border: 1px solid #ced4da;
                                                                        }
                                                                    </style>
                                                                </div>


                                                                <div class="col-md-6">

                                                                    <div class="form-group">
                                                                        <label for="accountType">
                                                                            Account Type <span style="color: red;">*</span> <!-- Required field -->
                                                                        </label>
                                                                        <select class="select3" style="width: 100%;" id="accountType" name="accountType" required> <!-- Dropdown list to select the user's account type -->
                                                                            <option value="" disabled selected hidden>Please select</option>
                                                                            <option value="Employee">Employee</option>
                                                                            <option value="Manager">Manager</option>
                                                                            <option value="Administrator">Administrator</option>
                                                                        </select>
                                                                    </div>


                                                                    <style>
                                                                        /* Dropdown styling */
                                                                        .select3 {
                                                                            padding: 8px;
                                                                            font-size: 14px;
                                                                            border: 1px solid #ccc;
                                                                            border-radius: 5px;
                                                                            appearance: none;
                                                                            -webkit-appearance: none;
                                                                            -moz-appearance: none;
                                                                        }
                                                                    </style>


                                                                    <div class="form-group">
                                                                        <label for="empNo">
                                                                            Employee Number <span style="color: red;">*</span> <!-- Required field -->
                                                                        </label>
                                                                        <input type="text" class="form-control" id="empNo" placeholder="Enter a 13 digit number" pattern="[0-9]{13}" name="empNo" required> <!-- Employee number input that only accepts numbers -->
                                                                    </div>

                                                                    
                                                                    <div class="form-group">
                                                                    <label for="teams">Team ID: <span style="color: red;">*</span></label>
                                                                    <input type="text" class="form-control" id="teams" name="teams" placeholder="Search for a team ID" list="teamList1" required> <!-- Team ID input that only accepts numbers -->

                                                                    <datalist id="teamList1">
                                                                        <!-- Datalist to display all team IDs -->
                                                                        <?php
                                                                        // Query the teams table to get all teamIDs
                                                                        $sql = "SELECT teamID FROM Teams";
                                                                        $result = mysqli_query($conn, $sql);

                                                                        // Loop through the query results and display them as options in the datalist
                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo "<option value='" . $row["teamID"] . "'>";
                                                                        }
                                                                        ?>
                                                                    </datalist>

                                                                    <script>
                                                                        // Creates an active search for the datalist
                                                                        // Listen for changes on the datalist input
                                                                        document.getElementById("teamID").addEventListener("input", function() {
                                                                            // Get the selected option and set the hidden input value to the corresponding data-value attribute
                                                                            var option = document.querySelector("#teamList1 option[value='" + this.value + "']");
                                                                            if (option) {
                                                                                document.getElementById("teamID").value = option.value;
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>

                                                                    <div class="form-group">
                                                                        <label class="label" for="email">Email <span style="color: red;">*</span></label>
                                                                        <input type="email" class="form-control" placeholder="example.1234@sourcetech.net" required name="email" id="email" /> <!-- Email input -->
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password">Create a password <span style="color: red;">*</span></label>
                                                                        <input type="password" class="form-control" placeholder="Password" required name="password" id="password" /> <!-- Password input -->
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="confirmPassword">Confirm Password <span style="color: red;">*</span></label>
                                                                        <input type="password" class="form-control" placeholder="Enter your password again" required name="confirmPassword" id="confirmPassword" /> <!-- Confirm password input -->
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <!-- Error message -->
                                                            <?php
                                                            //Empty input
                                                            if (isset($_GET['error']) && $_GET['error'] === "emptyinput") {
                                                                $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";
                                                            }
                                                            //Password mismatch
                                                            else if (isset($_GET['error']) && $_GET['error'] === "passwordsdontmatch") {
                                                                $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";
                                                            }
                                                            //Email already exists
                                                            else if (isset($_GET['error']) && $_GET['error'] === "emailalreadyexists") {
                                                                $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";
                                                                //Employee Number already exists
                                                            } else if (isset($_GET['error']) && $_GET['error'] === "useralreadyexists") {
                                                                $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                                                echo "<div class='title' style='text-align: center; padding: 2% 0% 2% 0%; color: red;'>" . htmlspecialchars($message) . "</div>";
                                                            }
                                                            ?>
                                                            <!-- End of error message -->

                                                            
                                                            <button type="submit" name="submit" class="form-control btn     btn-primary rounded submit px-3"> <!-- Submit button -->
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
                            <?php include("../includes/_footer.php"); ?> <!-- Footer -->
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
                <script src="../js/off-canvas.js"></script>
                <script src="../js/hoverable-collapse.js"></script>
                <script src="../js/template.js"></script>
                <script src="../js/settings.js"></script>
                <script src="../js/todolist.js"></script>
                <!-- Custom js for this page-->
                <script src="../js/dashboard.js"></script>
                <script src="../js/Chart.roundedBarCharts.js"></script>
                <!-- End custom js for this page-->

                <script>
                    // Loader script for page
                    var loader = document.querySelector(".loader")

                    window.addEventListener("load", vanish);

                    function vanish() {
                        loader.classList.add("disppear");
                    }
                </script>

                <script>
                    // Script to set the max and min date for the date of birth input
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