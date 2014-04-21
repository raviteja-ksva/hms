<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

if ($_SESSION['type'] != "ph") {
	// $link  = $_SESSION['type'] . "_home.php";
	$redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
}

include('includes/config.inc');
include('includes/functions.php');
$username = get_username($_SESSION['userid'], $_SESSION['type'], $con);

?>

<?php
    if(isset($_GET['status']))
    {
    	$status = $_GET['status'];
       	echo '<script type="text/javascript"> alert("' .  $status .'"); </script>';
	}
?>

        <?php
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
            echo $error . "<br/>" ;
            echo "<p style='color:red'>".$error."</p>" ;
        }
    ?>


<html>
	<head>
		<title>Pharmacist Home Page</title>
	</head>
	<body>
		<p> Hello <?php echo $_SESSION['type'] ?></p>
		<p>This is secured page with session: <b> <?php echo $username; ?></b>
		<br>You can put your restricted information here.</p>

		<p><a href="issue_med.php">Issue medicines</a></p>
		<!-- <p><a href="rep_home.php" target="_blank">Check Doctor slot</a></p> -->

		

		<p><a href="chng_pass.php">Change Password</a></p>
		<p><a href="includes/logout.php">Logout</a></p>


	</body>
</html>