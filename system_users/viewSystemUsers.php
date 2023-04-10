<!--Created by Kevin Titus on 2022-07-19.-->
<!-- PHP intergration -->
<?php
require_once('../includes/functions.inc.php'); // Include the functions file
// Make a database connection
$conn = require '../includes/dbconfig.php'; // Include the database connection file which returns the connection variable

// Start the session
session_start();
$empNo = $_SESSION['empNo']; // Get the employee number from the session
$firstName = getFirstName($conn, $empNo); // Get the first name from the database
$lastName = getLastName($conn, $empNo); // Get the last name from the database
$accountType = getAccountType($conn, $empNo); // Get the account type from the database

// If the delete button is triggered, a query is executed to delete the user from the database
if (isset($_POST['delete'])) {
    $empNo = $_POST['empNo'];
    $sql = "DELETE FROM Users WHERE empNo='$empNo'";
    mysqli_query($conn, $sql);
}

// Define the SQL query to retrieve data from the Users Table
$sql = "SELECT * FROM Users";

// Execute the query and get the result set
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>View System Users | Source Tech Portal</title> <!-- Title of the page -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-vn+VrRGJkbPZdVgbNVl0GDM98/r50LZxJxh7qPy9XrHr7FzRgNlV0kjfOZowWV7fqbGmzTcTmF9bPYfbtBvM+w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-BiMDI4PnLMT6U5SjjU5vQF5I6Rh3qBpfW8VDvL0swroCmzBtvHfZC8SKv6EGIzoIDc1NEiKbJKYqXlNmc5i6UQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
    <link rel="shortcut icon" href="../images/favicon.ico" />

    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet" />

    <!-- Data Table JS
		============================================ -->
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css" />

    <!-- Google Maps API used for the address field in the edit user modal -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvUiP0DYjb3XiFw9toptx7gBtokfnyfFM&libraries=places"></script>

</head>
<style>
    /* Loader CSS */
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
                            <h2 class="font-weight-bold">View System Users</h2> <!-- Page title -->
                            <h6 class="font-weight-normal mb-0">
                                All systems are running smoothly! You have
                                <span class="text-primary">3 unread alerts!</span>
                            </h6>
                        </div>
                        <div class="col-md-4 text-md-right">
                            <a href="createSystemUser.php" class="btn btn-link text-decoration-none text-reset" id="add-user"> <!-- Add user button -->
                                <i class="bi bi-person-plus" style="font-size: 1.5rem; color: #375577;"></i>
                            </a>
                            <a href="userPerformance.php" class="btn btn-link text-decoration-none text-reset" id="team-performance"> <!-- User performance button -->
                                <i class="bi bi-award" style="font-size: 1.5rem; color: #375577;"></i>
                            </a>
                            <button type="button" class="btn btn-link text-decoration-none text-reset" id="edit-user" style="opacity: 0.5; pointer-events: none;"> <!-- Edit user button -->
                                <i class="bi bi-pencil-square" style="font-size: 1.5rem; color: #375577;"></i>
                            </button>
                            <button type="button" class="btn btn-link text-decoration-none text-reset" id="delete-user" style="opacity: 0.5; pointer-events: none;"> <!-- Delete user button -->
                                <i class="bi bi-trash3" style="font-size: 1.5rem; color: #375577;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive mt-3">
                                        <!-- Data table which displays all users -->
                                        <table id="data-table-basic" class="table table-hover">
                                            <thead>
                                                <!-- Table headings -->
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
                                                // Loop through each row in the result set and output the data to the table
                                                while ($row = mysqli_fetch_assoc($result)) { // Fetches a result row as an associative array
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

                                    <!-- Edit user modal, this modal shows up only if a user is selected and the edit button is triggered -->
                                    <script>
                                        // Declaring constants
                                        const addBtn = document.getElementById('add-user');
                                        const editBtn = document.getElementById('edit-user');
                                        const deleteBtn = document.getElementById('delete-user');
                                        const tableRows = document.querySelectorAll('#data-table-basic tbody tr');

                                        // Highlight the selected row
                                        tableRows.forEach(row => {
                                            row.addEventListener('click', () => { // Add an event listener to each row
                                                // Highlight the clicked row
                                                tableRows.forEach(row => {
                                                    row.classList.remove('selected'); // Remove the selected class from all rows
                                                });
                                                row.classList.add('selected'); // Add the selected class to the clicked row

                                                // Enable/disable the edit and delete buttons
                                                const selectedRows = document.querySelectorAll('#data-table-basic tbody tr.selected'); // Get all selected rows
                                                if (selectedRows.length === 1) { // If only one row is selected
                                                    editBtn.style.opacity = '1'; // Enable the edit button
                                                    editBtn.style.pointerEvents = 'auto'; // Enable the edit button
                                                    deleteBtn.style.opacity = '1'; // Enable the delete button
                                                    deleteBtn.style.pointerEvents = 'auto'; // Enable the delete button
                                                } else {
                                                    editBtn.style.opacity = '0.5';
                                                    editBtn.style.pointerEvents = 'none';
                                                    deleteBtn.style.opacity = '0.5';
                                                    deleteBtn.style.pointerEvents = 'none';
                                                }
                                            });
                                        });

                                        // Unselect the data row when clicking outside the table
                                        document.addEventListener('click', (event) => {
                                            const isClickInsideTable = event.target.closest('#data-table-basic tbody');
                                            if (!isClickInsideTable) {
                                                tableRows.forEach(row => {
                                                    row.classList.remove('selected');
                                                });
                                                editBtn.style.opacity = '0.5';
                                                editBtn.style.pointerEvents = 'none';
                                                deleteBtn.style.opacity = '0.5';
                                                deleteBtn.style.pointerEvents = 'none';
                                            }
                                        });

                                        // Open the edit user modal form when the edit button is clicked
                                        // Event listener for edit button click
                                        editBtn.addEventListener('click', () => {
                                            const selectedRows = document.querySelectorAll('#data-table-basic tbody tr.selected'); // Get all selected rows

                                            // Check if exactly one row is selected
                                            if (selectedRows.length === 1) {
                                                // Extract relevant data from the selected row
                                                const fullName = selectedRows[0].childNodes[1].innerHTML;
                                                const nameParts = fullName.split(' ');
                                                const firstName = nameParts[0];
                                                const lastName = nameParts.length > 1 ? nameParts[nameParts.length - 1] : '';
                                                const gender = selectedRows[0].childNodes[3].innerHTML;
                                                const DOB = selectedRows[0].childNodes[3].innerHTML;
                                                const phoneNumber = selectedRows[0].childNodes[7].innerHTML;
                                                const address = selectedRows[0].childNodes[8].innerHTML;
                                                const accountType = selectedRows[0].childNodes[0].innerHTML;
                                                const empNo = selectedRows[0].childNodes[0].innerHTML;
                                                const teams = selectedRows[0].childNodes[4].innerHTML;
                                                const email = selectedRows[0].childNodes[3].innerHTML;

                                                // Populate the edit form with the extracted data
                                                document.getElementById('edit-user-firstName').value = firstName;
                                                document.getElementById('edit-user-middleName').value = '';
                                                document.getElementById('edit-user-lastName').value = lastName;
                                                document.getElementById('edit-user-gender').value = gender;
                                                document.getElementById('edit-user-DOB').value = DOB;
                                                document.getElementById('edit-user-phoneNumber').value = phoneNumber;
                                                document.getElementById('edit-user-address').value = address;
                                                document.getElementById('edit-user-accountType').value = accountType;
                                                document.getElementById('edit-user-empNo').value = empNo;
                                                document.getElementById('edit-user-teams').value = teams;
                                                document.getElementById('edit-user-email').value = email;

                                                // Show the edit user modal
                                                const modal = new bootstrap.Modal(document.getElementById('edit-user-modal'), {
                                                    keyboard: false
                                                });
                                                modal.show();
                                            }
                                        });

                                        deleteBtn.addEventListener('click', () => {
                                            const selectedRows = document.querySelectorAll('#data-table-basic tbody tr.selected'); // Get all selected rows
                                            if (selectedRows.length === 1) { // Check if exactly one row is selected
                                                const empNo = selectedRows[0].childNodes[0].innerHTML; // Get employee number from the first cell of the selected row
                                                if (confirm(`Are you sure you want to delete user with employee number ${empNo}?`)) { // Show a confirmation dialog before deleting
                                                    const form = document.createElement('form'); // Create a new form element
                                                    form.action = ''; // Set the form action (empty string for now, needs to be updated with appropriate URL)
                                                    form.method = 'post'; // Set the form method to POST

                                                    const empNoField = document.createElement('input'); // Create a new input element for employee number
                                                    empNoField.type = 'hidden'; // Set the input type to hidden
                                                    empNoField.name = 'empNo'; // Set the input name to 'empNo'
                                                    empNoField.value = empNo; // Set the input value to the employee number

                                                    const deleteField = document.createElement('input'); // Create a new input element for delete flag
                                                    deleteField.type = 'hidden'; // Set the input type to hidden
                                                    deleteField.name = 'delete'; // Set the input name to 'delete'
                                                    deleteField.value = 'true'; // Set the input value to 'true' to indicate deletion

                                                    form.appendChild(empNoField); // Append the employee number input to the form
                                                    form.appendChild(deleteField); // Append the delete flag input to the form
                                                    document.body.appendChild(form); // Append the form to the body of the document

                                                    form.submit(); // Submit the form to initiate the deletion process
                                                }
                                            }
                                        });
                                    </script>

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
                        <h5 class="modal-title" id="edit-user-modal-label">Edit User Details</h5> <!-- Modal title -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="edit-user-form">  <!-- Form for editing user details -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label for="edit-user-firstName" class="form-label">First Name</label>  <!-- First name input -->
                                        <input type="text" class="form-control" id="edit-user-firstName" name="firstName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-user-middleName" class="form-label">Middle Name</label>  <!-- Middle name input -->
                                        <input type="text" class="form-control" id="edit-user-middleName" name="Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-user-lastName" class="form-label">Last Name</label>  <!-- Last name input -->
                                        <input type="text" class="form-control" id="edit-user-lastName" name="lastName">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">  <!-- Gender input -->
                                                <label for="edit-user-gender"> 
                                                    Gender
                                                </label>
                                                 <!-- Drop down for gender input -->
                                                <select class="select2" style="width: 100%; height: 44px;" id="edit-user-gender" name="gender" required>
                                                    <option value="" disabled selected hidden>Please select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                    <option value="not-say">Prefer not to say</option>
                                                </select>
                                            </div>
                                            
                                             <!-- CSS for drop down -->
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

                                         <!-- Date of birth input -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="edit-user-DOB">
                                                    Date of birth
                                                </label>
                                                <input type="date" class="form-control" id="edit-user-DOB" name="DOB" required style="width: 100%; height: 44px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">  <!-- Phone number input -->
                                        <label for="edit-user-phoneNumber">Phone
                                            Number</label>
                                        <input type="tel" class="form-control" id="edit-user-phoneNumber" pattern="[0-9]{11}" name="phoneNumber">
                                    </div>

                                    <div class="mb-3">  <!-- Home address input -->
                                        <label for="edit-user-address">Home address </label>
                                        <input type="text" class="form-control" id="edit-user-address" required name="address">
                                    </div>

                                     <!-- Use Google Places API to autocomplete address input -->
                                    <script>
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
                                    </script> 
                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="edit-user-accountType">  <!-- Account type input -->
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
                                        <label for="edit-user-empNo" class="form-label">Employee No.</label>  <!-- Employee number input -->
                                        <input type="text" class="form-control" id="edit-user-empNo" name="empNo" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit-user-teams">  <!-- Team input -->
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
                                         // Search for teams in the datalist
                                         // Declare constants 
                                        const searchField = document.getElementById("teamSearch"); // Search field
                                        const optionsList = document.querySelectorAll("#teamList option"); // List of options

                                         // Add event listener to search field

                                        searchField.addEventListener("input", function() { // When the user types in the search field
                                            let options = ""; // Declare variable to store options
                                            optionsList.forEach(function(option) { // For each option in the list
                                                if (option.value.toLowerCase().includes(searchField.value.toLowerCase())) { // If the option value includes the search field value
                                                    options += "<option value='" + option.value + "'>" + option.value + "</option>"; // Add the option to the options variable
                                                }
                                            });
                                            searchField.setAttribute("list", "teamList"); // Set the search field's list attribute to the teamList
                                            document.getElementById("teamList").innerHTML = options; // Set the teamList's inner HTML to the options variable
                                        });
                                    </script>

                                    <div class="mb-3">
                                        <label for="edit-user-email" class="form-label">Email</label>  <!-- Email input -->
                                        <input type="email" class="form-control" id="edit-user-email" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-user-password" class="form-label">Create a new password</label>  <!-- Password input -->
                                        <input type="password" class="form-control" id="edit-user-password" name="password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-user-confirmPassword" class="form-label">Confirm new password</label>  <!-- Confirm password input -->
                                        <input type="password" class="form-control" id="edit-user-confirmPassword" name="confirmPassword">
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>  <!-- Close button for the edit user modal -->
                            <button type="submit" class="btn btn-primary">Save changes</button>  <!-- Save changes button for the edit user modal and updates the Users table -->
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
        <script src="../js/vendor/jquery-1.12.4.min.js"></script>
        <script src="../js/plugins.js"></script>
        <script src="../js/data-table/jquery.dataTables.min.js"></script>
        <script src="../js/data-table/data-table-act.js"></script>
        <script src="../js/main.js"></script>

        <script>
            // Loader
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