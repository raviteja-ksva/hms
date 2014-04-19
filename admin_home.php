<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

if ($_SESSION['type'] != "admin") {
	// $link  = $_SESSION['type'] . "_home.php";
	$redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
}

include('includes/config.inc');
include('includes/functions.php');
$username = get_username($_SESSION['userid'], $con);

?>

<?php
    if(isset($_GET['status']))
    {
    	$status = $_GET['status'];
       	echo '<script type="text/javascript"> alert("' .  $status .'"); </script>';
	}
?>

<html>
	<head>
		<title>Admin Home Page</title>
	</head>
	<body>
		<p> Hello <?php echo $_SESSION['type'] ?></p>
		<p>This is secured page with session: <b> <?php echo $username; ?></b>
		<br>You can put your restricted information here.</p>

		<p><a href="reg_doctor.php" >Add doctor</a></p>
		<p><a href="reg_driver.php" >Add Driver</a></p>
		<p><a href="reg_ambulance.php" >Add Ambulance</a></p>
		<p><a href="reg_lag_teck.php" >Add lab_teck</a></p>
		<p><a href="reg_nurse.php" >Add nurse</a></p>
		<p><a href="reg_receptionist.php" >Add receptionist</a></p>
		<p><a href="reg_ward_boy.php" >Add ward_boy</a></p>
		<!-- <p><a href="rep_home.php" target="_blank">Check Doctor slot</a></p> -->
		<!-- <p><a href="rep_home.php" target="_blank">Bill payment</a></p> -->

		<p><a href="includes/logout.php">Logout</a></p>


	</body>
</html>