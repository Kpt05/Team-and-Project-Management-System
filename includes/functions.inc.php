<?php
//Path: includes\functions.inc.php

//Function to check for empty fields in Create User form
// If any of the variables are empty, then the function will return true. and a message will be displayed to the user.
function emptyInputSignup( // The following variables are passed into the function.
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
    $result = ''; // If the result is empty, then the function will return true. which will be used to check if the form is empty.
    if (empty($firstName) || empty($lastName) || empty($gender) || empty($DOB) || empty($address) || empty($accountType) || empty($empNo) || empty($teams) || empty($email) || empty($password) || empty($confirmPassword)) { // If any of the variables are empty, then the function will return true.
        $result = true;
    } else {
        $result = false; // If all of the variables are not empty, then the function will return false.
    }
    return $result; // Returns the result of the function.
}


//Function to check for empty fields in signup form
// If any of the variables are empty, then the function will return true. and a message will be displayed to the user.
function emptyInputTeam( // The following variables are passed into the function.
    $teamName,
    $teamDescription,
    $teamID,
    $teamLead
) {
    $result = '';  // If the result is empty, then the function will return true. which will be used to check if the form is empty.
    if (empty($teamName) || empty($teamDescription) || empty($teamID) || empty($teamLead)) {
        $result = true; // If any of the variables are empty, then the function will return true.
    } else {
        $result = false; // If all of the variables are not empty, then the function will return false.
    }
    return $result; // Returns the result of the function.
}


//Function to check if password and confirm password match on the create user form
function passwordMatch($password, $confirmPassword) // The following variables are passed into the function.
{
    $result = ''; // If the result is empty, then the function will return true. which will be used to check if the form is empty.
    if ($password !== $confirmPassword) { // the password and confirm password variables are compared. If they are not the same, then the function will return true.
        $result = true; // If true, then the user will be redirected to the signup page, and a message will be displayed to the user.
    } else {
        $result = false;
    }
    return $result;
}


//Function to check if email already exists
//Before a user is created, the function will check if the email already exists in the database, if one already exists, then the user will be redirected to the signup page, and a message will be displayed to the user.
function emailExists($conn, $email) // The following variables are passed into the function. The connection variable, and the email variable.
{
    $sql = "SELECT * FROM Users WHERE email = ?;"; // The sql statement is created, and the email variable is passed into the statement.
    $stmt = mysqli_stmt_init($conn); // The statement is initialised, and the connection variable is passed into the statement and executed.
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email); // If the statement is prepared, then the email variable is bound to the statement. The s is the data type, and s is for string.
    mysqli_stmt_execute($stmt); // The statement is executed.

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the resultData variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the resultData variable is not empty, then the function will return true. Which means that the email already exists in the database.
        return $row; // If true, then the user will be redirected to the signup page, and a message will be displayed to the user.
    } else {
        $result = false; // If the resultData variable is empty, then the function will return false. Which means that the email does not exist in the database.
        return $result;
    }
}

//Function to check if employee number already exists
//Before a user is created, the function will check if the employee number already exists in the database, if one already exists, then the user will be redirected to the signup page, and a message will be displayed to the user.
function empNoExists($conn, $empNo) // The following variables are passed into the function. The connection variable, and the employee number variable.
{
    $sql = "SELECT * FROM Users WHERE empNo = ?;"; // The sql statement is created, and the employee number variable is passed into the statement.
    $stmt = mysqli_stmt_init($conn); // The statement is initialised, and the connection variable is passed into the statement and executed.
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the signup page, and a message will be displayed to the user.
        header("Location: ../signup.php?error=stmtfailed"); // If true, then the user will be redirected to the signup page, and a message will be displayed to the user. The urlencoded error message will be displayed to the user.
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo); // If the statement is prepared, then the employee number variable is bound to the statement. The s is the data type, and s is for string.
    mysqli_stmt_execute($stmt); // The statement is executed.

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the resultData variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the resultData variable is not empty, then the function will return true. Which means that the employee number already exists in the database.
        return $row; // If true, then the user will be redirected to the signup page, and a message will be displayed to the user. THis means that the employee number already exists in the database.
    } else {
        $result = false; // If the resultData variable is empty, then the function will return false. Which means that the employee number does not exist in the database and the account is able to be created
        return $result;
    }
}

//Function to check if team name already exists
// This is called on the crate team page, and the edit team page. If the team name already exists, then the user will be redirected to the create team page, and a message will be displayed to the user.
function teamNameExists ($conn, $teamName) // The following variables are passed into the function. The connection variable, and the team name variable.
{
    $sql = "SELECT * FROM Teams WHERE teamName = ?;"; // The sql statement is created, and the team name variable is passed into the statement.
    $stmt = mysqli_stmt_init($conn); // The statement is initialised, and the connection variable is passed into the statement and executed.
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the create team page, and a message will be displayed to the user.
        header("Location: ../teams/viewTeam.php?error=stmtfailed"); // If true, then the user will be redirected to the create team page, and a message will be displayed to the user. The urlencoded error message will be displayed to the user.
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $teamName); // If the statement is prepared, then the team name variable is bound to the statement. The s is the data type, and s is for string.
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the resultData variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the resultData variable is not empty, then the function will return true. Which means that the team name already exists in the database.
        return $row; // If true, then the user will be redirected to the create team page, and a message will be displayed to the user. This means that the team name already exists in the database.
    } else {
        $result = false; // If the resultData variable is empty, then the function will return false. Which means that the team name does not exist in the database and the team is able to be created.
        return $result; // If false, then the user will be redirected to the create team page, and a message will be displayed to the user.
    }
}


//Function to check if teamID already exists
// This is called on the edit team page. If the teamID already exists, then the user will be redirected to the edit team page, and a message will be displayed to the user.
function teamIDExists ($conn, $teamID) // The following variables are passed into the function. The connection variable, and the team ID variable.
{
    $sql = "SELECT * FROM Teams WHERE teamID = ?;"; // The sql statement is created, and the team ID variable is passed into the statement.
    $stmt = mysqli_stmt_init($conn); // The statement is initialised, and the connection variable is passed into the statement and executed.
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the edit team page, and a message will be displayed to the user.
        header("Location: ../teams/viewTeam.php?error=stmtfailed"); // If true, then the user will be redirected to the edit team page, and a message will be displayed to the user. The urlencoded error message will be displayed to the user.
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $teamID); // If the statement is prepared, then the team ID variable is bound to the statement. The s is the data type, and s is for string.
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the resultData variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the resultData variable is not empty, then the function will return true. Which means that the team ID already exists in the database.
        return $row; // If true, then the user will be redirected to the edit team page, and a message will be displayed to the user. This means that the team ID already exists in the database.
    } else {
        $result = false; // If the resultData variable is empty, then the function will return false. Which means that the team ID does not exist in the database and the team is able to be created.
        return $result;
    }
}


//Function to check if projectName already exists
// This is called on the create project page. If the project name already exists, then the user will be redirected to the create project page, and a message will be displayed to the user.
function projectNameExists ($conn, $projectName) // The following variables are passed into the function. The connection variable, and the project name variable.
{
    $sql = "SELECT * FROM Projects WHERE projectName = ?;"; // The sql statement is created, and the project name variable is passed into the statement.
    $stmt = mysqli_stmt_init($conn); // The statement is initialised, and the connection variable is passed into the statement and executed.
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the create project page, and a message will be displayed to the user.
        header("Location: ../projects/viewProjects.php?error=stmtfailed"); // If true, then the user will be redirected to the create project page, and a message will be displayed to the user. The urlencoded error message will be displayed to the user.
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $projectName); // If the statement is prepared, then the project name variable is bound to the statement. The s is the data type, and s is for string.
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the resultData variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the resultData variable is not empty, then the function will return true. Which means that the project name already exists in the database.
        return $row; // If true, then the user will be redirected to the create project page, and a message will be displayed to the user. This means that the project name already exists in the database.
    } else {
        $result = false; // If the resultData variable is empty, then the function will return false. Which means that the project name does not exist in the database and the project is able to be created.
        return $result; // If false, then the user will be redirected to the create project page, and a message will be displayed to the user.
    }
}




//Function to check if projectID already exists
// This is called on the edit project page. If the projectID already exists, then the user will be redirected to the edit project page, and a message will be displayed to the user.
function projectIDExists ($conn, $projectID) // The following variables are passed into the function. The connection variable, and the project ID variable.
{
    $sql = "SELECT * FROM Projects WHERE projectID = ?;"; // The sql statement is created, and the project ID variable is passed into the statement.
    $stmt = mysqli_stmt_init($conn); // The statement is initialised, and the connection variable is passed into the statement and executed.
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the edit project page, and a message will be displayed to the user.
        header("Location: ../projects/viewProjects.php?error=stmtfailed"); // If true, then the user will be redirected to the edit project page, and a message will be displayed to the user. The urlencoded error message will be displayed to the user.
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $projectID); // If the statement is prepared, then the project ID variable is bound to the statement. The s is the data type, and s is for string.
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the resultData variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the resultData variable is not empty, then the function will return true. Which means that the project ID already exists in the database.
        return $row; // If true, then the user will be redirected to the edit project page, and a message will be displayed to the user. This means that the project ID already exists in the database.
    } else {
        $result = false; // If the resultData variable is empty, then the function will return false. Which means that the project ID does not exist in the database and the project is able to be created.
        return $result;
    }
}

//Function to check if there are any empty fields in the create project form
// This is called on the create project page. If there are any empty fields, then the user will be redirected to the create project page, and a message will be displayed to the user.
function emptyInputProject( // The following variables are passed into the function. The project name variable, the project team ID variable, and the project lead variable.
    $projectName,
    $projectTeamID,
    $projectLead
) {
    $result = ''; // The result variable is created, and is set to an empty string.
    if (empty($projectName) || empty($projectTeamID) || empty($projectLead)) { // I use the empty function to check if any of the variables are empty. If any of the variables are empty, then the result variable will be set to true.
        $result = true; // If true, then the user will be redirected to the create project page, and a message will be displayed to the user. THis means that there are empty fields in the create project form and the user will be redirected to the create project page.
    } else {
        $result = false; // If false, then the user will be redirected to the create project page, and a message will be displayed to the user. This means that there are no empty fields in the create project form and the project will be created.
    }
    return $result;
}


//Function to check for empty fields in login form 
function emptyInputLogin($email, $password) // The following variables are passed into the function. The email variable, and the password variable.
{
    $result = ''; // The result variable is created, and is set to an empty string.
    if (empty($email) || empty($password)) { // I use the empty function to check if any of the variables are empty. If any of the variables are empty, then the result variable will be set to true.
        $result = true; // If true, then the user will be redirected to the login page, and a message will be displayed to the user. THis means that there are empty fields in the login form and the user will be redirected to the login page.
    } else {
        $result = false; // If false, then the user will be redirected to the login page, and a message will be displayed to the user. This means that there are no empty fields in the login form and the user will be logged in.
    }
    return $result; // If true, then the user will be redirected to the login page, and a message will be displayed to the user. If false, then the user will be redirected to the login page, and a message will be displayed to the user.
}




// Function to create a new User
// This is called on the create system user page. If the user is created successfully, then the user will be redirected to the create system user page, and a message will be displayed to the user.
function createUser($conn, $firstName, $middleName, $lastName, $gender, $DOB, $phoneNumber, $address, $accountType, $empNo, $teams, $email, $password) 
{
    try {
        $conn->begin_transaction();
        $sql = "INSERT INTO Users (firstName, middleName, lastName, gender, DOB, phoneNumber, address, accountType, empNo, teams, email, password) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->stmt_init();
        if (!$stmt->prepare($sql)) {
            throw new Exception("SQL statement failed: " . $conn->error);
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
                throw new Exception("Error executing statement: " . $stmt->error);
            } else {
                $conn->commit();
                header("Location: ../system_users/viewSystemUsers.php"); //Redirect to System User View page
                exit();
            }
        }
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: ../system_users/CreateSystemUser.php?error=" . $e->getMessage());
        exit();
    }
}


// Function to create a new Team
// This is called on the create team page. If the team is created successfully, then the user will be redirected to the create team page, and a message will be displayed to the user.
function createTeam($conn, $teamID ,$teamName, $teamDescription, $department, $teamLeadID, $teamLead ) // The following variables are passed into the function. The team ID variable, the team name variable, the team description variable, the department variable, the team lead ID variable, and the team lead variable.
{
    $conn->begin_transaction(); // The connection to the database is started. This is used to create a transaction in the database when a new team is created.
    $sql = "INSERT INTO Teams (teamID, teamName, teamDescription, department, teamLeadID, teamLead)
    VALUES (?, ?, ?, ?, ?, ?)";  // The SQL statement is created. This is used to insert the new team into the database, the values are passed into the statement using the bind_param function.
    $stmt = $conn->stmt_init(); // The statement is initialised.
    if (!$stmt->prepare($sql)) {
        $error = "SQL statement failed: " . $conn->error; // If the statement fails, then the user will be redirected to the create team page, and a message will be displayed to the user.
        $conn->rollback(); // The connection to the database is rolled back whcih means that the transaction is cancelled.
        header("Location: ../createTeam.php?error=" . $error); // If there is a rollback, The user will be redirected to the create team page, and a message will be displayed to the user through the URL.
        exit();
    } else {
        // Bind parameters
        $stmt->bind_param("ssssis", $teamID, $teamName, $teamDescription, $department, $teamLeadID, $teamLead); // The parameters are bound to the statement. The parameters are the team ID, the team name, the team description, the department, the team lead ID, and the team lead.

        if (!$stmt->execute()) { // If the statement fails to execute, then the user will be redirected to the create team page, and a message will be displayed to the user.
            $error = "Error executing statement: " . $stmt->error; // If the statement fails to execute, then the user will be redirected to the create team page, and a message will be displayed to the user.
            $conn->rollback();
            header("Location: ../createTeam.php?error=" . $error); // If there is a rollback, The user will be redirected to the create team page, and a message will be displayed to the user through the URL.
            exit(); // The script will exit and the user will not be able to continue.
        } else {
            $conn->commit();
            header("Location: ../teams/viewTeam.php"); //Redirect to Team View page on successful creation of a new team.
            exit();
        }
    }
}


// Function to create a new Project
// This is called on the create project page. If the project is created successfully, then the user will be redirected to the create project page, and a message will be displayed to the user.
function createProject($conn, $projectID, $projectName, $projectDescription, $priorityLevel, $projectStatus, $projectTeamID, $projectLeadID) // The following variables are passed into the function. The project ID variable, the project name variable, the project description variable, the priority level variable, the project status variable, the project team ID variable, and the project lead ID variable.
{
    $conn->begin_transaction(); // The connection to the database is started. This is used to create a transaction in the database when a new project is created.
    $sql = "INSERT INTO Projects (projectID, projectName, projectDescription, priorityLevel, projectStatus, projectTeamID, projectLeadID)
    VALUES (?, ?, ?, ?, ?, ?, ?)"; // The SQL statement is created. This is used to insert the new project into the database, the values are passed into the statement using the bind_param function.
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) { // If the statement fails, then the user will be redirected to the create project page, and a message will be displayed to the user.
        $error = "SQL statement failed: " . $conn->error; // If the statement fails, then the user will be redirected to the create project page, and a message will be displayed to the user. This is a form of error handling.
        $conn->rollback(); // The connection to the database is rolled back whcih means that the transaction is cancelled.
        header("Location: ../createProjects.php?error=" . $error);  // If there is a rollback, The user will be redirected to the create project page, and a message will be displayed to the user through the URL.
        exit();
    } else { // If the statement is successful, then the user will be redirected to the create project page, and a message will be displayed to the user and the project will be created.
        // Bind parameters
        $stmt->bind_param("ssssssi", $projectID, $projectName, $projectDescription, $priorityLevel, $projectStatus, $projectTeamID, $projectLeadID); // The parameters are bound to the statement. The parameters are the project ID, the project name, the project description, the priority level, the project status, the project team ID, and the project lead ID.

        if (!$stmt->execute()) { // If the statement fails to execute, then the user will be redirected to the create project page, and a message will be displayed to the user.
            $error = "Error executing statement: " . $stmt->error; // If the statement fails to execute, then the user will be redirected to the create project page, and a message will be displayed to the user.
            $conn->rollback();
            header("Location: ../projects/createProjects.php?error=" . $error); // If there is a rollback, The user will be redirected to the create project page, and a message will be displayed to the user through the URL.
            exit();
        } else {
            $conn->commit(); // The connection to the database is committed. This means that the transaction is completed.
            header("Location: ../projects/viewProjects.php"); //Redirect to Project View page
            exit(); // The script will exit and the user will not be able to continue.
        }
    }
}


// This function updates the user's report in the database with the provided task completion and hours worked data. It either updates an existing record
// or creates a new one if the user does not have a report yet.
function updateUserReport($conn, $userID, $tasksCompleted, $hoursWorked, $tasksAssigned) // The following variables are passed into the function. The user ID variable, the tasks completed variable, the hours worked variable, and the tasks assigned variable.
{
    $conn->begin_transaction(); // The connection to the database is started. This is used to create a transaction in the database when a new project is created.

    // Check if record with userID already exists
    $sql = "SELECT * FROM Reports WHERE userID = ?"; // The SQL statement is created. This is used to select the user ID from the reports table in the database.
    $stmt = $conn->stmt_init(); // The statement is initialised.
    if (!$stmt->prepare($sql)) { // If the statement fails, then the user will be redirected to the user performance page, and a message will be displayed to the user.
        $error = "SQL statement failed: " . $conn->error; // If the statement fails, then the user will be redirected to the user performance page, and a message will be displayed to the user. This is a form of error handling.
        $conn->rollback(); // The connection to the database is rolled back whcih means that the transaction is cancelled.
        header("Location: ../system_users/userPerformance.php?status=error&message=" . urlencode($error)); // If there is a rollback, The user will be redirected to the user performance page, and a message will be displayed to the user through the URL.
        exit();
    } else { // If the statement is successful, then the user will be redirected to the user performance page, and a message will be displayed to the user and the project will be created.
        // Bind parameters
        $stmt->bind_param("i", $userID); // The parameters are bound to the statement. The parameters are the user ID. This is used to select the user ID from the reports table in the database and update the report.
        $stmt->execute(); // The statement is executed.
        $result = $stmt->get_result(); // The result of the statement is stored in the result variable.
        if ($result->num_rows > 0) { // If the result is greater than 0, then the user will be redirected to the user performance page, and a message will be displayed to the user.
            // Update existing record
            $row = $result->fetch_assoc(); // The result is fetched as an associative array.
            $tasksCompleted += $row['tasksCompleted']; // The tasks completed variable is incremented by the tasks completed variable.
            $hoursWorked += $row['hoursWorked']; // The hours worked variable is incremented by the hours worked variable.
            $tasksAssigned += $row['tasksAssigned']; // The tasks assigned variable is incremented by the tasks assigned variable.

            $sql = "UPDATE Reports SET tasksCompleted = ?, hoursWorked = ?, tasksAssigned = ? WHERE userID = ?"; // The SQL statement is created. This is used to update the tasks completed, the hours worked, and the tasks assigned in the reports table in the database.
            $stmt = $conn->stmt_init(); // The statement is initialised.
            if (!$stmt->prepare($sql)) {
                $error = "SQL statement failed: " . $conn->error; // If the statement fails, then the user will be redirected to the user performance page, and a message will be displayed to the user. This is a form of error handling.
                $conn->rollback(); // The connection to the database is rolled back whcih means that the transaction is cancelled.
                header("Location: ../system_users/userPerformance.php?status=error&message=" . urlencode($error)); // If there is a rollback, The user will be redirected to the user performance page, and a message will be displayed to the user through the URL.
                exit();
            } else { // If the statement is successful, then the user will be redirected to the user performance page, and a message will be displayed to the user and the project will be created.
                // Bind parameters
                $stmt->bind_param("iiii", $tasksCompleted, $hoursWorked, $tasksAssigned, $userID); // The parameters are bound to the statement. The parameters are the tasks completed, the hours worked, the tasks assigned, and the user ID. This is used to update the tasks completed, the hours worked, and the tasks assigned in the reports table in the database.
            }
        } else {
            // Insert new record
            $sql = "INSERT INTO Reports (userID, tasksCompleted, hoursWorked, tasksAssigned) 
                    VALUES (?, ?, ?, ?)"; // The SQL statement is created. This is used to insert the user ID, the tasks completed, the hours worked, and the tasks assigned in the reports table in the database.
            $stmt = $conn->stmt_init(); // The statement is initialised.
            if (!$stmt->prepare($sql)) { // If the statement fails, then the user will be redirected to the user performance page, and a message will be displayed to the user.
                $error = "SQL statement failed: " . $conn->error; // If the statement fails, then the user will be redirected to the user performance page, and a message will be displayed to the user. This is a form of error handling.
                $conn->rollback(); // The connection to the database is rolled back whcih means that the transaction is cancelled.
                header("Location: ../system_users/userPerformance.php?status=error&message=" . urlencode($error)); // If there is a rollback, The user will be redirected to the user performance page, and a message will be displayed to the user through the URL.
                exit();
            } else { // If the statement is successful, then the user will be redirected to the user performance page, and a message will be displayed to the user and the project will be created.
                // Bind parameters
                $stmt->bind_param("iiii", $userID, $tasksCompleted, $hoursWorked, $tasksAssigned); // The parameters are bound to the statement. The parameters are the user ID, the tasks completed, the hours worked, and the tasks assigned. This is used to insert the user ID, the tasks completed, the hours worked, and the tasks assigned in the reports table in the database.
            }
        }

        // Execute statement and handle errors
        if (!$stmt->execute()) {
            $error = "Error executing statement: " . $stmt->error; // If the statement fails, then the user will be redirected to the user performance page, and a message will be displayed to the user. This is a form of error handling.
            $conn->rollback(); // The connection to the database is rolled back whcih means that the transaction is cancelled.
            header("Location: ../system_users/userPerformance.php?status=error&message=" . urlencode($error)); // If there is a rollback, The user will be redirected to the user performance page, and a message will be displayed to the user through the URL.
            exit();
        } else { // If the statement is successful, then the user will be redirected to the user performance page, and a message will be displayed to the user and the project will be created.
            $conn->commit();
            header("Location: ../system_users/userPerformance.php?status=success"); // If there is a commit, The user will be redirected to the user performance page, and a message will be displayed to the user through the URL.
            exit();
        }
    }
}

// This is the function that is used to create a password reset request.
// This function is called in the forgotPassword.php file.
function createPasswordResetRequest($conn, $email) // The connection to the database is passed through the function, and the email is passed through the function.
{
    // Get UserID associated with the email from Users table
    $stmt = $conn->prepare("SELECT UserID FROM Users WHERE email = ?"); // The SQL statement is created. This is used to select the user ID from the users table in the database.
    $stmt->bind_param("s", $email); // The parameters are bound to the statement. The parameters are the email. This is used to select the user ID from the users table in the database.
    $stmt->execute(); // The statement is executed.
    $result = $stmt->get_result(); // The result of the statement is stored in the result variable.
    if ($result->num_rows > 0) { // If the number of rows in the result is greater than 0, then the user will be redirected to the reset password page, and a message will be displayed to the user.
        $row = $result->fetch_assoc(); // The result is fetched as an associative array.
        $userID = $row['UserID']; // The user ID is stored in the user ID variable.

        // iF the user ID is not null, then the user will be redirected to the reset password page, and a message will be displayed to the user.
        //If the user ID is found in the users table, then the user will be redirected to the reset password page, and a message will be displayed to the user.
        // Insert password reset request into Approvals table
        $requestType = "Password Reset Request"; // The request type is stored in the request type variable.
        $isActive = 1; // 1 for active, 0 for inactive // The is active variable is set to 1.
        $stmt = $conn->prepare("INSERT INTO Approvals (userID, email, requestType, is_active) VALUES (?, ?, ?, ?)"); // The SQL statement is created. This is used to insert the user ID, the email, the request type, and the is active in the approvals table in the database.
        $stmt->bind_param("isss", $userID, $email, $requestType, $isActive); // The parameters are bound to the statement. The parameters are the user ID, the email, the request type, and the is active. This is used to insert the user ID, the email, the request type, and the is active in the approvals table in the database.

        if ($stmt->execute()) { // If the statement is successful, then the user will be redirected to the reset password page, and a message will be displayed to the user.
            // Password reset request created successfully 
            header("Location: resetPassword.php?success=" . urlencode("passwordrequestsent")); // If the statement is successful, then the user will be redirected to the reset password page, and a message will be displayed to the user through the URL.
            exit();
        } else {
            // Failed to create password reset request
            header("Location: resetPassword.php?error=" . urlencode("failedpasswordresetrequest")); // If the statement fails, then the user will be redirected to the reset password page, and a message will be displayed to the user through the URL.
            exit();
        }
    } else {
        // Email not found in Users table
        header("Location: resetPassword.php?error=" . urlencode("emailnotfound")); // If the email is not found in the users table, then the user will be redirected to the reset password page, and a message will be displayed to the user through the URL.
        exit();
    }
}


// This function is used for the session variables and retrieveing the current logged in user's information.
function getFirstName($conn, $empNo) // The connection to the database is passed through the function, and the employee number is passed through the function.
{
    $sql = "SELECT firstName FROM Users WHERE empNo = ?;"; // The SQL statement is created. This is used to select the first name from the users table in the database.
    $stmt = mysqli_stmt_init($conn); // The statement is initialized.
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the index page, and a message will be displayed to the user.
        header("Location: ../index.php?error=stmtfailed"); // If the statement is not prepared, then the user will be redirected to the index page, and a message will be displayed to the user through the URL.
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo); // The parameters are bound to the statement. The parameters are the employee number. This is used to select the first name from the users table in the database.
    mysqli_stmt_execute($stmt); // The statement is executed.

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the result data variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the row is fetched as an associative array, then the first name is returned.
        return $row['firstName'];
    } else {
        $result = false; // The result is set to false.
        return $result; // The result is returned.
    }
}

// This function is used for the session variables and retrieveing the current logged in user's information.
function getLastName($conn, $empNo) // The connection to the database is passed through the function, and the employee number is passed through the function.
{
    $sql = "SELECT lastName FROM Users WHERE empNo = ?;"; // The SQL statement is created. This is used to select the last name from the users table in the database.
    $stmt = mysqli_stmt_init($conn); // The statement is initialized.
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the index page, and a message will be displayed to the user.
        header("Location: ../index.php?error=stmtfailed"); // If the statement is not prepared, then the user will be redirected to the index page, and a message will be displayed to the user through the URL.
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo); // The parameters are bound to the statement. The parameters are the employee number. This is used to select the last name from the users table in the database.
    mysqli_stmt_execute($stmt); // The statement is executed.

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the result data variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the row is fetched as an associative array, then the last name is returned.
        return $row['lastName'];
    } else {
        $result = false; // The result is set to false.
        return $result; // The result is returned.
    }
}


// This function is used for the session variables and retrieveing the current logged in user's information.
// This functon is essential, as depending on their account type, the user will be redirected to a dashboard page.
function getAccountType($conn, $empNo) // The connection to the database is passed through the function, and the employee number is passed through the function.
{
    $sql = "SELECT accountType FROM Users WHERE empNo = ?;"; // The SQL statement is created. This is used to select the account type from the users table in the database.
    $stmt = mysqli_stmt_init($conn); // The statement is initialized and stored in the stmt variable.
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the index page, and a message will be displayed to the user.
        header("Location: ../index.php?error=stmtfailed"); // If the statement is not prepared, then the user will be redirected to the index page, and a message will be displayed to the user through the URL.
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo); // The parameters are bound to the statement. The parameters are the employee number. This is used to select the account type from the users table in the database.
    mysqli_stmt_execute($stmt); // The statement is executed and stored in the stmt variable.

    $resultData = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the result data variable.

    if ($row = mysqli_fetch_assoc($resultData)) { // If the row is fetched as an associative array, then the account type is returned.
        return $row['accountType']; // The account type is returned.
    } else {
        $result = false; // The result is set to false which means that the account type was not found.
        return $result; // The result is returned.
    }
}

// This function is used for the session variables and retrieveing the current logged in user's information.
// Specifically the user Id is retrieved.
function getUserID($conn, $empNo) { // The connection to the database is passed through the function, and the employee number is passed through the function.
    $sql = "SELECT UserID FROM Users WHERE empNo = ?"; // The SQL statement is created. This is used to select the user ID from the users table in the database.
    $stmt = mysqli_stmt_init($conn); // The statement is initialized and stored in the stmt variable.
    
    if (!mysqli_stmt_prepare($stmt, $sql)) { // If the statement is not prepared, then the user will be redirected to the index page, and a message will be displayed to the user.
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, "s", $empNo); // The parameters are bound to the statement. The parameters are the employee number. This is used to select the user ID from the users table in the database.
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt); // The result of the statement is stored in the result data variable If the row is fetched as an associative array, then the user ID is returned.
    $row = mysqli_fetch_assoc($result); // The row is fetched as an associative array.
    
    return $row['UserID']; // The user ID is returned.
}


function getTeamID($conn, $userId) {
    $sql = "SELECT teams FROM Users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['teams'];
    }
    return null;
}









// Thsi function is used on the Reports page to retrieve the reports data.
function getReportsData($conn, $userID) { // The connection to the database is passed through the function, and the user ID is passed through the function. This means the report data is specific to the logged in user.
    $sql = "SELECT reportID, tasksCompleted, tasksAssigned, hoursWorked FROM Reports WHERE userID = ?"; // The SQL statement is created. This is used to select the report ID, tasks completed, tasks assigned and hours worked from the reports table in the database.
    $stmt = $conn->prepare($sql); // The statement is initialized and stored in the stmt variable.
    $stmt->bind_param('i', $userID); // The parameters are bound to the statement. The parameters are the user ID. This is used to select the report ID, tasks completed, tasks assigned and hours worked from the reports table in the database.
    $stmt->execute(); // The statement is executed.
    $result = $stmt->get_result(); // The result of the statement is stored in the result data variable.
    $reportsData = $result->fetch_all(MYSQLI_ASSOC); // The result is fetched as an associative array.
    
    return $reportsData; // The reports data is returned.
}

//This funtion is used on the view system users page and is called when the admin wants to delete a user.
function deleteUser($conn, $empNo) // The connection to the database is passed through the function, and the employee number is passed through the function.
{
    $conn->begin_transaction(); // The transaction is started. This is used to delete the user from the users table in the database.
    $sql = "DELETE FROM Users WHERE empNo=?"; // The SQL statement is created. This is used to delete the user from the users table in the database.
    $stmt = $conn->stmt_init(); // The statement is initialized and stored in the stmt variable and the connection to the database is passed through the function.
    if (!$stmt->prepare($sql)) { // If the statement is not prepared, then the user will be redirected to the dashboard page, and a message will be displayed to the user.
        $error = "SQL statement failed: " . $conn->error; // The error message is stored in the error variable. This is used to delete the user from the users table in the database.
        $conn->rollback();
        header("Location: ../dashboard.php?error=" . $error); // If the statement is not prepared, then the user will be redirected to the dashboard page, and a message will be displayed to the user through the URL. This is used to delete the user from the users table in the database.
        exit();
    } else { // If the statement is prepared, then the user will be deleted from the users table in the database. 
        $stmt->bind_param("s", $empNo); // The parameters are bound to the statement. The parameters are the employee number. This is used to delete the user from the users table in the database. The employee number is used to identify the user.
        if (!$stmt->execute()) { // If the statement is not executed, then the user will be redirected to the dashboard page, and a message will be displayed to the user.
            $error = "Error executing statement: " . $stmt->error; // The error message is stored in the error variable. This is used to delete the user from the users table in the database.
            $conn->rollback(); // The transaction is rolled back. This is used to delete the user from the users table in the database.
            header("Location: ../dashboard.php?error=" . $error); // If the statement is not executed, then the user will be redirected to the dashboard page, and a message will be displayed to the user through the URL. This is used to delete the user from the users table in the database.
            exit();
        } else {
            $conn->commit(); // The transaction is committed. This is used to delete the user from the users table in the database.
            header("Location: ../dashboard.php"); //Redirect to dashboard
            exit(); // The script is exited.
        }
    }
}

// This function is used to retrive the user's clocking history for the clocking history page.
// The user's clocking history is retrieved from the clockings table in the database.
function getClockingHistory($conn, $userID) { // The connection to the database is passed through the function, and the user ID is passed through the function. This means the clocking history is specific to the logged in user.
    // Retrieve all clocking records for the user
    $query = "SELECT * FROM clockings WHERE UserID = $userID ORDER BY ClockingsID DESC"; // The SQL statement is created. This is used to select all clocking records for the user from the clockings table in the database. The SQL Query is ordered by the clocking ID in descending order. This means the most recent clocking is displayed first.
    $result = mysqli_query($conn, $query); // The result of the query is stored in the result data variable. The connection to the database is passed through the function, and the query is passed through the function.

    $clockings = array(); // Initialize an empty array to hold the clockings
    if (mysqli_num_rows($result) > 0) { // If the number of rows in the result is greater than 0, then the clockings are added to the array.
        while ($row = mysqli_fetch_assoc($result)) { // The row is fetched as an associative array.
            // Add each clocking to the array
            $clocking = array( // The clocking is added to the array.
                "id" => $row["ClockingsID"], // The clocking ID is added to the array.
                "clockInTime" => $row["clockInTime"], // The clock-in time is added to the array.
                "clockOutTime" => $row["clockOutTime"], // The clock-out time is added to the array.
                "breakStartTime" => $row["breakStartTime"], // The break start time is added to the array.
                "breakEndTime" => $row["breakEndTime"], // The break end time is added to the array.
                "hoursWorked" => $row["hoursWorked"], // The hours worked is added to the array.
                "breakDuration" => $row["breakDuration"] // The break duration is added to the array.
            );
            $clockings[] = $clocking; // The clocking is added to the array.
        }
    }
    return $clockings; // The clockings are returned.
}

// This function is used to display the user's clocking history for the clocking history page.
// The user's clocking history is retrieved from the clockings table in the database.
function displayClockingHistory($conn,$userID) { // The connection to the database is passed through the function, and the user ID is passed through the function. This means the clocking history is specific to the logged in user.
    $clockings = getClockingHistory($conn, $userID); // The clocking history is retrieved from the clockings table in the database. The connection to the database is passed through the function, and the user ID is passed through the function. This means the clocking history is specific to the logged in user.

    if (count($clockings) > 0) { // If the number of clockings in the array is greater than 0, then the clocking history is displayed.
        echo "<table>"; // The table is opened.
        echo "<tr><th>Clocking ID</th><th>Clock-In Time</th><th>Clock-Out Time</th><th>Break Start Time</th><th>Break End Time</th><th>Hours Worked</th><th>Break Duration</th></tr>"; // The table headings are displayed. This is used to display the clocking history for the user.
        foreach ($clockings as $clocking) { // The clockings are looped through.
            echo "<tr><td>" . $clocking["id"] . "</td><td>" . $clocking["clockInTime"] . "</td><td>" . $clocking["clockOutTime"] . "</td><td>" . $clocking["breakStartTime"] . "</td><td>" . $clocking["breakEndTime"] . "</td><td>" . $clocking["hoursWorked"] . "</td><td>" . $clocking["breakDuration"] . "</td></tr>"; // The clocking details are displayed in the table. This is used to display the clocking history for the user.
        }
        echo "</table>";
    } else { // If the number of clockings in the array is not greater than 0, then a message is displayed to the user.
        echo "No clocking history found for this user.";  // A message is displayed to the user. This is used to display the clocking history for the user.
    }
}

// Function to get team members and their tasks completed from Users and Reports table by teamID
// This is used as part of the session variable to display the team members and their tasks completed on the dashboard page
function getUsersByTeamID($conn, $teamID) { // The connection to the database is passed through the function, and the team ID is passed through the function. This means the team members are specific to the logged in user.

    // Query to retrieve team members by teamID
    $query = "SELECT UserID, firstName, lastName FROM Users WHERE FIND_IN_SET('$teamID', teams)"; // The SQL statement is created. This is used to select the user ID, first name and last name from the users table in the database. The SQL Query is ordered by the user ID in descending order. This means the most recent user is displayed first.
    $result = mysqli_query($conn, $query); // The result of the query is stored in the result data variable. The connection to the database is passed through the function, and the query is passed through the function.

    // Fetch the results into an associative array
    $teamMembers = array(); // Initialize an empty array to hold the team members
    while ($row = mysqli_fetch_assoc($result)) { // The row is fetched as an associative array.
        $userID = $row['UserID']; // The user ID is stored in the user ID variable.
        $tasksCompleted = getTasksCompletedByUserID($conn, $userID); // The tasks completed is retrieved from the reports table in the database. The connection to the database is passed through the function, and the user ID is passed through the function. This means the tasks completed is specific to the logged in user.
        $row['tasksCompleted'] = $tasksCompleted; // The tasks completed is added to the array.
        $teamMembers[] = $row; // The team member is added to the array. This is used to display the team members and their tasks completed on the dashboard page
    }

    // Close the database connection
    mysqli_close($conn); // The connection to the database is closed.

    return $teamMembers; // The team members are returned.
}


// Function to get tasksCompleted from Reports table by userID
function getTasksCompletedByUserID($conn, $userID) { // The connection to the database is passed through the function, and the user ID is passed through the function. This means the tasks completed is specific to the logged in user.
    // Query to retrieve tasksCompleted by userID
    $query = "SELECT tasksCompleted FROM Reports WHERE userID = '$userID'"; // The SQL statement is created. This is used to select the tasks completed from the reports table in the database. The SQL Query is ordered by the user ID in descending order. This means the most recent user is displayed first.
    $result = mysqli_query($conn, $query); // The result of the query is stored in the result data variable. The connection to the database is passed through the function, and the query is passed through the function.

    // Fetch the tasksCompleted value
    $row = mysqli_fetch_assoc($result); // The row is fetched as an associative array. This is used to display the team members and their tasks completed on the dashboard page
    $tasksCompleted = $row['tasksCompleted']; // The tasks completed is stored in the tasks completed variable. This is used to display the team members and their tasks completed on the dashboard page

    return $tasksCompleted; // The tasks completed are returned. This is used to display the team members and their tasks completed on the dashboard page
}


// Function to retrieve team name from Teams table using teamID
function getTeamNameByTeamID($conn, $teamID) // The connection to the database is passed through the function, and the team ID is passed through the function. This means the team name is specific to the logged in user.
{
    $query = "SELECT teamName FROM Teams WHERE teamID = ?"; // The SQL statement is created. This is used to select the team name from the teams table in the database. The SQL Query is ordered by the team ID in descending order. This means the most recent team is displayed first.
    $stmt = $conn->prepare($query); // The query is prepared. The connection to the database is passed through the function, and the query is passed through the function.
    $stmt->bind_param("s", $teamID); // The team ID is bound to the query. The team ID is passed through the function.
    $stmt->execute(); // The query is executed.
    $result = $stmt->get_result(); // The result of the query is stored in the result data variable.
    $team = $result->fetch_assoc(); // The team is fetched as an associative array.
    $stmt->close(); // The statement is closed.
    return $team['teamName']; // The team name is returned.
}



