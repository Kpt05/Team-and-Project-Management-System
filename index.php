<!--Created by Kevin Titus on 2022-07-16.-->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Source Tech Portal</title> <!-- Title of the page -->

    <!-- Meta taggs which are used to provide information about the page to the browser about the page and its contents. -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/style.css" />

    <!--Additional Login Styling - Background image and Forgot password link colour-->

    <style>
        /* Style the video: 100% width and height to cover the entire window */
        #myVideo {
            position: fixed;
            z-index: -1;

            /*right: 0;
             bottom: 0;
            min-width: 100%;
            min-height: 100%;*/
            filter: opacity(25%);
        }

        @media (min-aspect-ratio: 16/9) {
            #myVideo {
                width: 100%;
                height: auto;
            }
        }

        @media (max-aspect-ratio: 16/9) {
            #myVideo {
                width: auto;
                height: 100%;
            }
        }

        @media (max-width: 767px) {
            #myVideo {
                display: none;
            }

            body {
                background-image: url("images/bg.png");
                background-size: cover;
                background-repeat: no-repeat;
            }
        }

        /* Add some content at the bottom of the video/page */
        .content {
            position: fixed;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: #f1f1f1;
            width: 100%;
            padding: 20px;
        }


        a:link {
            color: #375577;
            background-color: transparent;
            text-decoration: none;
        }

        a:visited {
            color: #375577;
            background-color: transparent;
            text-decoration: none;
        }

        a:hover {
            color: red;
            background-color: transparent;
            text-decoration: underline;
        }

        a:active {
            color: #375577;
            background-color: transparent;
            text-decoration: underline;
        }

        .disclaimer {
            display: none;
        }
    </style>
</head>

<body>
    <div id="main-wrapper">
        <!-- For the background of my login page, I used a video. This is the video tag, which is used to display a video. -->
        <video id="myVideo" poster="images/bg.png" autoplay muted loop> <!-- If the screen ratio is below 16:9, the video will be hidden and the background image will be displayed instead -->
            <source src="images/bgVid.mp4" type="video/mp4"> <!-- Path to the video file -->
        </video>

        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-5">
                        <h2 class="heading-section"></h2>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-10">
                        <div class="wrap d-md-flex">
                            <div class="login-wrap p-4 p-md-5">
                                <div class="d-flex">
                                    <div class="w-100">
                                        <h3 class="mb-2"><b style="color: #375577">Welcome to Source Tech</b></h3> <!-- Welcome message to greet the user -->
                                    </div>
                                </div>

                                <form action="includes/login.inc.php" method="POST" class="signin-form"> <!-- Path to the login.inc.php file (Contains the login handling code) -->

                                    <div class="form-group mb-3">
                                        <label class="label" for="Email">Email</label> <!-- Email label -->
                                        <input type="email" class="form-control" placeholder="john.appleseed@sourcetech.net" required name="email" id="email" maxlength="100" minlength="8" /> <!-- Email input with length checks -->
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="label" for="Password">Password</label> <!-- Password label -->
                                        <div class="position-relative">
                                            <input type="password" class="form-control pr-5" placeholder="Password" required name="password" id="password" maxlength="100" minlength="2" /> <!-- Password input with length checks -->
                                            <span class="position-absolute top-50 translate-middle-y" style="right: 15px; top: 10px;" id="password-toggle">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3">Log in </button> <!-- Login button, the submit name is used to check if the form has been submitted -->
                                    </div>

                                    <div class="form-group d-md-flex">
                                        <div class="w-50 text-left">
                                            <label class="checkbox-wrap checkbox-primary mb-0">Remember Me<input type="checkbox" checked /> <!-- Remember me checkbox, this is a feature for future implementation using cookies -->
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="w-50 text-md-right">
                                            <a href="forgotPassword.php">Forgot Password</a> <!-- When clicked, the user will be redirected to "forgotPassword.php" file -->
                                        </div>

                                    </div>

                                    <?php
                                    //The error codes are set submitted from the user functions.inc.php file.
                                    // If the user has been redirected to this page from the login.inc.php file, display an error message based on the error code.
                                    if (isset($_GET["error"])) { // If the error code is set in the URL
                                        $message = ""; // Initialise the error message variable
                                        switch ($_GET["error"]) { // Switch statement to determine the error message based on the error code
                                            case "emptyinput": // If the error code is "emptyinput"
                                                $message = "Please fill in all fields."; // Set the error message to "Please fill in all fields."
                                                break;
                                            case "incorrectdetails":
                                                $message = "Incorrect details.";
                                                break;
                                            case "failedattempts":
                                                $message = "Too many failed attempts. Please try again later.";
                                                break;
                                            default:
                                                $message = "An error has occurred.";
                                                break;
                                        }

                                        echo "<div class='error-message'>" . $message . "</div>";
                                    }
                                    ?>

                                    <script>
                                        // This script is used to toggle the password visibility when the user clicks on the eye icon.
                                        // When the user clicks on the eye icon, the password will be displayed in plain text.
                                        var passwordToggle = document.getElementById("password-toggle"); // Get the eye icon
                                        var passwordField = document.getElementById("password"); // Get the password input
                                        passwordToggle.addEventListener("click", function() { // When the user clicks on the eye icon
                                            if (passwordField.type === "password") { // If the password input is set to "password"
                                                passwordField.type = "text"; // Set the password input to "text"
                                                passwordToggle.innerHTML = '<i class="fa fa-eye-slash"></i>';
                                            } else {
                                                passwordField.type = "password";
                                                passwordToggle.innerHTML = '<i class="fa fa-eye"></i>';
                                            }
                                        });
                                    </script>

                                </form>

                                <style>
                                    /* This style is used to display the error message */
                                    .error-message {
                                        text-align: center;
                                        color: red;
                                        margin-top: 10px;
                                    }
                                </style>
                            </div>
                            <div class="img" style="background-image: url(images/image.jpg)"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
</body>
</html>