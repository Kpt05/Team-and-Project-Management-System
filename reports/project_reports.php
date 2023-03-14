<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Skydash Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css" />
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
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
    <div class="container-scroller">

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
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card position-relative">
                                    <div class="card-body">
                                        <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="row">
                                                        <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                            <div class="ml-xl-4 mt-3">
                                                                <p class="card-title">Detailed Reports</p>
                                                                <h1 class="text-primary">$34040</h1>
                                                                <h3 class="font-weight-500 mb-xl-4 text-primary">
                                                                    North America
                                                                </h3>
                                                                <p class="mb-2 mb-xl-0">
                                                                    The total number of sessions within the date
                                                                    range. It is the period time a user is
                                                                    actively engaged with your website, page or
                                                                    app, etc
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-xl-9">
                                                            <div class="row">
                                                                <div class="col-md-6 border-right">
                                                                    <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                                        <table class="table table-borderless report-table">
                                                                            <tr>
                                                                                <td class="text-muted">Illinois</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        713
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">Washington</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        583
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">Mississippi</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        924
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">California</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        664
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">Maryland</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        560
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">Alaska</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        793
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <canvas id="north-america-chart"></canvas>
                                                                    <div id="north-america-legend"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="row">
                                                        <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                            <div class="ml-xl-4 mt-3">
                                                                <p class="card-title">Detailed Reports</p>
                                                                <h1 class="text-primary">$34040</h1>
                                                                <h3 class="font-weight-500 mb-xl-4 text-primary">
                                                                    North America
                                                                </h3>
                                                                <p class="mb-2 mb-xl-0">
                                                                    The total number of sessions within the date
                                                                    range. It is the period time a user is
                                                                    actively engaged with your website, page or
                                                                    app, etc
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-xl-9">
                                                            <div class="row">
                                                                <div class="col-md-6 border-right">
                                                                    <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                                        <table class="table table-borderless report-table">
                                                                            <tr>
                                                                                <td class="text-muted">Illinois</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        713
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">Washington</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        583
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">Mississippi</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        924
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">California</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        664
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">Maryland</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        560
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-muted">Alaska</td>
                                                                                <td class="w-100 px-0">
                                                                                    <div class="progress progress-md mx-4">
                                                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <h5 class="font-weight-bold mb-0">
                                                                                        793
                                                                                    </h5>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <canvas id="south-america-chart"></canvas>
                                                                    <div id="south-america-legend"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Line chart</h4>
                                        <canvas id="lineChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Bar chart</h4>
                                        <canvas id="barChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Area chart</h4>
                                        <canvas id="areaChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Doughnut chart</h4>
                                        <canvas id="doughnutChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Pie chart</h4>
                                        <canvas id="pieChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Scatter chart</h4>
                                        <canvas id="scatterChart"></canvas>
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
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="../js/off-canvas.js"></script>
        <script src="../js/hoverable-collapse.js"></script>
        <script src="../js/template.js"></script>
        <script src="../js/settings.js"></script>
        <script src="../js/todolist.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="../js/chart.js"></script>
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