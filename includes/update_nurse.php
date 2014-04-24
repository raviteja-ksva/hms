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
	$nrs_id=$_POST['nrs_id_2'];
	// echo patient_id;

	if (isset($_POST['nrs_name']) && !empty($_POST["nrs_name"]))
	{
		// echo $_POST['username'];
	    $_POST["nrs_name"] = filter_var($_POST["nrs_name"], FILTER_SANITIZE_STRING);
	    if ($_POST["nrs_name"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["nrs_name"];
	} else {
	    $errors .= 'Please enter Nurse name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['nrs_dob']) && !empty($_POST["nrs_dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['nrs_dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['nrs_dob'];

	}  else {
	    $errors .= 'Please enter Nurse Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['nrs_add']) && !empty($_POST["nrs_add"]) && trim($_POST["nrs_add"]) != "")
	{
		$_POST["nrs_add"] = filter_var($_POST["nrs_add"], FILTER_SANITIZE_STRING);
	    if ($_POST["nrs_add"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['nrs_add'];
	}  else {
	    $errors .= 'Please a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['nrs_phone']) && !empty($_POST["nrs_phone"]))
		$phone_no=$_POST['nrs_phone'];
	else {
	    $errors .= 'Please enter Nurse phone number.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['nrs_salary']) && !empty($_POST["nrs_salary"]))
		$salary=$_POST['nrs_salary'];
	else {
	    $errors .= 'Please enter Nurse salary.<br/>';
	    $is_error = 1;
	}
if (isset($_POST['nrs_shift']) && !empty($_POST["nrs_shift"]))
	{
		$shift=$_POST['nrs_shift'];
	}  else {
	    $errors .= 'Please enter your shift.<br/>';
	    $is_error = 1;
	}
	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../edit_nurse.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection

		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "UPDATE nurse SET `nrs_name`='$name', `address`='$address', `contact`='$phone_no',  `dob`='$dob', `salery`='$salary', `shift`='$shift' WHERE `nrs_id`='$nrs_id';" ;

		// echo $query;
		if(mysql_query($query))
		{
			// echo 'inerted';
			$nrs_id = mysql_insert_id();
			$status = "Nurse record updated successfull.";
			header('Location: ../admin_home.php?status='.urlencode($status));
		}
		mysql_close($con);
	}
?>