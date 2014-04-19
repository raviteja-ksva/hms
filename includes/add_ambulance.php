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

	




	
	if (isset($_POST['amb_number']) && !empty($_POST["amb_number"]))
		$amb_number=$_POST['amb_number'];
	else {
	    $errors .= 'Please enter correct ambulance number.<br/>';
	    $is_error = 1;
	}


	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	     header('Location: ../reg_ambulance.php?error='.urlencode($msg));
	    echo $errors;
	}

	// select database and setup connection

	$con=mysql_connect('localhost','root','');
	if (!$con) {
    	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('hospital');

	$query="INSERT INTO ambulance (`amb_number`,`avail_status`) VALUES ('$amb_number','1');";
	echo $query;
	if(mysql_query($query))
	{
		// echo 'inerted';
	//	$accountant_id = mysql_insert_id();
		$status = "Ambulance added successfully.\\nAmbulance Number = " . $amb_number;
		header('Location: ../rep_home.php?status='.urlencode($status));
	}
	mysql_close($con);
?>