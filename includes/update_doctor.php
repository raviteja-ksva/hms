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
	$doctor_id=$_POST['doctor_id_2'];
	// echo patient_id;

	if (isset($_POST['doctor_name']) && !empty($_POST["doctor_name"]))
	{
		// echo $_POST['username'];
	    $_POST["doctor_name"] = filter_var($_POST["doctor_name"], FILTER_SANITIZE_STRING);
	    if ($_POST["doctor_name"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["doctor_name"];
	} else {
	    $errors .= 'Please enter Doctor name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['doctor_dob']) && !empty($_POST["doctor_dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['doctor_dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['doctor_dob'];

	}  else {
	    $errors .= 'Please enter Doctor Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['doctor_add']) && !empty($_POST["doctor_add"]) && trim($_POST["doctor_add"]) != "")
	{
		$_POST["doctor_add"] = filter_var($_POST["doctor_add"], FILTER_SANITIZE_STRING);
	    if ($_POST["doctor_add"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['doctor_add'];
	}  else {
	    $errors .= 'Please a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['doctor_contact']) && !empty($_POST["doctor_contact"]))
		$phone_no=$_POST['doctor_contact'];
	else {
	    $errors .= 'Please enter Doctor phone number.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['doctor_salary']) && !empty($_POST["doctor_salary"]))
		$salary=$_POST['doctor_salary'];
	else {
	    $errors .= 'Please enter Doctor salary.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['doctor_designation']) && !empty($_POST["doctor_designation"]))
	{
		// echo $_POST['username'];
	    $_POST["doctor_designation"] = filter_var($_POST["doctor_designation"], FILTER_SANITIZE_STRING);
	    if ($_POST["doctor_designation"] == "")
	    {
	        $errors .= 'Please enter a valid Designation.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$designation = $_POST["doctor_designation"];
	} else {
	    $errors .= 'Please enter Doctor designation.<br/>';
	    $is_error = 1;
	}


		if (isset($_POST['doctor_type']) && !empty($_POST["doctor_type"]))
	{
		// echo $_POST['username'];
	    $_POST["doctor_type"] = filter_var($_POST["doctor_type"], FILTER_SANITIZE_STRING);
	    if ($_POST["doctor_type"] == "")
	    {
	        $errors .= 'Please enter a valid type.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$type = $_POST["doctor_type"];
	} else {
	    $errors .= 'Please enter Doctor type.<br/>';
	    $is_error = 1;
	}
	

	if (isset($_POST['doctor_appointment_charge']) && !empty($_POST["doctor_appointment_charge"]))
		$appointment_charge=$_POST['doctor_appointment_charge'];
	else {
	    $errors .= 'Please enter Doctor appointment charge.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['doctor_operation_charge']) && !empty($_POST["doctor_operation_charge"]))
		$operation_charge=$_POST['doctor_operation_charge'];
	else {
	    $errors .= 'Please enter Doctor operation charge.<br/>';
	    $is_error = 1;
	}
	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../edit_doctor.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection

		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "UPDATE doctor SET `doctor_name`='$name', `dob`='$dob', `address`='$address', `salary`='$salary',  `contact`='$phone_no'  , `designation`='$designation', `type`= '$type' , `appointment_charge`='$appointment_charge', `operation_charge`='$operation_charge' WHERE `doctor_id`='$doctor_id';" ;

		 echo $query;
		if(mysql_query($query))
		{
			// echo 'inerted';
			$doctor_id = mysql_insert_id();
			$status = "Doctor record updated successfull.";
			header('Location: ../admin_home.php?status='.urlencode($status));
		}
		mysql_close($con);
	}
?>