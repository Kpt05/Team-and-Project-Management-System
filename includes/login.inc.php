<?php
// Path: includes\login.inc.php

require('functions.inc.php');
require('authentication.inc.php');

// Variables
$email = $_POST['email'];
$password = $_POST['password'];

if (isset($_POST["submit"])) {
    $conn = require __DIR__ . '/dbconfig.php';

    // Function call to check for empty fields
    if (emptyInputLogin($email, $password) !== false) {
        header("Location: ../index.php?error=emptyinput");
        exit();
    }

    // Function call to login user
    if (login($conn, $email, $password)) {
        header("Location: ../Dashboard.php");
        exit();
    }
}
