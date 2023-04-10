<!--Created by Kevin Titus on 2022-07-19.-->
<!-- PHP intergration -->
<?php 
require_once('../includes/functions.inc.php'); // Include the PHP functions to be used on the page
// Make a database connection
$conn = require '../includes/dbconfig.php'; // Connect to the database file

// Start the session
session_start();
$empNo = $_SESSION['empNo'];
$firstName = getFirstName($conn, $empNo);
$lastName = getLastName($conn, $empNo);
$accountType = getAccountType($conn, $empNo);

// If the delete button is clicked, the following will delete the project from the database
if (isset($_POST['delete-project'])) {
    $projectID = $_POST["projectID"];
    $query = "DELETE FROM projects WHERE projectID = $projectID";
    mysqli_query($conn, $query);
    header("Location: viewProjects.php");
    exit();
}

// Define the SQL query to retrieve data from the Users Table
$sql = "SELECT * FROM Users";

// Execute the query and get the result set
$result = mysqli_query($conn, $sql);

$sql = "SELECT * FROM Projects";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>View Projects | Source Tech Portal</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
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

    /* Team Cards */
    .team-card {
        border: 1px solid #ddd;
        padding: 10px;
        margin: 10px;
        display: inline-block;
        width: 265px;
        box-sizing: border-box;
        vertical-align: top;
        position: relative;
        border-radius: 10px;
        text-align: center;
        overflow: hidden;
    }

    .team-card:hover {
        box-shadow: 0 0 5px #ddd;
    }

    .team-card .team-pic {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 10px;
        background-color: #ddd;
        background-size: cover;
        background-position: center;
        display: inline-block;
        border: 5px solid white;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    }

    .team-card .team-name {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #375577;
        text-shadow: 1px 1px #ddd;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .team-card .team-info {
        font-size: 14px;
        margin-bottom: 5px;
        color: black;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .create-team-card {
        border: 1px dashed #ddd;
        padding: 10px;
        margin: 10px;
        display: inline-block;
        width: 265px;
        height: 220px;
        box-sizing: border-box;
        vertical-align: top;
        position: relative;
        cursor: pointer;
        border-radius: 10px;
        text-align: center;
    }

    .create-team-card:hover {
        border-color: #999;
    }

    .create-team-card .create-team-icon {
        font-size: 48px;
        color: #ddd;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .team-card.selected {
        border: 2px solid #375577;
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
                            <h2 class="font-weight-bold">View Projects</h2> <!-- Page Title -->
                        </div>
                        
                        <div class="col-md-4 text-md-right"> <!-- Add Project Button -->
                            <a href="createProjects.php" class="btn btn-link text-decoration-none text-reset" id="add-user">
                                <i class="bi bi-plus" style="font-size: 1.5rem; color: #375577;"></i>
                            </a>
                             <!-- Edit Project Button -->
                            <button type="button" class="btn btn-link text-decoration-none text-reset" id="edit-project" style="opacity: 0.5; pointer-events: none;">
                                <i class="bi bi-pencil-square" style="font-size: 1.5rem; color: #375577;"></i>
                            </button>
                             <!-- Delete Project Button -->
                            <button type="button" class="btn btn-link text-decoration-none text-reset" id="delete-project" style="opacity: 0.5; pointer-events: none;">
                                <i class="bi bi-trash2" style="font-size: 1.5rem; color: #375577;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12 grid-margin stretch-card"> <!-- Main panel card -->
                            <div class="card">
                                <div class="card-body"> <!-- Main panel card body -->
                                    <!-- Team Cards -->
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<div class="team-card">'; // Team card
                                        echo '<div class="team-pic" style="background-image: url(' . $row["team_pic"] . ');"></div>'; // Team picture
                                        echo '<div class="team-name">' . $row["projectName"] . '</div>'; // Team name
                                        echo '<div class="team-info" data-projectID="' . $row["projectID"] . '">Project ID: ' . $row["projectID"] . '</div>'; // Project ID
                                        echo '<div class="team-info">Status: ' . $row["projectStatus"] . '</div>'; // Project status
                                        // Retrieve full name and email of project lead from Users table
                                        // Variable retrieval
                                        $projectID = $row["projectID"]; // Project ID
                                        $projectLeadID = $row["projectLeadID"]; // Project lead ID
                                        $query = "SELECT CONCAT(firstName, ' ', lastName) AS fullName, email FROM Users WHERE userID = $projectLeadID"; // Query to retrieve full name and email of project lead
                                        $result2 = mysqli_query($conn, $query); // Execute query
                                        $projectLeadRow = mysqli_fetch_assoc($result2); // Retrieve row
                                        $projectLeadFullName = $projectLeadRow["fullName"]; // Project lead full name
                                        $projectLeadEmail = $projectLeadRow["email"]; // Project lead email
                                        echo '<div class="team-info">Team Lead: ' . $projectLeadFullName . '</div>'; // Project lead full name
                                        // Make the email address clickable and opens the default email client
                                        echo '<div class="team-info">Email: <a href="mailto:' . $projectLeadEmail . '">' . $projectLeadEmail . '</a></div>';
                                        echo '</div>';
                                    }
                                    ?>
                                    <div class="create-team-card" onclick="location.href='createProjects.php';"> <!-- If clicked, redirect to createProjects.php -->
                                        <div class="create-team-icon">+</div>
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

    <!-- Loader -->
    <script>
        var loader = document.querySelector(".loader")

        window.addEventListener("load", vanish);

        function vanish() {
            loader.classList.add("disppear");
        }
    </script>


</body>

<!-- Javascript to allow user to select by clicking on cards -->
<script>
    // Get all the team cards
    const teamCards = document.querySelectorAll('.team-card');

    // Add event listeners to each team card
    teamCards.forEach(teamCard => {
        // Add click event listener
        teamCard.addEventListener('click', function() {
            // Check if the team card is already selected
            const isSelected = this.classList.contains('selected');

            // Deselect all the team cards
            teamCards.forEach(teamCard => {
                teamCard.classList.remove('selected');
            });

            // If the team card is not already selected, select it
            if (!isSelected) {
                this.classList.add('selected');
            }

            // Get the edit and delete buttons
            const editButton = document.getElementById('edit-project');
            const deleteButton = document.getElementById('delete-project');

            // If a team card is selected, make the edit and delete buttons clickable
            if (document.querySelector('.team-card.selected')) {
                editButton.style.opacity = '1';
                editButton.style.pointerEvents = 'auto';
                deleteButton.style.opacity = '1';
                deleteButton.style.pointerEvents = 'auto';
            } else {
                // Otherwise, disable the edit and delete buttons
                editButton.style.opacity = '0.5';
                editButton.style.pointerEvents = 'none';
                deleteButton.style.opacity = '0.5';
                deleteButton.style.pointerEvents = 'none';
            }
        });
    });

    // Javascript to allow user to delete projects by clicking on the delete button
    const deleteBtn = document.getElementById('delete-project');

    deleteBtn.addEventListener('click', () => {
        // Get the selected project card
        const selectedTeamCard = document.querySelector('.team-card.selected');
        if (selectedTeamCard) {
            const projectID = selectedTeamCard.querySelector('.team-info').dataset.projectid;

            // Show a confirmation dialog
            const confirmDelete = confirm(`Are you sure you want to delete Project ID ${projectID}?`);
            if (confirmDelete) {
                // Create a form dynamically
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'viewProjects.php';
                
                // Create a hidden input field for the projectID
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'projectID';
                input.value = projectID;
                
                // Append the input field to the form
                form.appendChild(input);
                
                // Append the form to the body and submit it
                document.body.appendChild(form);
                form.submit();
            }
        }
    });
</script>

<!-- Add the delete project form to your HTML -->
<form id="delete-form" method="post" style="display:none;">
    <input type="hidden" name="projectID" id="delete-project-id">
    <input type="submit" name="delete-project">
</form>
</html>