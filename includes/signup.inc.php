<?php
// Path: includes\signup.inc.php

require('functions.inc.php');
$conn = require __DIR__ . '/dbconfig.php';

//Variables
$empNo = $_POST['empNo'];
$accountType = $_POST['accountType'];
$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
$gender = $_POST['gender'];
$DOB = date('Y-m-d', strtotime($_POST['DOB']));
$phoneNumber = $_POST['phoneNumber'];
$address = $_POST['address'];
$teams = $_POST['teams'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

//Check if submit button is clicked
if (isset($_POST['submit'])) {

    //Function call to check for empty fields
    if (emptyInputSignup($firstName, $lastName, $gender, $DOB, $address, $accountType, $empNo, $teams, $email, $password, $confirmPassword) !== false) {
        header(
            "Location: ../system_users/createSystemUser.php?error=emptyinput&message=" . urlencode("Please fill in all the required fields.")
        );
        exit();
    }

    //Function call to check if password and confirm password match
    if (
        passwordMatch($password, $confirmPassword) !== false
    ) {
        header("Location: ../system_users/createSystemUser.php?error=passwordsdontmatch&message=" . urlencode("Passwords do not match."));
        exit();
    }

    //Function call to check if email already exists
    if (emailExists($conn, $email) !== false) {
        header("Location: ../system_users/createSystemUser.php?error=emailalreadyexists&message=" . urlencode("Email already exists."));
        exit();
    }

    //Function call to check if employee number already exists
    if (empNoExists($conn, $empNo) !== false) {
        header("Location: ../system_users/createSystemUser.php?error=useralreadyexists&message=" . urlencode("User already exists."));
        exit();
    }

    //Create a system user
    createUser($conn, $firstName, $middleName, $lastName, $gender, $DOB, $phoneNumber, $address, $accountType, $empNo, $teams, $email, $password);
    exit();
}
