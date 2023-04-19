<?php

/**
 * User object.
 */
class User
{
    public $empNo;
    public $last_failed_attempt_time;
    public $email;
    public $password;
    public $failed_attempts;
    public $accountType;
}

/**
 * This function is called on every single page request.
 * @param $conn The database connection.
 * @return bool True if the user is authenticated, false otherwise.
 */
function authenticate($conn)
{
    // Check if the user is logged in.
    if (!isset($_SESSION['empNo'])) {
        // The user is not logged in.
        header("Location: ../index.php?error=notloggedin");
        exit();
    }

    // Get the user object for the current user.
    $user = getUser($conn, $_SESSION['email']);

    // Check if the user is logged in.
    if ($user == null) {
        // The user is not logged in.
        return false;
    } else {
        // The user is logged in but we need to check the authentication status.

        // Check if the user has exceeded the maximum number of failed attempts.
        if ($user->failed_attempts >= 3) {

            // Check if the last failed attempt was made within the last 3 minutes.
            $last_failed_attempt_time = strtotime($user->last_failed_attempt_time);
            $current_time = time();
            $time_difference = $current_time - $last_failed_attempt_time;
            if ($time_difference < 180) {
                // The user has exceeded the maximum number of failed attempts.
                // Re-direct to the error page.
                header("Location: ../index.php?error=failedattempts");
                return false;
            } else {
                // The user has not exceeded the maximum number of failed attempts.
                // Reset the failed attempts counter.
                $sql = "UPDATE users SET failed_attempts = 0 WHERE email = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    // Re-direct to the error page.
                    header("Location: ../index.php?error=sqlerror");
                    // There is an error in the SQL statement or the database connection.
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $user->email);
                    mysqli_stmt_execute($stmt);
                }
            }
        }

        return true;
    }
}

/**
 * Returns the user object for the current user or null if the user is not logged in.
 * @param $conn The database connection.
 * @param $empNo The employee number of the user.
 * @return User The user object or null if the user is not logged in.
 */
function getUser($conn, $email)
{
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Re-direct to the error page.
        header("Location: ../index.php?error=sqlerror");
        // There is an error in the SQL statement or the database connection.
    } else {

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $user = new User();
            $user->empNo = $row['empNo'];
            $user->last_failed_attempt_time = $row['last_failed_attempt_time'];
            $user->email = $row['email'];
            $user->password = $row['password'];
            $user->failed_attempts = $row['failed_attempts'];
            return $user;
        }
    }
    return new User();
}

function login($conn, $email, $password)
{
    $user = getUser($conn, $email);
    if ($user == null) {
        // The user is not logged in.
        return false;
    } else {
        // The user is logged in but we need to check the authentication status.

        // Check if the user has exceeded the maximum number of failed attempts.
        if ($user->failed_attempts >= 2) {
            // Check if the last failed attempt was made within the last 3 minutes.
            $last_failed_attempt_time = new DateTime($user->last_failed_attempt_time);
            $current_time = new DateTime();
            $time_difference = $current_time->getTimestamp() - $last_failed_attempt_time->getTimestamp();
            if ($time_difference < 180) {
                // The user has exceeded the maximum number of failed attempts.
                // Re-direct to the error page.
                header("Location: ../index.php?error=failedattempts");
                return false;
            } else {
                // The user has not exceeded the maximum number of failed attempts.
                // Reset the failed attempts counter.
                $sql = "UPDATE users SET failed_attempts = 0 WHERE email = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    // Re-direct to the error page.
                    header("Location: ../index.php?error=sqlerror");
                    // There is an error in the SQL statement or the database connection.
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $user->email);
                    mysqli_stmt_execute($stmt);
                }
            }
        }

        // Check if the password is correct.
        $password_hash = $user->password;
        $password_check = password_verify($password, $password_hash);
        if ($password_check == false) {
            // The password is incorrect.
            // Increment the failed attempts counter.
            $last_failed_attempt_time = date('Y-m-d H:i:s');
            //Updating the failed attempt record so that when the user tries to log in again, they will be blocked if the value is large enough.
            $sql = "UPDATE users SET failed_attempts = failed_attempts + 1, last_failed_attempt_time = ? WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                // Re-direct to the error page.
                header("Location: ../index.php?error=sqlerror");
                // There is an error in the SQL statement or the database connection.
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $last_failed_attempt_time, $user->email);
                mysqli_stmt_execute($stmt);
            }

            header("Location: ../index.php?error=incorrectdetails");
            return false;
        } else if ($password_check == true) {
            // The password is correct.
            // Reset the failed attempts counter.
            $sql = "UPDATE users SET failed_attempts = 0 WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                // Re-direct to the error page.
                header("Location: ../index.php?error=sqlerror");
                // There is an error in the SQL statement or the database connection.
            } else {
                mysqli_stmt_bind_param($stmt, "s", $user->email);
                mysqli_stmt_execute($stmt);
            }
            // Log the user in.
            session_start();
            $_SESSION["empNo"] = $user->empNo;
            $_SESSION["email"] = $user->email;
            $_SESSION["accountType"] = $user->accountType;

            return true;
        }
    }
}