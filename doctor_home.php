<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
	header('Location: login.php');
}

if ($_SESSION['type'] != "doctor") {
	$redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
}

include('includes/config.inc');
include('includes/functions.php');
$username = get_username($_SESSION['userid'],$_SESSION['type'], $con);
?>
<html>
	<head>
		<title>Doctor Home Page</title>
	</head>
	<body>
	<p> hi Doctor <?php echo $username; ?></p>
	<p> Hello <?php echo $_SESSION['type'] ?> </p>
		<p>This is secured page with session: <b><?php echo $_SESSION['userid']; ?></b>
		<br>You can put your restricted information here.</p>

		<p><a href="give_prex.php">Write Prescription</a></p>
		<p><a href="view_apmt.php">View Appointments</a></p>
		<p><a href="chng_pass.php">Change Password</a></p>
		<p><a href="includes/logout.php">Logout</a></p>

	</body>
</html>