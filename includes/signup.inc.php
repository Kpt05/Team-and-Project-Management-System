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

$teamName = $_POST['teamName'];
$department = $_POST['department'];
$teamDescription = $_POST['teamDescription'];
$teamLead = $_POST['teamLead'];
$teamLeadID = $_POST['teamLeadID'];

$random_str = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4); // Generates a random string of 4 characters
$teamID = $department . $random_str; // Concatenates the department value with the random string to generate the teamID

while(true) {
    $sql_check = "SELECT * FROM Teams WHERE teamID = '$teamID'";
    $result_check = mysqli_query($conn, $sql_check);
    if(mysqli_num_rows($result_check) > 0) {
        // If a team record with the generated teamID already exists, generate a new random string and concatenate it with the department value to generate a new teamID
        $random_str = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $teamID = $department . $random_str;
    } else {
        // If no team record with the generated teamID exists, insert the new team record into the Teams table
        break;
    }
}





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


} else if (isset($_POST['createTeam'])) {
    
        //Function call to check for empty fields
        if (emptyInputTeam($teamName, $teamDescription, $department, $teamLeadID) !== false) {
            header(
                "Location: ../teams/createTeam.php?error=emptyinput&message=" . urlencode("Please fill in all the required fields.")
            );
            exit();
        }
    
        //Function call to check if team name already exists
        if (teamNameExists($conn, $teamName) !== false) {
            header("Location: ../teams/createTeam.php?error=teamnamealreadyexists&message=" . urlencode("Team name already exists."));
            exit();
        }
    
        //Function call to check if team ID already exists
        if (teamIDExists($conn, $teamID) !== false) {
            header("Location: ../teams/createTeam.php?error=teamidalreadyexists&message=" . urlencode("Team ID already exists."));
            exit();
        }
    
        //Create a team
        createTeam($conn, $teamID, $teamName, $teamDescription, $department, $teamLeadID, $teamLead);
        exit();

}
