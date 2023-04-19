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
        echo "Error: Empty input<br>";
        exit();
    }

    // Function call to login user
    $login_result = login($conn, $email, $password);
    if ($login_result === true) {
        header("Location: ../Dashboard.php");
        exit();
    } else {
        echo "Error: " . $login_result . "<br>";
    }
}
