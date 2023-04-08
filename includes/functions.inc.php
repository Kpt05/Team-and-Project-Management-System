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


//Function to check for empty fields in signup form
function emptyInputTeam(
    $teamName,
    $teamDescription,
    $teamID,
    $teamLead
) {
    $result = '';
    if (empty($teamName) || empty($teamDescription) || empty($teamID) || empty($teamLead)) {
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


//Function to check if team name already exists
function teamNameExists ($conn, $teamName)
{
    $sql = "SELECT * FROM Teams WHERE teamName = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../teams/viewTeam.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $teamName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}


//Function to check if teamID already exists
function teamIDExists ($conn, $teamID)
{
    $sql = "SELECT * FROM Teams WHERE teamID = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../teams/viewTeam.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $teamID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}












//Function to check if projectName already exists
function projectNameExists ($conn, $projectName)
{
    $sql = "SELECT * FROM Projects WHERE projectName = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../projects/viewProjects.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $projectName);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}


//Function to check if projectID already exists
function projectIDExists ($conn, $projectID)
{
    $sql = "SELECT * FROM Projects WHERE projectID = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../projects/viewProjects.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $projectID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}

function emptyInputProject(
    $projectName,
    $projectTeamID,
    $projectLead
) {
    $result = '';
    if (empty($projectName) || empty($projectTeamID) || empty($projectLead)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
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


// Function to create a new Team
function createTeam($conn, $teamID ,$teamName, $teamDescription, $department, $teamLeadID, $teamLead )
{
    $conn->begin_transaction();
    $sql = "INSERT INTO Teams (teamID, teamName, teamDescription, department, teamLeadID, teamLead) 
    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
        $error = "SQL statement failed: " . $conn->error;
        $conn->rollback();
        header("Location: ../createTeam.php?error=" . $error);
        exit();
    } else {
        // Bind parameters
        $stmt->bind_param("ssssis", $teamID, $teamName, $teamDescription, $department, $teamLeadID, $teamLead);

        if (!$stmt->execute()) {
            $error = "Error executing statement: " . $stmt->error;
            $conn->rollback();
            header("Location: ../createTeam.php?error=" . $error);
            exit();
        } else {
            $conn->commit();
            header("Location: ../teams/viewTeam.php"); //Redirect to Team View page
            exit();
        }
    }
}


// Function to create a new Project

function createProject($conn, $projectID, $projectName, $projectDescription, $priorityLevel, $projectStatus, $projectTeamID, $projectLeadID)
{
    $conn->begin_transaction();
    $sql = "INSERT INTO Projects (projectID, projectName, projectDescription, priorityLevel, projectStatus, projectTeamID, projectLeadID)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
        $error = "SQL statement failed: " . $conn->error;
        $conn->rollback();
        header("Location: ../createProjects.php?error=" . $error);
        exit();
    } else {
        // Bind parameters
        $stmt->bind_param("ssssssi", $projectID, $projectName, $projectDescription, $priorityLevel, $projectStatus, $projectTeamID, $projectLeadID);

        if (!$stmt->execute()) {
            $error = "Error executing statement: " . $stmt->error;
            $conn->rollback();
            header("Location: ../projects/createProjects.php?error=" . $error);
            exit();
        } else {
            $conn->commit();
            header("Location: ../projects/viewProjects.php"); //Redirect to Project View page
            exit();
        }
    }
}





function updateUserReport($conn, $userID, $tasksCompleted, $hoursWorked)
{
    $conn->begin_transaction();

    // Check if record with userID already exists
    $sql = "SELECT * FROM Reports WHERE userID = ?";
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
        $error = "SQL statement failed: " . $conn->error;
        $conn->rollback();
        header("Location: ../system_users/userPerformance.php?status=error&message=" . urlencode($error)); // Redirect to index page with error message
        exit();
    } else {
        // Bind parameters
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Update existing record
            $row = $result->fetch_assoc();
            $tasksCompleted += $row['tasksCompleted'];
            $hoursWorked += $row['hoursWorked'];

            $sql = "UPDATE Reports SET tasksCompleted = ?, hoursWorked = ? WHERE userID = ?";
            $stmt = $conn->stmt_init();
            if (!$stmt->prepare($sql)) {
                $error = "SQL statement failed: " . $conn->error;
                $conn->rollback();
                header("Location: ../system_users/userPerformance.php?status=error&message=" . urlencode($error)); // Redirect to index page with error message
                exit();
            } else {
                // Bind parameters
                $stmt->bind_param("iii", $tasksCompleted, $hoursWorked, $userID);
            }
        } else {
            // Insert new record
            $sql = "INSERT INTO Reports (userID, tasksCompleted, hoursWorked)
                    VALUES (?, ?, ?)";
            $stmt = $conn->stmt_init();
            if (!$stmt->prepare($sql)) {
                $error = "SQL statement failed: " . $conn->error;
                $conn->rollback();
                header("Location: ../system_users/userPerformance.php?status=error&message=" . urlencode($error)); // Redirect to index page with error message
                exit();
            } else {
                // Bind parameters
                $stmt->bind_param("iii", $userID, $tasksCompleted, $hoursWorked);
            }
        }

        // Execute statement and handle errors
        if (!$stmt->execute()) {
            $error = "Error executing statement: " . $stmt->error;
            $conn->rollback();
            header("Location: ../system_users/userPerformance.php?status=error&message=" . urlencode($error)); // Redirect to index page with error message
            exit();
        } else {
            $conn->commit();
            header("Location: ../system_users/userPerformance.php?status=success"); // Redirect to index page with success status
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


function getUserID($conn, $empNo)
{
    $sql = "SELECT userID FROM Users WHERE empNo = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empNo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['userID'];
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









function getUserStatus($conn,$userID) {

    // Query to get the latest clocking record for the user
    $query = "SELECT * FROM clockings WHERE UserID = $userID ORDER BY ClockingsID DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    // Check if the user has any clocking records
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $clockOutTime = $row["clockOutTime"];
        $breakEndTime = $row["breakEndTime"];
        
        // Check if the user is currently clocked in
        if ($clockOutTime == NULL) {
            // Check if the user is on break
            if ($breakEndTime == NULL) {
                return "Clocked In";
            } else {
                return "On Break";
            }
        } else {
            return "Clocked Out";
        }
    } else {
        return "Not Clocked In";
    }
}

function clockIn($conn, $userID) {
    $stmt = mysqli_prepare($conn, "INSERT INTO clockings (UserID, clockInTime) VALUES (?, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))");
    mysqli_stmt_bind_param($stmt, "i", $userID);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        return true;
    } else {
        $error = mysqli_stmt_error($stmt);
        if (mysqli_errno($conn) == 1062) {
            return "You have already clocked in";
        } else {
            return "Error: $error";
        }
    }
}

function clockOut($conn, $userID) {

    // Update the latest clocking record for the user with clock-out time
    $query = "UPDATE clockings SET clockOutTime = NOW() WHERE UserID = $userID ORDER BY ClockingsID DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        return "Clocked Out Successfully";
    } else {
        return "Error: " . mysqli_error($conn);
    }
}

function startBreak($conn, $userID) {

    // Update the latest clocking record for the user with break start time
    $query = "UPDATE clockings SET breakStartTime = NOW() WHERE UserID = $userID ORDER BY ClockingsID DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        return "Break Started Successfully";
    } else {
        return "Error: " . mysqli_error($conn);
    }
}

function endBreak($conn, $userID) {

    // Update the latest clocking record for the user with break end time
    $query = "UPDATE clockings SET breakEndTime = NOW() WHERE UserID = $userID ORDER BY ClockingsID DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        // Calculate hours worked and break duration
        $query = "SELECT clockInTime, clockOutTime, breakStartTime, breakEndTime FROM clockings WHERE UserID = $userID ORDER BY ClockingsID DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $clockInTime = strtotime($row["clockInTime"]);
        $clockOutTime = strtotime($row["clockOutTime"]);
        $breakStartTime = strtotime($row["breakStartTime"]);
        $breakEndTime = strtotime($row["breakEndTime"]);
        $hoursWorked = ($clockOutTime - $clockInTime - ($breakEndTime - $breakStartTime)) / 3600;
        $breakDuration = ($breakEndTime - $breakStartTime) / 60;
        
        // Update the latest clocking record for the user with hours worked and break duration
        $query = "UPDATE clockings SET hoursWorked = $hoursWorked, breakDuration = $breakDuration WHERE UserID = $userID ORDER BY ClockingsID DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            return "Break Ended Successfully";
        } else {
            return "Error: " . mysqli_error($conn);
        }
    } else {
        return "Error: " . mysqli_error($conn);
    }
}

function getClockingHistory($conn, $userID) {
    // Retrieve all clocking records for the user
    $query = "SELECT * FROM clockings WHERE UserID = $userID ORDER BY ClockingsID DESC";
    $result = mysqli_query($conn, $query);

    $clockings = array(); // Initialize an empty array to hold the clockings
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Add each clocking to the array
            $clocking = array(
                "id" => $row["ClockingsID"],
                "clockInTime" => $row["clockInTime"],
                "clockOutTime" => $row["clockOutTime"],
                "breakStartTime" => $row["breakStartTime"],
                "breakEndTime" => $row["breakEndTime"],
                "hoursWorked" => $row["hoursWorked"],
                "breakDuration" => $row["breakDuration"]
            );
            $clockings[] = $clocking;
        }
    }
    return $clockings;
}
function displayClockingHistory($conn,$userID) {
    $clockings = getClockingHistory($conn, $userID);

    if (count($clockings) > 0) {
        echo "<table>";
        echo "<tr><th>Clocking ID</th><th>Clock-In Time</th><th>Clock-Out Time</th><th>Break Start Time</th><th>Break End Time</th><th>Hours Worked</th><th>Break Duration</th></tr>";
        foreach ($clockings as $clocking) {
            echo "<tr><td>" . $clocking["id"] . "</td><td>" . $clocking["clockInTime"] . "</td><td>" . $clocking["clockOutTime"] . "</td><td>" . $clocking["breakStartTime"] . "</td><td>" . $clocking["breakEndTime"] . "</td><td>" . $clocking["hoursWorked"] . "</td><td>" . $clocking["breakDuration"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No clocking history found for this user.";
    }
}








