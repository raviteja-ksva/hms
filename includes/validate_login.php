<?php
// Inialize session
session_start();

// Include database connection settings
// include('config.inc');
include('config.inc');
include('functions.php');

// Grab User submitted information
$username = mysql_real_escape_string($_POST["username"]);
$pass = mysql_real_escape_string($_POST["users_pass"]);


	if (validate_login($username, $pass, $con) == true) {
        // Login success 
        $redir  = "Location: ../" . $_SESSION['type'] . "_home.php";
        header($redir);
    } else {
        // Login failed 
        $msg='Incorrect Username or Password';
        header('Location: ../login.php?error='.urlencode($msg));
    }
?>

