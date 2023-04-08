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

$sql = "SELECT * FROM Teams";
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
        <h2 class="font-weight-bold">View Teams</h2>
    </div>
    <div class="col-md-4 text-md-right">
        <a href="createTeam.php" class="btn btn-link text-decoration-none text-reset" id="add-user">
            <i class="bi bi-plus" style="font-size: 1.5rem; color: #375577;"></i>
        </a>
        <a href="teamPerformance.php" class="btn btn-link text-decoration-none text-reset" id="team-performance">
            <i class="bi bi-award" style="font-size: 1.5rem; color: #375577;"></i>
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

                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<div class="team-card">';
                                        echo '<div class="team-pic" style="background-image: url(' . $row["team_pic"] . ');"></div>';
                                        echo '<div class="team-name">' . $row["teamName"] . '</div>';
                                        echo '<div class="team-info">Team ID: ' . $row["teamID"] . '</div>';
                                        echo '<div class="team-info">Department: ' . $row["department"] . '</div>';
                                        echo '<div class="team-info">Team Lead: ' . $row["teamLead"] . '</div>';
                                        echo '<div class="team-info">Contact Email: ' . $row["teamID"] . '</div>';
                                        echo '</div>';
                                    }
                                    ?>
                                    <div class="create-team-card" onclick="location.href='createTeam.php';">
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
                               
                              
                            </div>
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