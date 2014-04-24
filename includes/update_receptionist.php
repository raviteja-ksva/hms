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
	$rep_id=$_POST['rep_id_2'];
	// echo patient_id;

	if (isset($_POST['rep_name']) && !empty($_POST["rep_name"]))
	{
		// echo $_POST['username'];
	    $_POST["rep_name"] = filter_var($_POST["rep_name"], FILTER_SANITIZE_STRING);
	    if ($_POST["rep_name"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["rep_name"];
	} else {
	    $errors .= 'Please enter Receptionist name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['rep_dob']) && !empty($_POST["rep_dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['rep_dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['rep_dob'];

	}  else {
	    $errors .= 'Please enter Receptionist Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['rep_add']) && !empty($_POST["rep_add"]) && trim($_POST["rep_add"]) != "")
	{
		$_POST["rep_add"] = filter_var($_POST["rep_add"], FILTER_SANITIZE_STRING);
	    if ($_POST["rep_add"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['rep_add'];
	}  else {
	    $errors .= 'Please a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['rep_phone']) && !empty($_POST["rep_phone"]))
		$phone_no=$_POST['rep_phone'];
	else {
	    $errors .= 'Please enter Receptionist phone number.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['rep_salary']) && !empty($_POST["rep_salary"]))
		$salary=$_POST['rep_salary'];
	else {
	    $errors .= 'Please enter Receptionist salary.<br/>';
	    $is_error = 1;
	}
if (isset($_POST['rep_shift']) && !empty($_POST["rep_shift"]))
	{
		$shift=$_POST['rep_shift'];
	}  else {
	    $errors .= 'Please enter Receptionist shift.<br/>';
	    $is_error = 1;
	}
	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../edit_receptionist.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection

		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "UPDATE receptionist SET `rep_name`='$name', `address`='$address', `contact`='$phone_no',  `dob`='$dob', `salery`='$salary', `shift`='$shift' WHERE `rep_id`='$rep_id';" ;

		// echo $query;
		if(mysql_query($query))
		{
			// echo 'inerted';
			$rep_id = mysql_insert_id();
			$status = "Receptionist record updated successfull.";
			header('Location: ../admin_home.php?status='.urlencode($status));
		}
		mysql_close($con);
	}
?>