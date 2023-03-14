<?php
// Path: includes\login.inc.php

require('functions.inc.php');

//Variables
$email = $_POST['email'];
$password = $_POST['password'];

if (isset($_POST["submit"])) {

    $conn = require __DIR__ . '/dbconfig.php';

    //Function call to check for empty fields

    if (emptyInputLogin($email, $password) !== false) {
        header("Location: ../index.php?error=emptyinput&message=" . urlencode("Please fill all fields"));
        exit();
    }

    //Function call to login user

    loginUser($conn, $email, $password);
} else {
    header("Location: ../index.php?error=incorrectdetails&message=" . urlencode("Incorrect email or password"));
    exit();
}
