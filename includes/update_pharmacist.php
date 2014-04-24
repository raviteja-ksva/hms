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
	$ph_id=$_POST['ph_id_2'];
	// echo patient_id;

	if (isset($_POST['ph_name']) && !empty($_POST["ph_name"]))
	{
		// echo $_POST['username'];
	    $_POST["ph_name"] = filter_var($_POST["ph_name"], FILTER_SANITIZE_STRING);
	    if ($_POST["ph_name"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["ph_name"];
	} else {
	    $errors .= 'Please enter Pharmacist name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['ph_dob']) && !empty($_POST["ph_dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['ph_dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['ph_dob'];

	}  else {
	    $errors .= 'Please enter Pharmacist Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['ph_add']) && !empty($_POST["ph_add"]) && trim($_POST["ph_add"]) != "")
	{
		$_POST["ph_add"] = filter_var($_POST["ph_add"], FILTER_SANITIZE_STRING);
	    if ($_POST["ph_add"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['ph_add'];
	}  else {
	    $errors .= 'Please enter a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['ph_phone']) && !empty($_POST["ph_phone"]))
		$phone_no=$_POST['ph_phone'];
	else {
	    $errors .= 'Please enter Pharmacist phone number.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['ph_salary']) && !empty($_POST["ph_salary"]))
		$salary=$_POST['ph_salary'];
	else {
	    $errors .= 'Please enter Pharmacist salary.<br/>';
	    $is_error = 1;
	}

	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../edit_pharmacist.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection

		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "UPDATE pharmacist SET `ph_name`='$name', `address`='$address', `contact`='$phone_no',  `dob`='$dob', `salery`='$salary' WHERE `ph_id`='$ph_id';" ;

		// echo $query;
		if(mysql_query($query))
		{
			// echo 'inerted';
			$ph_id = mysql_insert_id();
			$status = "Pharmacist record updated successfull.";
			header('Location: ../admin_home.php?status='.urlencode($status));
		}
		mysql_close($con);
	}
?>