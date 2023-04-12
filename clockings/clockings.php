<!--Created by Kevin Titus on 2022-07-21.-->
<!-- PHP intergration -->
<?php
require_once('../includes/functions.inc.php');
// Make a database connection
$conn = require '../includes/dbconfig.php';

session_start();
$empNo = $_SESSION['empNo'];
$firstName = getFirstName($conn, $empNo);
$userID = getUserId($conn, $empNo);
$lastName = getLastName($conn, $empNo);
$accountType = getAccountType($conn, $empNo);


// Find the corresponding UserID for the empNo
$query = "SELECT UserID FROM Users WHERE empNo = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $empNo);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $userID = $row['UserID'];

    // Check for the latest clocking entry for the user
    $query = "SELECT * FROM Clockings WHERE UserID = ? ORDER BY clockInTime DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $status = $row['status'];
    } else {
        // Insert a new record with the status 'Clocked Out'
        $status = "Clocked Out";
        $query = "INSERT INTO Clockings (UserID, status) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $userID, $status);
        $stmt->execute();
    }
} else {
    // Handle user not found
    echo "User not found";
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
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.ico" />

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
                        <div class="col-md-12 grid-margin">
                            <div class="row justify-content-center">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h2 class="font-weight-bold">Clockings</h2>
                                </div>
                                <div class="col-12 col-xl-4 text-right font-weight-bold" style="font-size: 23px; margin-top: 20px; margin-right: -50px; text-align: right;">
                                    <div class="text-center">
                                        <?php
                                        $date = date('l, j M');
                                        $time = date('H:i');
                                        echo "<div>$date</div>";
                                        echo "<div>$time</div>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <p>User status: <span id="user-status"><?php echo $status; ?></span></p>
                            <div id="clocking-buttons">
                                <!-- The buttons will be loaded here via JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>
                    const userID = <?php echo $userID; ?>;

                    function loadButtonsAndStatus() {
                        console.log('Loading buttons and status for user ID:', userID);
                        $.ajax({
                            url: 'get_clocking_buttons.php',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                userID: userID
                            },
                            success: function(response) {
                                console.log('Successfully loaded buttons and status:', response); // Add this line
                                $('#clocking-buttons').html(response.buttons);
                                $('#user-status').text(response.status);
                            },

                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('Error loading buttons and status:', textStatus, errorThrown); // Update this line
                            }

                        });
                    }

                    $(document).ready(function() {
                        loadButtonsAndStatus();

                        $(document).on('click', '.clocking-action', function() {
                            console.log('Button clicked:', this);
                            const action = $(this).data('action');
                            $.ajax({
                                url: 'clocking_action.php',
                                method: 'POST',
                                dataType: 'text',
                                data: {
                                    userID: userID,
                                    action: action
                                },
                                success: function(response) {
                                    console.log('Clocking action success:', response);
                                    loadButtonsAndStatus();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error('Error performing clocking action:', textStatus, errorThrown);
                                }
                            });
                        });
                    });
                </script>





                <!-- content-wrapper ends -->
                <!-- partial:includes/_footer.php -->
                <?php include("../includes/_footer.php"); ?>
                <!-- partial -->



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
                    var loader = document.querySelector(".loader")

                    window.addEventListener("load", vanish);

                    function vanish() {
                        loader.classList.add("disppear");
                    }
                </script>



            </div>
        </div>
    </div>


</body>

</html>