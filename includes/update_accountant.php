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
	$accountant_id=$_POST['accountant_id_2'];
	// echo patient_id;

	if (isset($_POST['accountant_name']) && !empty($_POST["accountant_name"]))
	{
		// echo $_POST['username'];
	    $_POST["accountant_name"] = filter_var($_POST["accountant_name"], FILTER_SANITIZE_STRING);
	    if ($_POST["accountant_name"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["accountant_name"];
	} else {
	    $errors .= 'Please enter your name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['accountant_dob']) && !empty($_POST["accountant_dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['accountant_dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['accountant_dob'];

	}  else {
	    $errors .= 'Please enter your Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['accountant_add']) && !empty($_POST["accountant_add"]) && trim($_POST["accountant_add"]) != "")
	{
		$_POST["accountant_add"] = filter_var($_POST["accountant_add"], FILTER_SANITIZE_STRING);
	    if ($_POST["accountant_add"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['accountant_add'];
	}  else {
	    $errors .= 'Please a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['accountant_phone']) && !empty($_POST["accountant_phone"]))
		$phone_no=$_POST['accountant_phone'];
	else {
	    $errors .= 'Please enter your phone number.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['accountant_salary']) && !empty($_POST["accountant_salary"]))
		$salary=$_POST['accountant_salary'];
	else {
	    $errors .= 'Please enter your salary.<br/>';
	    $is_error = 1;
	}
	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../edit_accountant.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection

		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "UPDATE accountant SET `accountant_name`='$name', `address`='$address', `contact`='$phone_no',  `dob`='$dob', `salery`='$salary' WHERE `accountant_id`='$accountant_id';" ;

		// echo $query;
		if(mysql_query($query))
		{
			// echo 'inerted';
			$accountant_id = mysql_insert_id();
			$status = "Accountant record updated successfull.";
			header('Location: ../admin_home.php?status='.urlencode($status));
		}
		mysql_close($con);
	}
?>