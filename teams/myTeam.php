<!--Created by Kevin Titus on 2022-07-19.-->
<!-- PHP intergration -->
<?php
// Start the session
session_start();
require_once('../includes/functions.inc.php'); // Include the functions file
// Make a database connection
$conn = require '../includes/dbconfig.php'; // Include the database connection file
require_once '../includes/authentication.inc.php'; // Include the authentication.php file


$empNo = $_SESSION['empNo']; // Get the employee number of the logged in user
$firstName = getFirstName($conn, $empNo); // Get the first name of the logged in user
$lastName = getLastName($conn, $empNo); // Get the last name of the logged in user
$accountType = getAccountType($conn, $empNo); // Get the account type of the logged in user

// Authenticate the user
$isAuthenticated = authenticate($conn);

if (!$isAuthenticated) {
    // If not authenticated, redirect to the login page
    header("Location: ../index.php?error=notloggedin");
    exit();
}

//If the delete button is clicked, the team is deleted from the Teams table
if (isset($_POST['deleteTeam'])) {
    $teamID = $_POST['teamID'];
    $sql = "DELETE FROM Teams WHERE teamID='$teamID'";
    mysqli_query($conn, $sql);
}

// Define the SQL query to retrieve data from the Users Table
$sql = "SELECT * FROM Users";

// Execute the query and get the result set
$result = mysqli_query($conn, $sql);

$sql = "SELECT * FROM Teams";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>View Teams | Source Tech Portal</title> <!-- Page title -->
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

    /* Team Cards CSS */
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

    .team-card:hover { /* When the user hovers over the card, the shadow is increased */
        box-shadow: 0 0 5px #ddd;
    }

    /* The team picture */
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
    /* The team name */
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
    /* The team info */
    .team-card .team-info {
        font-size: 14px;
        margin-bottom: 5px;
        color: black;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    /* The team info */
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

    /* When the user hovers over the card, the shadow is increased */
    .create-team-card:hover {
        border-color: #999;
    }

    /* The team picture */
    .create-team-card .create-team-icon {
        font-size: 48px;
        color: #ddd;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    /* When the team card is selected, the card border is to change */
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
        <?php include "../includes/_navbar.php"; ?> <!-- The partial includes the nav bar on this page -->

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
                        <div class="col-md-8">
                            <h2 class="font-weight-bold">View Teams</h2>
                        </div>
                        <div class="col-md-4 text-md-right"> <!-- This is the button to add a new team -->
                            <a href="createTeam.php" class="btn btn-link text-decoration-none text-reset" id="add-user">
                                <i class="bi bi-plus" style="font-size: 1.5rem; color: #375577;"></i>
                            </a>
                            <a href="teamPerformance.php" class="btn btn-link text-decoration-none text-reset" id="team-performance"> <!-- This is the button to view team performance -->
                                <i class="bi bi-award" style="font-size: 1.5rem; color: #375577;"></i>
                            </a>
                            <button type="button" class="btn btn-link text-decoration-none text-reset" id="edit-user" style="opacity: 0.5; pointer-events: none;"> <!-- This is the button to edit a team -->
                                <i class="bi bi-pencil-square" style="font-size: 1.5rem; color: #375577;"></i>
                            </button>
                            <button type="button" class="btn btn-link text-decoration-none text-reset" id="delete-user" style="opacity: 0.5; pointer-events: none;"> <!-- This is the button to delete a team -->
                                <i class="bi bi-trash3" style="font-size: 1.5rem; color: #375577;"></i>
                            </button>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <!-- This is the section where the team cards are displayed -->
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) { // Loop through the results and display each team as a card
                                        echo '<div class="team-card">'; // The team card
                                        echo '<div class="team-pic" style="background-image: url(' . $row["team_pic"] . ');"></div>'; // The team picture
                                        echo '<div class="team-name">' . $row["teamName"] . '</div>'; // The team name
                                        echo '<div class="team-info">Team ID: ' . $row["teamID"] . '</div>'; // The team ID
                                        echo '<div class="team-info">Department: '; // The team department

                                        // Use a switch statement to map the department codes to their corresponding full names
                                        // As the department codes are stored in the database in a shortened form, this is necessary to display the full name of the department
                                        switch ($row["department"]) {
                                            case 'SLS':
                                                echo 'Sales';
                                                break;
                                            case 'MKT':
                                                echo 'Marketing';
                                                break;
                                            case 'FNC':
                                                echo 'Finance';
                                                break;
                                            case 'ENG':
                                                echo 'Engineering';
                                                break;
                                            case 'HR':
                                                echo 'Human Resources';
                                                break;
                                            case 'OP':
                                                echo 'Operations';
                                                break;
                                            case 'RD':
                                                echo 'Research and Development';
                                                break;
                                            case 'CUST':
                                                echo 'Customer Service';
                                                break;
                                            case 'PM':
                                                echo 'Product Management';
                                                break;
                                            case 'DES':
                                                echo 'Design';
                                                break;
                                            case 'IT':
                                                echo 'Information Technology';
                                                break;
                                            case 'BUS':
                                                echo 'Business Development';
                                                break;
                                            case 'PUB':
                                                echo 'Public Relations';
                                                break;
                                            default:
                                                echo $row["department"];
                                                break;
                                        }
                                        echo '</div>';
                                        echo '<div class="team-info">Team Lead: ' . $row["teamLead"] . '</div>'; // The team lead

                                        // Fetch teamLead email from Users table using teamLeadID from Teams table
                                        $teamLeadID = $row["teamLeadID"];
                                        $query = "SELECT `email` FROM `Users` WHERE `UserID` = $teamLeadID";
                                        $result2 = mysqli_query($conn, $query);
                                        $teamLeadRow = mysqli_fetch_assoc($result2);

                                        // Check if teamLeadRow is not empty
                                        if (!empty($teamLeadRow)) {
                                            echo '<div class="team-info">Email: ' . $teamLeadRow["email"] . '</div>'; // Display teamLead email
                                        } else {
                                            echo '<div class="team-info">Email: N/A</div>'; // Display N/A if teamLeadRow is empty
                                        }

                                        echo '</div>';
                                    }
                                    ?>

                                    <div class="create-team-card" onclick="location.href='createTeam.php';"> <!-- This is the card to create a new team -->
                                        <div class="create-team-icon">+</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- partial:includes/_footer.php -->
                <?php include("../includes/_footer.php"); ?> <!-- The partial includes the footer on this page -->
                <!-- partial -->
            </div>
        </div>


        <!-- The edit team modal -->
        <div class="modal fade" id="edit-team-modal" tabindex="-1" role="dialog" aria-labelledby="editTeamModalLabel" aria-hidden="true"> <!-- The modal is hidden by default -->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTeamModalLabel">Edit Team</h5> <!-- The modal title -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> <!-- The modal body -->
                        <!-- Modal body content -->
                        <form id="edit-team-form">
                            <input type="hidden" id="team-id" name="teamId" value="">
                            <div class="form-group">
                                <label for="team-name">Team Name</label>
                                <input type="text" class="form-control" id="team-name" name="teamName" readonly> <!-- The team name is readonly as it cannot be changed -->
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" readonly> <!-- The department is readonly as it cannot be changed -->
                            </div>
                            <div class="form-group">
                                <label for="team-lead">Team Lead</label>
                                <input type="text" class="form-control" id="team-lead" name="teamLead"> <!-- The team lead can be changed -->
                            </div>
                            <div class="form-group">
                                <label for="team-lead-id">Team Lead ID</label>
                                <input type="text" class="form-control" id="team-lead-id" name="teamLeadId" readonly> <!-- The team lead ID is readonly as it cannot be changed -->
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button> <!-- The save changes button -->
                        </form>
                    </div>
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
            const editButton = document.getElementById('edit-user');
            const deleteButton = document.getElementById('delete-user');

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
    
</script>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>