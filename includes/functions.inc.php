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
