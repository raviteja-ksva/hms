<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

if ($_SESSION['type'] != "patient") {
	$redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
}

include('includes/config.inc');
include('includes/functions.php');
$username = get_username($_SESSION['userid'],$_SESSION['type'], $con);
// echo $username;
?>
<html>
	<head>
		<title>Patient Home Page</title>
	</head>
	<body>
		<p> Hello <?php echo $_SESSION['type'] ?></p>
		<p>This is secured page with session: <b> <?php echo $username; ?></b>
		<br>You can put your restricted information here.</p>

		<p><a href="view_doctor.php" >View doctors</a></p>
		<p><a href="view_prescription.php" >View Prescription</a></p>
			<p><a href="view_appointment.php" >View Appointment</a></p>
			<p><a href="view_medicines.php" >View Available medicines</a></p>
				<p><a href="view_available_tests.php" >View Available tests</a></p>
				<p><a href="view_tests_taken.php" >View  tests taken</a></p>
		<p><a href="chng_pass.php">Change Password</a></p>
		<p><a href="includes/logout.php">Logout</a></p>

	</body>
</html>