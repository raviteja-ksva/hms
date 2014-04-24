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

	$errors = "";
	$is_error = 0;
	$amb_number=$_POST['amb_number_2'];
	echo $_POST['amb_number_2'] . "<br/>";



	echo $_POST['avail_status'] . "<br/>";
	



	if ( !empty($_POST["avail_status"]))
		$avail_status=$_POST['avail_status'];
	else {
	    $errors .= 'Please enter Available status.<br/>';
	    $is_error = 1;
	}

	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    // header('Location: ../edit_ambulance.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection

		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "UPDATE ambulance SET  `avail_status`='$avail_status' WHERE `amb_number`='$amb_number';" ;

		// echo $query;
		if(mysql_query($query))
		{
			// echo 'inerted';
			$patient_id = mysql_insert_id();
			$status = "Ambulance number record updated successfull.";
			header('Location: ../admin_home.php?status='.urlencode($status));
		}
		mysql_close($con);
	}
?>