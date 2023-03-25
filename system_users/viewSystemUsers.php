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

            <!-- partial:includes/_settings-panel.html -->
            <?php include "../includes/_settings-panel.php"; ?>

            <!-- partial:includes/_adminsidebar.php -->
            <?php include '../includes/_adminsidebar.php'; ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="font-weight-bold">View System Users</h2>
                            <h6 class="font-weight-normal mb-0">
                                All systems are running smoothly! You have
                                <span class="text-primary">3 unread alerts!</span>
                            </h6>
                        </div>
                        <div class="col-md-4 text-md-right">
                            <a href="createSystemUser.php" class="btn btn-link text-decoration-none text-reset" id="add-user">
                                <i class="bi bi-person-plus" style="font-size: 1.5rem; color: #375577;"></i>
                            </a>
                            <button type="button" class="btn btn-link text-decoration-none text-reset" id="edit-user" style="opacity: 0.5; pointer-events: none;">
                                <i class="bi bi-pencil-square" style="font-size: 1.5rem; color: #375577;"></i>
                            </button>
                            <button type="button" class="btn btn-link text-decoration-none text-reset" id="delete-user" style="opacity: 0.5; pointer-events: none;">
                                <i class="bi bi-trash3" style="font-size: 1.5rem; color: #375577;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive mt-3">
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
                                        const addBtn = document.getElementById('add-user');
                                        const editBtn = document.getElementById('edit-user');
                                        const deleteBtn = document.getElementById('delete-user');
                                        const tableRows = document.querySelectorAll('#data-table-basic tbody tr');

                                        tableRows.forEach(row => {
                                            row.addEventListener('click', () => {
                                                // Highlight the clicked row
                                                tableRows.forEach(row => {
                                                    row.classList.remove('selected');
                                                });
                                                row.classList.add('selected');

                                                // Enable/disable the edit and delete buttons
                                                const selectedRows = document.querySelectorAll('#data-table-basic tbody tr.selected');
                                                if (selectedRows.length === 1) {
                                                    editBtn.style.opacity = '1';
                                                    editBtn.style.pointerEvents = 'auto';
                                                    deleteBtn.style.opacity = '1';
                                                    deleteBtn.style.pointerEvents = 'auto';
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
                                        editBtn.addEventListener('click', () => {
                                            const selectedRows = document.querySelectorAll('#data-table-basic tbody tr.selected');
                                            if (selectedRows.length === 1) {
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

                                                const modal = new bootstrap.Modal(document.getElementById('edit-user-modal'), {
                                                    keyboard: false
                                                });
                                                modal.show();
                                            }
                                        });

                                        deleteBtn.addEventListener('click', () => {
                                            const selectedRows = document.querySelectorAll('#data-table-basic tbody tr.selected');
                                            if (selectedRows.length === 1) {
                                                const empNo = selectedRows[0].childNodes[0].innerHTML;
                                                if (confirm(`Are you sure you want to delete user with employee number ${empNo}?`)) {
                                                    const form = document.createElement('form');
                                                    form.action = '';
                                                    form.method = 'post';

                                                    const empNoField = document.createElement('input');
                                                    empNoField.type = 'hidden';
                                                    empNoField.name = 'empNo';
                                                    empNoField.value = empNo;

                                                    const deleteField = document.createElement('input');
                                                    deleteField.type = 'hidden';
                                                    deleteField.name = 'delete';
                                                    deleteField.value = 'true';

                                                    form.appendChild(empNoField);
                                                    form.appendChild(deleteField);
                                                    document.body.appendChild(form);

                                                    form.submit();
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