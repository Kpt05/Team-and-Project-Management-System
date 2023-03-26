<?php
//Path: includes\functions.inc.php

//Function to check for empty fields in signup form
function emptyInputSignup(
    $firstName,
    $lastName,
    $gender,
    $DOB,
    $address,
    $accountType,
    $empNo,
    $teams,
    $email,
    $password,
    $confirmPassword
) {
    $result = '';
    if (empty($firstName) || empty($lastName) || empty($gender) || empty($DOB) || empty($address) || empty($accountType) || empty($empNo) || empty($teams) || empty($email) || empty($password) || empty($confirmPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

//Function to check if password and confirm password match
function passwordMatch($password, $confirmPassword)
{
    $result = '';
    if ($password !== $confirmPassword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

//Function to check if email already exists
function emailExists($conn, $email)
{
    $sql = "SELECT * FROM Users WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}

//Function to check if employee number already exists
function empNoExists($conn, $empNo)
{
    $sql = "SELECT * FROM Users WHERE empNo = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}

//Function to check for empty fields in login form 
function emptyInputLogin($email, $password)
{
    $result = '';
    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}





// //Function to login a user
// function loginUser($conn, $email, $password)
// {
//     // Check if the email exists in the database
//     $emailExists = emailExists($conn, $email);

//     if ($emailExists === false) {
//         header("Location: ../index.php?error=incorrectdetails&message=" . urlencode("Incorrect email or password"));
//         exit();
//     } else {
//         // Get the hashed password from the database and verify the password entered by the user
//         $passwordHashed = $emailExists["password"];
//         $checkPassword = password_verify($password, $passwordHashed);

//         if ($checkPassword === false) {
//             // Password is incorrect, increase the failed attempts count and check if the account needs to be locked
//             $failed_attempts = $emailExists["failed_attempts"] + 1;
//             echo $failed_attempts;
//             $last_failed_attempt_time = $emailExists["last_failed_attempt_time"];

//             // Check if the user account needs to be locked
//             if ($failed_attempts >= 3) {

//                 $current_time = new DateTime();

//                 $current_time_str = $current_time->format('Y-m-d H:i:s');

//                 //Create a DateTime object from the string value using createFromFormat
//                 $date = DateTime::createFromFormat('Y-m-d H:i:s', $last_failed_attempt_time);

//                 //Calculate the diffrence in seconds between the current time and the last failed attempt time
//                 $time_diff = $current_time->getTimestamp() - $date->getTimestamp();

//                 //Checking to see if the difference in time for when the user last attempted to log in is greater than 3 minutes (in seconds)
//                 if ($time_diff > 180) {
//                     //  Account is locked, redirect the user to the login page with an error message
//                     header("Location: ../index.php?error=incorrectdetails&failed_attempts=" . $time_diff . "&message=" . urlencode("Too quick test"));
//                 } else {
//                     // Account is no longer locked, reset the failed attempts count
//                     $failed_attempts = 1;
//                     //$last_failed_attempt_time = $current_time_str;
//                 }
//             }

//             // Update the failed attempts count and last failed attempt time in the database
//             $sql = "UPDATE Users SET failed_attempts = ?, last_failed_attempt_time = ? WHERE email = ?";
//             $stmt = mysqli_stmt_init($conn);

//             if (!mysqli_stmt_prepare($stmt, $sql)) {
//                 header("Location: ../index.php?error=sqlerror&message=" . urlencode("An error has occurred."));
//                 exit();
//             }

//             mysqli_stmt_bind_param($stmt, "iss", $failed_attempts, $last_failed_attempt_time, $email);
//             mysqli_stmt_execute($stmt);
//             mysqli_stmt_close($stmt);

//             // Password is incorrect, redirect the user to the login page with an error message
//             header("Location: ../index.php?error=incorrectdetails&failed_attempts=" . $time_diff . "&message=" . urlencode("Incorrect email or password"));
//             exit();
//         }

//         // Password is correct, reset failed attempts count and update last_login_time
//         $failed_attempts = 0;
//         $last_login_time = time();
//         $sql = "UPDATE Users SET failed_attempts = ?, last_failed_attempt_time = NULL, last_login_time = ? WHERE email = ?";
//         $stmt = mysqli_stmt_init($conn);

//         if (!mysqli_stmt_prepare($stmt, $sql)) {
//             header("Location: ../index.php?error=sqlerror&message=" . urlencode("An error has occurred."));
//             exit();
//         }

//         mysqli_stmt_bind_param($stmt, "iss", $failed_attempts, $last_login_time, $email);
//         mysqli_stmt_execute($stmt);
//         mysqli_stmt_close($stmt);

//         // Start the user session and redirect the user to the dashboard
//         session_start();
//         $_SESSION["empNo"] = $emailExists["empNo"];
//         $_SESSION["email"] = $emailExists["email"];
//         $_SESSION["accountType"] = $emailExists["accountType"];

//         header("Location: ../Dashboard.php");
//         exit();
//     }
// }



















// Function to create a new User
function createUser($conn, $firstName, $middleName, $lastName, $gender, $DOB, $phoneNumber, $address, $accountType, $empNo, $teams, $email, $password)
{
    $conn->begin_transaction();
    $sql = "INSERT INTO Users (firstName, middleName, lastName, gender, DOB, phoneNumber, address, accountType, empNo, teams, email, password) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
        $error = "SQL statement failed: " . $conn->error;
        $conn->rollback();
        header("Location: ../system_users/CreateSystemUser.php?error=" . $error);
        exit();
    } else {
        //Hash password 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters based on whether middleName and phoneNumber are null or not
        switch (true) {
            case $middleName !== null && $phoneNumber !== null:
                $stmt->bind_param("ssssssssssss", $firstName, $middleName, $lastName, $gender, $DOB, $phoneNumber, $address, $accountType, $empNo, $teams, $email, $hashedPassword);
                break;
            case $middleName === null && $phoneNumber !== null:
                $stmt->bind_param("sssssssssss", $firstName, null, $lastName, $gender, $DOB, $phoneNumber, $address, $accountType, $empNo, $teams, $email, $hashedPassword);
                break;
            case $middleName !== null && $phoneNumber === null:
                $stmt->bind_param("sssssssssss", $firstName, $middleName, $lastName, $gender, $DOB, null, $address, $accountType, $empNo, $teams, $email, $hashedPassword);
                break;
            default:
                $stmt->bind_param("ssssssssss", $firstName, null, $lastName, $gender, $DOB, null, $address, $accountType, $empNo, $teams, $email, $hashedPassword);
        }

        if (!$stmt->execute()) {
            $error = "Error executing statement: " . $stmt->error;
            $conn->rollback();
            header("Location: ../system_users/CreateSystemUser.php?error=" . $error);
            exit();
        } else {
            $conn->commit();
            header("Location: ../system_users/viewSystemUsers.php"); //Redirect to System User View page
            exit();
        }
    }
}

function getFirstName($conn, $empNo)
{
    $sql = "SELECT firstName FROM Users WHERE empNo = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['firstName'];
    } else {
        $result = false;
        return $result;
    }
}


function getLastName($conn, $empNo)
{
    $sql = "SELECT lastName FROM Users WHERE empNo = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['lastName'];
    } else {
        $result = false;
        return $result;
    }
}

function getAccountType($conn, $empNo)
{
    $sql = "SELECT accountType FROM Users WHERE empNo = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['accountType'];
    } else {
        $result = false;
        return $result;
    }
}

function deleteUser($conn, $empNo)
{
    $conn->begin_transaction();
    $sql = "DELETE FROM Users WHERE empNo=?";
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
        $error = "SQL statement failed: " . $conn->error;
        $conn->rollback();
        header("Location: ../dashboard.php?error=" . $error);
        exit();
    } else {
        $stmt->bind_param("s", $empNo);
        if (!$stmt->execute()) {
            $error = "Error executing statement: " . $stmt->error;
            $conn->rollback();
            header("Location: ../dashboard.php?error=" . $error);
            exit();
        } else {
            $conn->commit();
            header("Location: ../dashboard.php"); //Redirect to dashboard
            exit();
        }
    }
}
