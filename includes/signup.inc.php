<?php
// Path: includes\signup.inc.php
// Add error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
print_r($_POST);

require('functions.inc.php'); // Includes the functions.inc.php file
$conn = require __DIR__ . '/dbconfig.php'; // Includes the dbconfig.php file to connect to the database

// User Variables
$empNo = $_POST['empNo']; // Employee number
$accountType = $_POST['accountType']; // Account type
$firstName = $_POST['firstName']; // First name
$middleName = $_POST['middleName']; // Middle name
$lastName = $_POST['lastName']; // Last name
$gender = $_POST['gender']; // gender
$DOB = date('Y-m-d', strtotime($_POST['DOB'])); // Date of birth
$phoneNumber = $_POST['phoneNumber']; // Phone number
$address = $_POST['address']; // Address
$teams = $_POST['teams']; // Teams

$email = $_POST['email']; // Email
$password = $_POST['password']; // Password
$confirmPassword = $_POST['confirmPassword']; // Confirm password

// Team variables
$teamName = $_POST['teamName']; // Team name
$department = $_POST['department']; // Department
$teamDescription = $_POST['teamDescription']; // Team description
$teamLead = $_POST['teamLead']; // Team lead
$teamLeadID = $_POST['teamLeadID']; // Team lead ID

// Generate a random string of 4 characters
$random_str = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4); // Generates a random string of 4 characters
$teamID = $department . $random_str; // Concatenates the department value with the random string to generate the teamID

// Check if a team record with the generated teamID already exists
while (true) { // While loop to generate a new random string and concatenate it with the department value to generate a new teamID if a team record with the generated teamID already exists
    $sql_check = "SELECT * FROM Teams WHERE teamID = '$teamID'"; // SQL query to check if a team record with the generated teamID already exists
    $result_check = mysqli_query($conn, $sql_check); // Executes the SQL query
    if (mysqli_num_rows($result_check) > 0) { // If a team record with the generated teamID already exists
        // If a team record with the generated teamID already exists, generate a new random string and concatenate it with the department value to generate a new teamID
        $random_str = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $teamID = $department . $random_str; // Concatenates the department value with the random string to generate the teamID
    } else {
        // If no team record with the generated teamID exists, insert the new team record into the Teams table
        break;
    }
}

// Project variables
$projectName = $_POST['projectName']; // Project name
$projectDescription = $_POST['projectDescription']; // Project description
$priorityLevel = $_POST['priorityLevel']; // Priority level
$projectStatus = $_POST['projectStatus']; // Project status
$projectLead = $_POST['projectLead']; // DONT USE THIS - JUST TO HELP 

$projectLeadID = $_POST['projectLeadID']; // Project lead ID
$projectTeamID = $_POST['projectTeamID']; // Project team ID
$projectID = "PROD" . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4); // Concatenates "PROD" with a random string of 4 characters to generate the project ID

// Check if a project record with the generated projectID already exists
while (true) {
    $sql_check = "SELECT * FROM Projects WHERE projectID = '$projectID'"; // SQL query to check if a project record with the generated projectID already exists
    $result_check = mysqli_query($conn, $sql_check); // Executes the SQL query
    if (mysqli_num_rows($result_check) > 0) {
        // If a project record with the generated projectID already exists, generate a new random string and concatenate it with "PROD" to generate a new projectID
        $random_str = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $projectID = "PROD" . $random_str; // Concatenates "PROD" with the random string to generate the project ID
    } else {
        // If no project record with the generated projectID exists, insert the new project record into the Projects table
        break;
    }
}

// Report variables
$userID = $_POST['userID']; // User ID
$tasksCompleted = $_POST['tasksCompleted']; // Tasks completed
$tasksAssigned = $_POST['tasksAssigned']; // Tasks assigned
$hoursWorked = $_POST['hoursWorked']; // Hours worked

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
        passwordMatch($password, $confirmPassword) !== false // If password and confirm password do not match
    ) {
        header("Location: ../system_users/createSystemUser.php?error=passwordsdontmatch&message=" . urlencode("Passwords do not match.")); // Redirect to the createSystemUser.php page with an error message
        exit();
    }

    //Function call to check if email already exists
    if (emailExists($conn, $email) !== false) { // If email already exists
        header("Location: ../system_users/createSystemUser.php?error=emailalreadyexists&message=" . urlencode("Email already exists.")); // Redirect to the createSystemUser.php page with an error message
        exit();
    }

    //Function call to check if employee number already exists
    if (empNoExists($conn, $empNo) !== false) { // If employee number already exists
        header("Location: ../system_users/createSystemUser.php?error=useralreadyexists&message=" . urlencode("User already exists.")); // Redirect to the createSystemUser.php page with an error message
        exit();
    }

    //Create a system user
    createUser($conn, $firstName, $middleName, $lastName, $gender, $DOB, $phoneNumber, $address, $accountType, $empNo, $teams, $email, $password); // Function call to create a system user
    exit();

} else if (isset($_POST['createTeam'])) { // If the createTeam button is clicked

    //Function call to check for empty fields
    if (emptyInputTeam($teamName, $teamDescription, $department, $teamLeadID) !== false) { // If any of the required fields are empty
        header(
            "Location: ../teams/createTeam.php?error=emptyinput&message=" . urlencode("Please fill in all the required fields.") // Redirect to the createTeam.php page with an error message
        );
        exit();
    }

    //Function call to check if team name already exists
    if (teamNameExists($conn, $teamName) !== false) { // If team name already exists
        header("Location: ../teams/createTeam.php?error=teamnamealreadyexists&message=" . urlencode("Team name already exists.")); // Redirect to the createTeam.php page with an error message
        exit();
    }

    //Function call to check if team ID already exists
    if (teamIDExists($conn, $teamID) !== false) { // If team ID already exists
        header("Location: ../teams/createTeam.php?error=teamIDalreadyexists&message=" . urlencode("Team ID already exists.")); // Redirect to the createTeam.php page with an error message
        exit();
    }

    //Create a team
    createTeam($conn, $teamID, $teamName, $teamDescription, $department, $teamLeadID, $teamLead); // Function call to create a team
    exit();

} else if (isset($_POST['createProject'])) { // If the createProject button is clicked

    //Function call to check for empty fields
    if (emptyInputProject($projectName, $projectTeamID, $projectLead) !== false) { // If any of the required fields are empty
        header(
            "Location: ../projects/createProjects.php?error=emptyinput&message=" . urlencode("Please fill in all the required fields.") // Redirect to the createProjects.php page with an error message
        );
        exit();
    }

    //Function call to check if project name already exists
    if (projectNameExists($conn, $projectName) !== false) { // If project name already exists
        header("Location: ../projects/createProjects.php?error=projectnamealreadyexists&message=" . urlencode("Project name already exists.")); // Redirect to the createProjects.php page with an error message
        exit();
    }

    //Function call to check if project ID already exists
    if (projectIDExists($conn, $projectID) !== false) { // If project ID already exists
        header("Location: ../projects/createProjects.php?error=projectidalreadyexists&message=" . urlencode("Project ID already exists.")); // Redirect to the createProjects.php page with an error message
        exit();
    }

    //Create a project
    createProject($conn, $projectID, $projectName, $projectDescription, $priorityLevel, $projectStatus, $teamID, $projectLeadID); // Function call to create a project
    exit();

} else if (isset($_POST['userPerformance'])) { // If the userPerformance button is clicked

    //Create a task
    updateUserReport($conn, $userID, $tasksCompleted, $hoursWorked, $tasksAssigned); // Function call to update a user report
    exit();


} else if (isset($_POST['resetRequest'])) { // If the resetRequest button is clicked

    // Function call to check if email already exists
    if (!emailExists($conn, $email)) { // If email does not exist
        header("Location: ../forgotPassword.php?error=emaildoesnotexist&message=" . urlencode("Email does not exist.")); // Redirect to the forgotPassword.php page with an error message
        exit();
    }
    //Create a password reset request
    createPasswordResetRequest($conn, $email); // Function call to create a password reset request
    exit();
}