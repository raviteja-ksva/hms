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
	$lt_id=$_POST['lt_id_2'];
	// echo patient_id;

	if (isset($_POST['lt_name']) && !empty($_POST["lt_name"]))
	{
		// echo $_POST['username'];
	    $_POST["lt_name"] = filter_var($_POST["lt_name"], FILTER_SANITIZE_STRING);
	    if ($_POST["lt_name"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["lt_name"];
	} else {
	    $errors .= 'Please enter Lab teck name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['lt_dob']) && !empty($_POST["lt_dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['lt_dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['lt_dob'];

	}  else {
	    $errors .= 'Please enter Lab teck Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['lt_add']) && !empty($_POST["lt_add"]) && trim($_POST["lt_add"]) != "")
	{
		$_POST["lt_add"] = filter_var($_POST["lt_add"], FILTER_SANITIZE_STRING);
	    if ($_POST["lt_add"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['lt_add'];
	}  else {
	    $errors .= 'Please enter a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['lt_phone']) && !empty($_POST["lt_phone"]))
		$phone_no=$_POST['lt_phone'];
	else {
	    $errors .= 'Please enter lab teck phone number.<br/>';
	    $is_error = 1;
	}
	if (isset($_POST['lt_salary']) && !empty($_POST["lt_salary"]))
		$salary=$_POST['lt_salary'];
	else {
	    $errors .= 'Please enter Lab teck salary.<br/>';
	    $is_error = 1;
	}

	

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../edit_lab_teck.php?error='.urlencode($msg));
	    echo $errors;
	}else {
		// select database and setup connection

		$con=mysql_connect('localhost','root','');
		if (!$con) {
	    	die('Could not connect: ' . mysql_error());
		}
		mysql_select_db('hospital');

		$query = "UPDATE lab_teck SET `lt_name`='$name', `address`='$address', `contact`='$phone_no',  `dob`='$dob', `salery`='$salary' WHERE `lt_id`='$lt_id';" ;

		// echo $query;
		if(mysql_query($query))
		{
			// echo 'inerted';
			$lt_id = mysql_insert_id();
			$status = "Lab teck record updated successfull.";
			header('Location: ../admin_home.php?status='.urlencode($status));
		}
		mysql_close($con);
	}
?>