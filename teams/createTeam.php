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
                        <div class="col-md-12 grid-margin">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <h3 class="font-weight-bold">View teams</h3>
                                    <h6 class="font-weight-normal mb-0">
                                        All systems are running smoothly! You have
                                        <span class="text-primary">3 unread alerts!</span>
                                    </h6>
                                </div>
                                <div class="col-12 col-xl-4">
                                    <div class="justify-content-end d-flex">
                                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                            <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                                <a class="dropdown-item" href="#">January - March</a>
                                                <a class="dropdown-item" href="#">March - June</a>
                                                <a class="dropdown-item" href="#">June - August</a>
                                                <a class="dropdown-item" href="#">August - November</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Project ID</th>
                                                    <th>Project Name</th>
                                                    <th>Status</th>
                                                    <th>Team ID</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Priority</th>
                                                    <th>Project Lead</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>000001</td>
                                                    <td>Phoenix Management</td>
                                                    <td>
                                                        <label class="badge badge-warning">Starting</label>
                                                    </td>
                                                    <td>ST0725</td>
                                                    <td>25/07/2022</td>
                                                    <td>25/01/2023</td>
                                                    <td>
                                                        <label class="badge badge-success">Low</label>
                                                    </td>
                                                    <td>Kevin Titus</td>
                                                </tr>

                                                <tr>
                                                    <td>000002</td>
                                                    <td>Radyr Admin System</td>
                                                    <td>
                                                        <label class="badge badge-danger">Client Interviews</label>
                                                    </td>
                                                    <td>ST0312</td>
                                                    <td>27/02/2022</td>
                                                    <td>15/06/2023</td>
                                                    <td>
                                                        <label class="badge badge-danger">High</label>
                                                    </td>
                                                    <td>Robert Thomas</td>
                                                </tr>

                                                <tr>
                                                    <td>000003</td>
                                                    <td>Wilkinson Construction Site</td>
                                                    <td>
                                                        <label class="badge badge-warning">Documentation Handover</label>
                                                    </td>
                                                    <td>ST2479</td>
                                                    <td>25/07/2022</td>
                                                    <td>25/01/2023</td>
                                                    <td>
                                                        <label class="badge badge-warning">Medium</label>
                                                    </td>
                                                    <td>William Morgan</td>
                                                </tr>

                                                <tr>
                                                    <td>000004</td>
                                                    <td>Wineyard application</td>
                                                    <td>
                                                        <label class="badge badge-success">Finished</label>
                                                    </td>
                                                    <td>ST0725</td>
                                                    <td>25/07/2022</td>
                                                    <td>25/01/2023</td>
                                                    <td>
                                                        <label class="badge badge-success">Completed</label>
                                                    </td>
                                                    <td>Ewan Crowel</td>
                                                </tr>

                                                <tr>
                                                    <td>000005</td>
                                                    <td>InfoTech Solutions</td>
                                                    <td>
                                                        <label class="badge badge-danger">Not Started</label>
                                                    </td>
                                                    <td>ST0725</td>
                                                    <td>25/07/2022</td>
                                                    <td>25/01/2023</td>
                                                    <td>
                                                        <label class="badge badge-success">Low</label>
                                                    </td>
                                                    <td>Ethan Clapham</td>
                                                </tr>

                                                <tr>
                                                    <td>000006</td>
                                                    <td>BAE Systems</td>
                                                    <td>
                                                        <label class="badge badge-success">Finished</label>
                                                    </td>
                                                    <td>ST0725</td>
                                                    <td>25/07/2022</td>
                                                    <td>25/01/2023</td>
                                                    <td>
                                                        <label class="badge badge-success">Completed</label>
                                                    </td>
                                                    <td>Zayan Zahid</td>
                                                </tr>

                                                <tr>
                                                    <td>000007</td>
                                                    <td>Deloitte Management</td>
                                                    <td>
                                                        <label class="badge badge-success">Ready to handover</label>
                                                    </td>
                                                    <td>ST0725</td>
                                                    <td>25/07/2022</td>
                                                    <td>25/01/2023</td>
                                                    <td>
                                                        <label class="badge badge-danger">High</label>
                                                    </td>
                                                    <td>Daniel Zhang</td>
                                                </tr>

                                                <tr>
                                                    <td>000008</td>
                                                    <td>PWC - Login Page</td>
                                                    <td>
                                                        <label class="badge badge-warning">Starting</label>
                                                    </td>
                                                    <td>ST0725</td>
                                                    <td>25/07/2022</td>
                                                    <td>25/01/2023</td>
                                                    <td>
                                                        <label class="badge badge-success">Low</label>
                                                    </td>
                                                    <td>Mared Bridgeman</td>
                                                </tr>

                                                <tr>
                                                    <td>000009</td>
                                                    <td>Phoenix Site</td>
                                                    <td>
                                                        <label class="badge badge-danger">Pending</label>
                                                    </td>
                                                    <td>ST0725</td>
                                                    <td>25/07/2022</td>
                                                    <td>25/01/2023</td>
                                                    <td>
                                                        <label class="badge badge-danger">Medium</label>
                                                    </td>
                                                    <td>Lily Gainsbury</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
        var loader = document.querySelector(".loader")

        window.addEventListener("load", vanish);

        function vanish() {
            loader.classList.add("disppear");
        }
    </script>


</body>

</html>