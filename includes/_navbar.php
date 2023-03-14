<!-- partial:/_navbar.php
<?php
session_start();
if (isset($_POST['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Redirect the user to the login page
    $rootUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php';
    header("Location: $rootUrl");
    exit;
}
?> -->

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="../dashboard.php"><img src="../images/logo.svg" class="mr-2" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="../dashboard.php"><img src="../images/logo-mini.svg" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">
                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                        <span class="input-group-text" id="search">
                            <i class="icon-search"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search" />
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">


            <li class="nav-item nav-profile dropdown">

                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown" id="profileDropdown">
                    <div class="profile-text pr-3" style="line-height: 1.2em;">
                        <p class="mb-0" style="margin-bottom: 0;"><?php echo $firstName . " " . $lastName; ?></p>
                        <small class="text-white" style="line-height: 1.2em;"><?php echo $accountType; ?></small>
                    </div>
                    <img src="../images/faces/face28.jpg" alt="profile" />
                </a>


                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item">
                        <i class="ti-user text-primary"></i>
                        My Profile
                    </a>
                    <a class="dropdown-item">
                        <i class="ti-settings text-primary"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="/index.php">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>

            <!-- HTML code for the logout button -->
            <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="#" onclick="logout()">
                    <i class="bi bi-box-arrow-in-right" style="font-size: 1.5rem;"></i>
                </a>
            </li>

            <!-- JavaScript code to handle logout button click -->
            <script>
                function logout() {
                    // Send an AJAX request to the server to destroy the session
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '<?php echo $_SERVER["PHP_SELF"]; ?>');
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('logout=true');
                    // Redirect the user to the login page
                    var currentUrl = window.location.href;
                    var rootUrl = currentUrl.replace(/\/.*$/i, '/index.php');
                    window.location.href = rootUrl;
                }
            </script>

        </ul>

        <!-- <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button> -->

    </div>
</nav>