<!--Created by Kevin Titus on 2022-07-16.-->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Source Tech Portal</title>

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
        <video id="myVideo" poster="images/bg.png" autoplay muted loop>
            <source src="images/bgVid.mp4" type="video/mp4">
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
                                        <h3 class="mb-2"><b style="color: #375577">Welcome to Source Tech</b></h3>
                                    </div>
                                </div>

                                <form action="includes/login.inc.php" method="POST" class="signin-form">

                                    <div class="form-group mb-3">
                                        <label class="label" for="Email">Email</label>
                                        <input type="email" class="form-control" placeholder="john.appleseed@sourcetech.net" required name="email" id="email" />
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="label" for="Password">Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control pr-5" placeholder="Password" required name="password" id="password" />
                                            <span class="position-absolute top-50 translate-middle-y" style="right: 15px; top: 10px;" id="password-toggle">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3">Log in
                                        </button>
                                    </div>

                                    <div class="form-group d-md-flex">
                                        <div class="w-50 text-left">
                                            <label class="checkbox-wrap checkbox-primary mb-0">Remember Me<input type="checkbox" checked />
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="w-50 text-md-right">
                                            <a href="mailto:forgotpassword.admin@sourcetech.net?subject=Forgot Password ~ Source Tech Login">Forgot Password</a>
                                        </div>
                                    </div>


                                    <!-- Error message
                                    <?php
                                    //Empty input
                                    if (isset($_GET['error']) && $_GET['error'] === "emptyinput") {
                                        $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                        echo "<div class='error-message'>" . htmlspecialchars($message) . "</div>";
                                    }

                                    //Incorrect details
                                    if (isset($_GET['error']) && $_GET['error'] === "incorrectdetails") {
                                        $message = isset($_GET['message']) ? $_GET['message'] : "An error has occurred.";
                                        echo "<div class='error-message'>" . htmlspecialchars($message) . "</div>";
                                    }
                                    ?> -->






                                    <script>
                                        var passwordToggle = document.getElementById("password-toggle");
                                        var passwordField = document.getElementById("password");
                                        passwordToggle.addEventListener("click", function() {
                                            if (passwordField.type === "password") {
                                                passwordField.type = "text";
                                                passwordToggle.innerHTML = '<i class="fa fa-eye-slash"></i>';
                                            } else {
                                                passwordField.type = "password";
                                                passwordToggle.innerHTML = '<i class="fa fa-eye"></i>';
                                            }
                                        });
                                    </script>

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