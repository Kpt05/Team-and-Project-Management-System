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

            <!-- partial:includes/_adminsidebar.php -->
            <?php include '../includes/_adminsidebar.php'; ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="font-weight-bold">User Performance</h2>
                            <h6 class="font-weight-normal mb-0">
                            </h6>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container-fluid">


                                        <form method="post" action="../includes/signup.inc.php">
                                            <div class="form-group">
                                                <label for="userID">
                                                    Name: <span style="color: red;">*</span>
                                                </label>
                                                <select class="form-control" id="userID" name="userID" required>
                                                    <?php
                                                    // Query the users table to get all users with accountType "Employee" or "Manager"
                                                    $sql = "SELECT UserID, CONCAT(firstName, ' ', lastName, ' - ', empNo) AS fullName, empNo FROM Users WHERE accountType IN ('Employee', 'Manager')";
                                                    $result = mysqli_query($conn, $sql);

                                                    // Fetch query results and store them in an array
                                                    $users = array();
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $users[] = $row;
                                                    }

                                                    // Loop through the users array and display them as options in the dropdown list
                                                    foreach ($users as $user) {
                                                        $selected = "";
                                                        if (isset($_POST["userID"]) && $_POST["userID"] == $user["UserID"]) {
                                                            $selected = "selected";
                                                        }
                                                        echo "<option value='" . $user["UserID"] . "' " . $selected . ">" . $user["fullName"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="tasksCompleted">Tasks Completed:</label>
                                                <input type="text" class="form-control" id="tasksCompleted" name="tasksCompleted" required inputmode="numeric" pattern="[0-9]*">
                                            </div>

                                            <div class="form-group">
                                                <label for="hoursWorked">Hours Worked:</label>
                                                <input type="number" class="form-control" id="hoursWorked" name="hoursWorked" required>
                                            </div>

                                            <button type="submit" name="userPerformance" class="btn btn-primary">Submit</button>
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


    <!-- Edit user modal -->
    <div class="modal fade" id="edit-user-modal" tabindex="-1" aria-labelledby="edit-user-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-user-modal-label">Edit User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="edit-user-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="edit-user-firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="edit-user-firstName" name="firstName">
                                </div>
                                <div class="mb-3">
                                    <label for="edit-user-middleName" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="edit-user-middleName" name="Name">
                                </div>
                                <div class="mb-3">
                                    <label for="edit-user-lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="edit-user-lastName" name="lastName">
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit-user-gender">
                                                Gender
                                            </label>
                                            <select class="select2" style="width: 100%; height: 44px;" id="edit-user-gender" name="gender" required>
                                                <option value="" disabled selected hidden>Please select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                                <option value="not-say">Prefer not to say</option>
                                            </select>
                                        </div>

                                        <style>
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
                                            <label for="edit-user-DOB">
                                                Date of birth
                                            </label>
                                            <input type="date" class="form-control" id="edit-user-DOB" name="DOB" required style="width: 100%; height: 44px;">
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label for="edit-user-phoneNumber">Phone
                                        Number</label>
                                    <input type="tel" class="form-control" id="edit-user-phoneNumber" pattern="[0-9]{11}" name="phoneNumber">
                                </div>

                                <div class="mb-3">
                                    <label for="edit-user-address">Home address </label>
                                    <input type="text" class="form-control" id="edit-user-address" required name="address">
                                </div>

                                <!-- <script>
                                        // Wait for the page to load
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Create the Autocomplete object with UK address restrictions
                                            const autocomplete = new google.maps.places.Autocomplete(
                                                document.getElementById('edit-user-address'), {
                                                    types: ['geocode'], // Only return geocoding results (addresses)
                                                    componentRestrictions: {
                                                        country: 'GB'
                                                    } // Restrict to UK addresses
                                                });

                                            // Add an event listener to update the input field with the formatted address when a place is selected
                                            autocomplete.addListener('place_changed', function() {
                                                const place = autocomplete.getPlace();
                                                document.getElementById('edit-user-address').value = place.formatted_address;
                                            });
                                        });
                                    </script> -->
                            </div>


                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="edit-user-accountType">
                                        Account Type
                                    </label>
                                    <select class="select2" style="width: 100%; height: 44px;" id="edit-user-accountType" name="accountType" required>
                                        <option value="" disabled selected hidden>Please select</option>
                                        <option value="Employee">Employee</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Administrator">Administrator</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit-user-empNo" class="form-label">Employee No.</label>
                                    <input type="text" class="form-control" id="edit-user-empNo" name="empNo" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="edit-user-teams">
                                        Search Teams
                                    </label>
                                    <input type="text" class="form-control" id="edit-user-teams" name="teams" placeholder="Search Teams" list="teamList" required />

                                    <datalist id="teamList">
                                        <option value="Team 1">
                                        <option value="Team 2">
                                        <option value="Team 3">
                                            <!-- Add more options for each team -->
                                    </datalist>
                                </div>

                                <script>
                                    const searchField = document.getElementById("teamSearch");
                                    const optionsList = document.querySelectorAll("#teamList option");

                                    searchField.addEventListener("input", function() {
                                        let options = "";
                                        optionsList.forEach(function(option) {
                                            if (option.value.toLowerCase().includes(searchField.value.toLowerCase())) {
                                                options += "<option value='" + option.value + "'>" + option.value + "</option>";
                                            }
                                        });
                                        searchField.setAttribute("list", "teamList");
                                        document.getElementById("teamList").innerHTML = options;
                                    });
                                </script>

                                <div class="mb-3">
                                    <label for="edit-user-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit-user-email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="edit-user-password" class="form-label">Create a new password</label>
                                    <input type="password" class="form-control" id="edit-user-password" name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="edit-user-confirmPassword" class="form-label">Confirm new password</label>
                                    <input type="password" class="form-control" id="edit-user-confirmPassword" name="confirmPassword">
                                </div>

                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>


            </div>
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

<?php
// Close the database connection
mysqli_close($conn);
?>