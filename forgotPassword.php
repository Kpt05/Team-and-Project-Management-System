<!--Created by Kevin Titus on 2022-07-16.-->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Source Tech Portal</title> <!-- Title of the page -->

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
        <video id="myVideo" poster="images/bg.png" autoplay muted loop> <!-- If the screen ratio is below 16:9, the video will be hidden and the background image will be displayed instead -->
            <source src="images/bgVid.mp4" type="video/mp4"> <!-- Path to the video file -->
        </video>

        <section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section" style="margin-top: 1rem;">&nbsp;</h2><!-- Placeholder added here -->
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-2"><b style="color: #375577">Reset Password</b></h3>
                            </div>
                        </div>

                        <form action="includes/signup.inc.php" method="POST" class="passwordresetrequest-form">
                            <div class="form-group mb-3">
                                <label class="label" for="Email">Email</label>
                                <input type="email" class="form-control" placeholder="john.appleseed@sourcetech.net" required name="resetEmail" id="email" />
                            </div>

                            <div class="form-group">
                                <button type="submit" name="resetRequest" class="form-control btn btn-primary rounded submit px-3">Reset Password</button>
                            </div>

                            <?php
                           if (isset($_GET["error"])) {
                            $message = "";
                            switch ($_GET["error"]) {
                                case "emptyinput":
                                    $message = "Please fill in all fields.";
                                    break;
                                case "incorrectdetails":
                                    $message = "Incorrect details.";
                                    break;
                                case "failedattempts":
                                    $message = "Too many failed attempts. Please try again later.";
                                    break;
                                case "emailnotfound":
                                    $message = "Email not found.";
                                    break;
                                case "failedpasswordresetrequest":
                                    $message = "Failed to create password reset request.";
                                    break;
                                default:
                                    $message = "An error has occurred.";
                                    break;
                            }
                            echo "<div class='error-message'>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</div>";
                        } elseif (isset($_GET["success"])) {
                            $successMessage = "";
                            switch ($_GET["success"]) {
                                case "passwordrequestsent":
                                    $successMessage = "Password reset request sent successfully.";
                                    break;
                                default:
                                    $successMessage = "An error has occurred.";
                                    break;
                            }
                            echo "<div class='success-message'>" . htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') . "</div>";
                        }
                        
                            ?>

                            <div class="form-group">
                                <a href="index.php" class="btn btn-secondary rounded submit px-3">Back</a>
                            </div>

                        </form>

                        <style>
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